<?php

namespace App\Http\Controller;

use App\Model\Payment;
use Corviz\Database\Query;
use Corviz\Database\Query\WhereClause;
use Corviz\Http\Request;
use Corviz\Http\Response;

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
        $payment->approved = $data['accept'];
        $payment->update();

        //Send to store
        $url = 'http://localhost/webhook/store/public/checkout/accept-payment/';
        $content = json_encode([
            'refid' => $payment->refid,
            'accepted' => $payment->approved == 1
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

        $response = new Response();
        $response->addHeader('location', 'http://localhost/webhook/gateway/public/');

        return $response;
    }
}
