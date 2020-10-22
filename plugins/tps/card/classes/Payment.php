<?php
use October\Rain\Network\Http;
use TPS\Card\Models\Application as CardApp;

class Payment
{

    const REGISTRATION_URI = 'register.do';

    const STATUS_URI = 'getOrderStatus.do';

    const API_URL = 'https://mpi.gov.tm/payment/rest/';

    private function getClient($url){
        return Http::make(self::API_URL.$url, Http::METHOD_POST,[
            'Content-Type' => 'application/json'
        ])->data([
            [
                'userName' => Settings::get('bank_api_user'),
                'password' => Settings::get('bank_api_password'),
                'language' => 'ru',
            ]
        ])->verifySSL()
            ->timeout(3600);
    }

    public static function registerOrder($order_id){

        $client = self::getClient(self::REGISTRATION_URI);

        $client->data([
            'amount'      => Settings::get('application_fee')*100,//multiply by 100 to obtain tenge
            'currency' => 934,
            'sessionTimeoutSecs' => 600,//10 minut
            'description' => 'Kart üçin döwlet pajy.',
            'orderNumber'     => $order_id,

            'failUrl'     => route('paymentReturn', [
                'app_id'             => $order_id,
                'is_payment_cancelled' => 1
            ]),
            'returnUrl' => route('paymentReturn', [
                'app_id'              => $order_id,
                'is_payment_successful' => 1
            ]),

        ]);

        return $client->send();

    }

    public static function getStatus($order_id){
        $client = self::getClient(self::STATUS_URI);

        $client->data([
            'orderId' => $order_id
        ]);

        return $client->send();
    }
}
