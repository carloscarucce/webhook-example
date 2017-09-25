<?php

namespace App\Model;

class Payment extends AppModel
{
    protected static $table = 'store_payments';
    protected static $fields = ['id', 'value', 'status'];
    protected static $primaryKey = 'id';
}