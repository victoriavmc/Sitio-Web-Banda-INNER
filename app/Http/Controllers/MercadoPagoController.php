<?php

namespace App\Http\Controllers;

use App\Models\OrdenPago;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario; // Asegúrate de tener el modelo adecuado para tus usuarios
use App\Models\Suscripcion; // Asegúrate de tener el modelo Suscripcion

class MercadoPagoController extends Controller
{
    public function createPaymentPreference(Request $request)
    {
        Log::info('Creando preferencia de pago');
        $this->authenticate();
        Log::info('Autenticado con éxito');

        // Paso 1: Obtener la información del producto desde la solicitud JSON
        $product = $request->input('product'); // Asumiendo que envías un campo 'product' con los datos

        if (empty($product) || !is_array($product)) {
            return response()->json(['error' => 'Los datos del producto son requeridos.'], 400);
        }

        // Paso 2: Información del comprador (esto puedes obtenerlo desde el usuario autenticado) 
        $payer = [
            "name" => $request->input('name'), // Puedes obtener el nombre del request o usar un valor predeterminado
            "surname" => $request->input('surname'),
            "email" => $request->input('email', 'TESTUSER1956922157'),
        ];

        // Paso 3: Crear la solicitud de preferencia 
        $requestData = $this->createPreferenceRequest($product, $payer);

        // Paso 4: Crear la preferencia con el cliente de preferencia 
        $client = new PreferenceClient();

        try {
            $preference = $client->create($requestData);

            return response()->json([
                'id' => $preference->id,
                'init_point' => $preference->init_point,
            ]);
        } catch (MPApiException $error) {
            return response()->json([
                'error' => $error->getApiResponse()->getContent(),
            ], 500);
        } catch (Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    // Autenticación con Mercado Pago 
    protected function authenticate()
    {
        $mpAccessToken = config('services.mercadopago.token');
        if (!$mpAccessToken) {
            throw new Exception("El token de acceso de Mercado Pago no está configurado.");
        }
        MercadoPagoConfig::setAccessToken($mpAccessToken);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    // Función para crear la estructura de preferencia 
    protected function createPreferenceRequest($items, $payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [],
            "installments" => 12,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),  // Redirige aquí después del pago exitoso
            'failure' => route('mercadopago.failed')
        ];

        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "INNER",
            "external_reference" => "1234567890",  // Un identificador único
            "expires" => false,
            "auto_return" => 'approved'
        ];

        return $request;
    }

    private function getPaymentDetails($paymentId)
    {
        $this->authenticate();  // Asegúrate de que la autenticación esté lista

        try {
            $client = new \MercadoPago\Client\Payment\PaymentClient();
            $payment = $client->get($paymentId);

            return [
                'factura' => $payment->id,
                'monto' => $payment->transaction_amount,
                'estadoPago' => $payment->status,
                'metodoPago' => $payment->payment_method_id,
                'email_comprador' => $payment->payer->email,
                'nombreComprador' => $payment->payer->first_name ?? 'N/A',
                'apellidoComprador' => $payment->payer->last_name ?? 'N/A',
                'diaPago' => $payment->date_approved ?? 'Fecha no disponible',
            ];
        } catch (Exception $e) {
            Log::error('Error al obtener los detalles del pago: ' . $e->getMessage());
            return null;
        }
    }

    public function paymentSuccess(Request $request)
    {
        // Obtener los datos enviados por la query string de Mercado Pago
        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            return response()->json(['error' => 'ID de pago no encontrado'], 400);
        }

        // Obtener los detalles del pago usando el payment_id
        $paymentDetails = $this->getPaymentDetails($paymentId);

        dd($paymentDetails);

        if (!$paymentDetails) {
            return response()->json(['error' => 'No se pudieron recuperar los detalles del pago'], 500);
        }

        // Guardar los detalles del pago en la base de datos (ejemplo)
        OrdenPago::create($paymentDetails);
        // Suscripcion::create($paymentDetails);

        return response()->json([
            'success' => 'Pago registrado correctamente',
            'data' => $paymentDetails
        ]);
    }

    public function comprobantePdf(Request $request)
    {
        // Obtener los datos enviados por la query string de Mercado Pago
        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            return response()->json(['error' => 'ID de pago no encontrado'], 400);
        }

        // Obtener los detalles del pago usando el payment_id
        $paymentDetails = $this->getPaymentDetails($paymentId);

        if (!$paymentDetails) {
            return response()->json(['error' => 'No se pudieron recuperar los detalles del pago'], 500);
        }

        // Generar el PDF del comprobante
        $pdf = PDF::loadView('comprobantePDF', compact('paymentDetails'));

        // Descargar el PDF
        return $pdf->stream('comprobante_pago.pdf');
    }
}
