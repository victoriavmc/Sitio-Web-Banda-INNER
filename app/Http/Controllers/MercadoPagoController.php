<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use MercadoPago\MercadoPagoConfig;
use MercadoPago\Client\Preference\PreferenceClient;
use MercadoPago\Exceptions\MPApiException;
use Exception;
use Illuminate\Support\Facades\Log;
use App\Models\Usuario; // Asegúrate de tener el modelo adecuado para tus usuarios
use App\Models\Suscripcion; // Asegúrate de tener el modelo Suscripcion

class MercadoPagoController extends Controller
{
    protected function authenticate()
    {
        $mpAccessToken = config('services.mercadopago.token');
        if (!$mpAccessToken) {
            throw new Exception("El token de acceso de Mercado Pago no está configurado.");
        }
        MercadoPagoConfig::setAccessToken($mpAccessToken);
        MercadoPagoConfig::setRuntimeEnviroment(MercadoPagoConfig::LOCAL);
    }

    // Función para crear la estructura de preferencia para un pago único
    protected function createSinglePaymentPreference($payer): array
    {
        $paymentMethods = [
            "excluded_payment_methods" => [], // Puedes personalizar los métodos excluidos si lo necesitas
            "installments" => 1,  // Pago en una sola cuota
            "default_installments" => 1
        ];

        $backUrls = [
            'success' => route('mercadopago.success'),
            'failure' => route('mercadopago.failed')
        ];

        $request = [
            "items" => [
                [
                    "title" => "Subscripción Vitalicia",
                    "description" => "Pago único por la subscripción de por vida a la pagina.",
                    "quantity" => 1,
                    "currency_id" => "ARS",
                    "unit_price" => 1000, // Precio del producto o servicio
                ]
            ],
            "payer" => $payer,
            "payment_methods" => $paymentMethods,
            "back_urls" => $backUrls,
            "statement_descriptor" => "SITIO WEB INNER",
            "external_reference" => "PAGO_UNICO_1234567890",
            "expires" => false,
            "auto_return" => 'approved',
        ];

        return $request;
    }

    public function createPaymentPreference(Request $request)
    {
        Log::info('Creando preferencia de pago único');
        $this->authenticate();
        Log::info('Autenticado con éxito');

        // Paso 1: Obtener el usuario autenticado
        $user = $request->user();

        // Obtener datos personales del usuario
        $personalData = $user->datospersonales;

        // Paso 2: Información del comprador
        $payer = [
            "nombre" => $personalData->nombreDP,
            "apellido" => $personalData->apellidoDP,
            'usuario' => $user->usuarioUser,
            "email" => $user->correoElectronicoUser,
        ];

        // Paso 3: Crear la solicitud de pago único
        $requestData = $this->createSinglePaymentPreference($payer);

        // Paso 4: Crear la preferencia con el cliente de preferencia 
        $client = new PreferenceClient();

        try {
            $preference = $client->create($requestData);

            // Guardar la suscripción en la base de datos
            $subscription = new Suscripcion();
            $subscription->preference_id = $preference->id;
            $subscription->amount = $requestData['items'][0]['unit_price'];
            $subscription->payment_method = 'No especificado';
            $subscription->created_at = now();
            $subscription->usuarios_idusuarios = $user->idusuarios;
            $subscription->save();

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

    public function success(Request $request)
    {
        $preferenceId = $request->query('preference_id');
        return redirect()->route('contenidoPremium')->with('success', '¡Pago realizado con éxito! Bienvenido al contenido premium.');
    }

    public function failed(Request $request)
    {
        $preferenceId = $request->query('preference_id');
        return redirect('/')->with('error', 'El pago no pudo ser completado. Por favor, intenta nuevamente.');
    }
}
