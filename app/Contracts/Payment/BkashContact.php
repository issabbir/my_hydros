<?php
namespace App\Contracts\Payment;

interface BkashContact{

    function create_token();

    function create_payment($id_token,$payerReference,$amount,$merchantInvoiceNumber);

    function execute_payment($id_token,$paymentID);
    function query_payment($id_token,$paymentID);

}
