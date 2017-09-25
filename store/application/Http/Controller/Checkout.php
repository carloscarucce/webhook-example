<?php

namespace App\Http\Controller;

use App\Model\Payment;
use Corviz\Http\Request;
use Corviz\Http\Response;

class Checkout extends AppController
{
    public function acceptPayment()
    {
        $data = Request::current()->getData();

        $payment = Payment::load($data['refid']);
        $payment->status = $data['accepted'] ? 'accepted' : 'rejected';
        $payment->update();
    }

    /**
     * @return \Corviz\Mvc\View
     */
    public function cart()
    {
        return $this->view('checkout/cart');
    }

    /**
     * Store order and send payment data
     */
    public function send()
    {
        //Store in database
        $payment = new Payment();
        $payment->value = 30;
        $payment->status = 'pending';
        $payment->insert();

        //Send to gateway
        $ch = curl_init('http://localhost/webhook/gateway/public/payment/create');
        $payload = json_encode([
            'value' => $payment->value,
            'refid' => $payment->id,
        ]);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: '.strlen($payload),
        ));
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);
        curl_close($ch);

        //region redirect
        $response = new Response();
        $response->addHeader('location', 'http://localhost/webhook/store/public/checkout/sent');

        return $response;
        //endregion
    }

    /**
     * @return \Corviz\Mvc\View
     */
    public function sent()
    {
        return $this->view('checkout/sent');
    }
}