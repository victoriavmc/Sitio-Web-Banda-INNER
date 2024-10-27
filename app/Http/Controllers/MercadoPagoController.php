<?php

namespace App\Http\Controllers;

use App\Mail\ComprobantePago;
use App\Models\OrdenPago;
use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario; // Asegúrate de tener el modelo adecuado para tus usuarios

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

        // Paso 2: Información del comprador
        $payer = [
            "name" => $request->input('name'),
            "surname" => $request->input('surname'),
            "email" => $request->input('email'),
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

            // Excluir pago con tarjeta de crédito
            "excluded_payment_types" => [
                ["id" => "credit_card"],
            ],

            // Eliminar cuotas
            "installments" => 1,
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed')
        ];

        $request = [
            "items" => $items,
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "INNER",
            "external_reference" => "1234567890",
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
                'descripcion' => $payment->description,
                'monto' => $payment->transaction_amount,
                'estadoPago' => $payment->status,
                'metodoPago' => $payment->payment_method_id,
                'nomreComprador' => $payment->payer->first_name ?? 'Nombre no disponible',
                'apellidoComprador' => $payment->payer->last_name ?? 'Apellido no disponible',
                'emailComprador' => $payment->payer->email,
                'diaPago' => $payment->date_approved ?? 'Fecha no disponible',
            ];
        } catch (Exception $e) {
            Log::error('Error al obtener los detalles del pago: ' . $e->getMessage());
            return null;
        }
    }

    public function paymentSuccess(Request $request)
    {
        $paymentId = $request->query('payment_id');

        if (!$paymentId) {
            return response()->json(['error' => 'ID de pago no encontrado'], 400);
        }

        $paymentDetails = $this->getPaymentDetails($paymentId);

        if (!$paymentDetails) {
            return response()->json(['error' => 'No se pudieron recuperar los detalles del pago'], 500);
        }

        // Guardar los detalles del pago en la base de datos
        $OrdenPago = new OrdenPago();
        $OrdenPago->factura = $paymentDetails['factura'];

        switch ($paymentDetails['metodoPago']) {
            case 'account_money':
                $metodoPago = 'Dinero en Cuenta';
                break;

            case 'debit_card':
                $metodoPago = 'Tarjeta de Débito';
                break;

            default:
                $metodoPago = $paymentDetails['metodoPago'];
                break;
        }

        switch ($paymentDetails['estadoPago']) {
            case 'approved':
                $estadoPago = 'Aprobado';
                break;

            case 'pending':
                $estadoPago = 'Pendiente';
                break;

            case 'rejected':
                $estadoPago = 'Rechazado';
                break;

            default:
                $estadoPago = $paymentDetails['metodoPago'];
                break;
        }

        $OrdenPago->metodoPago = $metodoPago;
        $OrdenPago->diaPago = $paymentDetails['diaPago'];
        $OrdenPago->estadoPago = $estadoPago;
        $OrdenPago->emailComprador = $paymentDetails['emailComprador'];
        $OrdenPago->nombreComprador =  $paymentDetails['nomreComprador'];
        $OrdenPago->apellidoComprador = $paymentDetails['apellidoComprador'];
        $OrdenPago->precioServicio_idprecioServicio = 1;
        $OrdenPago->usuarios_idusuarios = Auth::user()->idusuarios;
        $OrdenPago->save();

        // Mail::to(Auth::user()->correoElectronicoUser)->send(new ComprobantePago($paymentDetails));

        // Usar el tipo de servicio para actualizar el rol del usuario
        if ($paymentDetails['descripcion'] == 'Suscripción') {
            // Actualizar el estado de la suscripción
            $usuario = Usuario::find(Auth::user()->idusuarios);
            $usuario->rol_idrol = 3; // Cambiar el rol
            $usuario->save();
        }

        // Renderizamos la vista con los detalles del pago
        return view('api.payment-success', compact('paymentDetails'));
    }

    public function comprobantePdf($id)
    {
        // Obtener datos de la base de datos
        $paymentDetails = OrdenPago::where('factura', $id)->first();

        if (!$paymentDetails) {
            return response()->json(['error' => 'No se pudieron recuperar los detalles del pago'], 500);
        }

        // Generar el PDF del comprobante
        $pdf = PDF::loadView('api.comprobantePDF', compact('paymentDetails'));

        // Descargar el PDF
        return $pdf->stream('comprobante_pago.pdf');
    }
}
