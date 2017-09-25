<?php

namespace App\Model;

class Payment extends AppModel
{
    protected static $table = 'gateway_payments';
    protected static $fields = ['id', 'refid', 'value', 'approved'];
    protected static $primaryKey = 'id';
}
