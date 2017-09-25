<?php

namespace App\Http\Controller;

use App\Model\Payment;
use Corviz\Database\Query;
use Corviz\Database\Query\WhereClause;
use Corviz\Http\Request;

class Home extends AppController
{
    /**
     * Index action handler.
     */
    public function index()
    {
        $payments = Payment::find(function(Query $query){
            $query->where(function(WhereClause $where){
                $where->and('approved', '=', '?');
            });
            $query->bind(0);
        });

        return $this->view('home/index', compact('payments'));
    }

    public function receive()
    {
        $data = Request::current()->getData();

        $payment = new Payment();
        $payment->refid = $data['refid'];
        $payment->value = $data['value'];
        $payment->approved = 0;
        $payment->insert();
    }

    /**
     *
     */
    public function updateStatus()
    {
        $data = Request::current()->getData();
        $payment = Payment::load($data['payment_id']);
        $payment->accepted = $data['accept'];
        $payment->update();

        //Send to gateway
        $ch = curl_init('http://localhost/webhook/store/public/checkout/accept-payment/');
        $payload = json_encode([
            'refid' => $payment->refid,
            'accepted' => $payment->accepted == 1
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

        $response = new Response();
        $response->addHeader('location', 'http://localhost/webhook/gateway/public/');

        return $response;
    }
}
