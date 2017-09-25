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
        $url = 'http://localhost/webhook/gateway/public/receive';
        $content = json_encode([
            'value' => $payment->value,
            'refid' => $payment->id,
        ]);

        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER,
            array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);

        $json_response = curl_exec($curl);

        $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

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