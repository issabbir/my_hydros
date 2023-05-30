<?php
/**
 * Created by PhpStorm.
 * User: ashraf
 * Date: 1/26/20
 * Time: 12:46 PM
 */

namespace App\Enums;


class PaymentConstant
{

    public const TOKEN_REQUEST = 'TOKEN_REQUEST';
    public const CREATE_PAYMENT = 'CREATE_PAYMENT';
    public const EXECUTE_PAYMENT = 'EXECUTE_PAYMENT';
    public const QUERY_PAYMENT = 'QUERY_PAYMENT';
    public const SELLING_TRANSACTION_INSERT = 'SELLING_TRANSACTION_INSERT';
    public const SELLING_TRANSACTION_UPDATE = 'SELLING_TRANSACTION_UPDATE';
    public const SELLING_TRANSACTION_COMPLETED = 'SELLING_TRANSACTION_COMPLETED';

}
