<?php

namespace Ajmariduena\LaravelPaymentez;

use Zttp\Zttp;

class LaravelPaymentez
{
    private $status_detail_messages = [
        0 =>    'Waiting for Payment.',
        1 =>    'Verification required, please see Verification section.',
        3 =>    'Paid.',
        6 =>    'Fraud.',
        7 =>    'Refund.',
        8 =>    'Chargeback',
        9 =>    'Rejected by carrier.',
        10 =>    'System error.',
        11 =>    'Paymentez fraud.',
        12 =>    'Paymentez blacklist.',
        13 =>    'Time tolerance.',
        14 =>    'Expired by Paymentez',
        19 =>    'Invalid Authorization Code.',
        20 =>    'Authorization code expired.',
        21 =>    'Paymentez Fraud - Pending refund.',
        22 =>    'Invalid AuthCode - Pending refund.',
        23 =>    'AuthCode expired - Pending refund.',
        24 =>    'Paymentez Fraud - Refund requested.',
        25 =>    'Invalid AuthCode - Refund requested.',
        26 =>    'AuthCode expired - Refund requested.',
        27 =>    'Merchant - Pending refund.',
        28 =>    'Merchant - Refund requested.',
        29 =>    'Annulled.',
        30 =>    'Transaction seated (only Ecuador).',
        31 =>    'Waiting for OTP.',
        32 =>    'OTP successfully validated.',
        33 =>    'OTP not validated.',
        34 =>    'Partial refund.',
        35 =>    '3DS method requested, waiting to continue.',
        36 =>    '3DS challenge requested, waiting CRES.',
        37 =>    'Rejected by 3DS.',
    ];

    public function __construct()
    {
        $this->http = Zttp::withOptions([
            'base_uri' => env('PAYMENTEZ_API'),
            'headers' => [
                'auth-token' => $this->generateAuthToken()
            ]
        ]);
    }

    public function listCards($uid)
    {
        return $this->http->get("card/list?uid={$uid}");
    }

    public function deleteCard($token, $userId)
    {
        return $this->http->post("card/delete/", [
            'card' => [
                'token' => $token
            ],
            'user' => [
                'id' => $userId
            ]
        ]);
    }

    public function debit(array $user, array $order, string $token)
    {
        return $this->http->post('transaction/debit/', [
            'user' => [
                'id' => (string) $user['id'],
                'email' => $user['email'],
            ],
            'order' => [
                'amount' => (float) $order['amount'],
                'description' => $order['description'],
                'dev_reference' => (string) $order['dev_reference'],
                'taxable_amount' => 0.00,
                'tax_percentage' => 0.00,
                'vat' => 0.00
            ],
            'card' => [
                'token' => $token
            ]
        ]);
    }

    public function refund($transationId, $moreInfo = false)
    {
        return $this->http->pist('transaction/refund/', [
            'transaction' => [
                'id' => $transationId,
            ],
            'more_info' => $moreInfo
        ]);
    }

    public function generateAuthToken()
    {
        $paymentez_server_application_code = env('PAYMENTEZ_SERVER_KEY');
        $paymentez_server_app_key = env('PAYMENTEZ_SERVER_SECRET');
        $date = new \DateTime();
        $unix_timestamp = $date->getTimestamp();
        $uniq_token_string = $paymentez_server_app_key . $unix_timestamp;
        $uniq_token_hash = hash('sha256', $uniq_token_string);
        $auth_token = base64_encode($paymentez_server_application_code . ";" . $unix_timestamp . ";" . $uniq_token_hash);

        return $auth_token;
    }

    public function getStatusDetailMessage($status_detail)
    {
        return $this->status_detail_messages[$status_detail];
    }
}
