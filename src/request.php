<?php

use PayPal\Api\Amount;
use PayPal\Api\Payer;
use PayPal\Api\Payment;
use PayPal\Api\RedirectUrls;
use PayPal\Api\Transaction;

require '../bootstrap.php';

if (empty($_POST['item_number'])) {
    throw new Exception('This script should not be called directly, expected post data');
}
if(isset($_POST['set_amount']) && !empty($_POST['set_amount'])){
    $set_amount=$_POST['set_amount'];
}else{
    $set_amount=1.00;
}
if(isset($_POST['currency']) && !empty($_POST['currency'])){
    $currency=$_POST['currency'];
}else{
    $currency='SGD';
}
$payer = new Payer();
$payer->setPaymentMethod('paypal');

// Set some example data for the payment.
$currency = $currency;
$amountPayable = $set_amount;
$invoiceNumber = uniqid();

$amount = new Amount();
$amount->setCurrency($currency)
    ->setTotal($amountPayable);
$transaction = new Transaction();
$transaction->setAmount($amount)
    ->setDescription('Some description about the payment being made')
    ->setInvoiceNumber($invoiceNumber);

$redirectUrls = new RedirectUrls();
$redirectUrls->setReturnUrl($paypalConfig['return_url'])
    ->setCancelUrl($paypalConfig['cancel_url']);

$payment = new Payment();
$payment->setIntent('sale')
    ->setPayer($payer)
    ->setTransactions([$transaction])
    ->setRedirectUrls($redirectUrls);

try {
    $payment->create($apiContext);
} catch (Exception $e) {
    throw new Exception('Unable to create link for payment');
}

header('location:' . $payment->getApprovalLink());
exit(1);
