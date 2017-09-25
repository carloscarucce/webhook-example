<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 25/09/2017
 * Time: 00:03
 */

namespace App\Http\Controller;


use App\Model\Payment;

class PaymentsController extends AppController
{
    /**
     * @return \Corviz\Mvc\View
     */
    public function paymentsList()
    {
        $payments = Payment::find();
        return $this->view('payments/list', compact('payments'));
    }
}