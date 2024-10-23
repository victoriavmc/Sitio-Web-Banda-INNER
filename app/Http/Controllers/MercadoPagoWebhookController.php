<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\OrdenPago; // Modelo para guardar los pagos en la BD
use MercadoPago\SDK;

class MercadoPagoWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // Guarda la notificación en los logs para revisión
        Log::info('Webhook recibido', $request->all());

        $data = $request->all();

        // Verifica si la notificación es de tipo "payment"
        if (isset($data['type']) && $data['type'] == 'payment') {
            $paymentId = $data['data']['id']; // ID del pago enviado en la notificación

            // Obtén los detalles completos del pago
            $paymentDetails = $this->getPaymentDetails($paymentId);

            if ($paymentDetails) {
                // Guarda los detalles en la base de datos
                OrdenPago::create([
                    'id_pago' => $paymentDetails['id'],
                    'monto' => $paymentDetails['monto'],
                    'estado' => $paymentDetails['estado'],
                    'metodo' => $paymentDetails['metodo'],
                    'email_comprador' => $paymentDetails['email_comprador'],
                ]);

                return response()->json(['status' => 'success']);
            }
        }

        return response()->json(['status' => 'ignored']);
    }

    private function getPaymentDetails($paymentId)
    {
        try {
            // Usamos la configuración correcta con el token ya autenticado
            $paymentClient = new \MercadoPago\Client\Payment\PaymentClient();

            // Buscamos los detalles del pago por ID
            $payment = $paymentClient->get($paymentId);

            // Retornamos la información relevante
            return [
                'id' => $payment->id,
                'monto' => $payment->transaction_amount,
                'estado' => $payment->status,
                'metodo' => $payment->payment_method_id,
                'email_comprador' => $payment->payer->email,
            ];
        } catch (\MercadoPago\Exceptions\MPApiException $e) {
            Log::error('Error al obtener los detalles del pago: ' . $e->getMessage());
            return null;
        } catch (\Exception $e) {
            Log::error('Error inesperado: ' . $e->getMessage());
            return null;
        }
    }
}
