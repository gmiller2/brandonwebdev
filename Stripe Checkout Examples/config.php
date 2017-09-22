<?php
require_once('stripe-php/init.php');


// live keys
$stripe = array(
  "secret_key"      => "sk_live_XXXXXXXXXXXXXXXXXXXXXXXX",
  "publishable_key" => "pk_live_XXXXXXXXXXXXXXXXXXXXXXXX"
);

\Stripe\Stripe::setApiKey($stripe['secret_key']);
?>
