<?php
  require_once('config.php');
  session_start();

  $stripeamount = $_SESSION['stripeamount'];
  $community = $_SESSION['community'];

  $token  = $_POST['stripeToken'];
  $stripeEmail  = $_POST['stripeEmail'];

  try {
  $customer = \Stripe\Customer::create(array(
     'email' => $stripeEmail,
      'source'  => $token,
	   'description' => $community
  ));

  $charge = \Stripe\Charge::create(array(
      'customer' => $customer->id,
      'amount'   => $stripeamount,
      'currency' => 'usd'
  ));

  $messageh1 = "Thank you!";
  $messageh2 = "Your payment has been successfully processed. If you have any questions, please feel free to contact us. Thanks again!";

  } catch(\Stripe\Error\Card $e) {
  // The card has been declined

  $messageh1 = "We're sorry...";
  $messageh2 = "Sorry, there has been an error processing your payment. Please try again later, and if you are still unable to pay, please contact us.";
}


?>


<!DOCTYPE html>

<html>

<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="description" content="Make a payment to Cranberry Community Management Co." />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

<head>
	<title>Cranberry Community Management Co. | Make a Payment</title>


	<style>

		* {
			margin-top: 2px;
			margin-left: -1px;
			padding: 0;
		}

		input {
			/*padding: 3px; */
		}

		@media only screen
		and (max-width: 525px) {



			span {
				text-align: left;
				padding: 0;

			}

			#nav {
				padding: 20px!important;
			}

			.pageh1 {
				margin-bottom: 0!important;
				padding-bottom: 20px!important;
			}

			.row {
				margin-bottom: 0!important;
			}
		}

	</style>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
		<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.13.1/jquery.validate.min.js"></script>




<link rel=stylesheet href="style.css" type="text/css">

</head>

<body>


<div align="center"><center>

<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; background: #fff; -webkit-box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4);
  -moz-box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4);
  box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4); padding: 10px;">

	  	<td width="100%">
		<p align= "center">
		<div id="cd-logo" style="margin: 0 auto; text-align: center;"><a href="http://cranberrypm.com"><img src="images/logo.png" style="height: 78px; margin: 0 auto; text-align: center;" alt="Logo"></a></div>

		<h3>Make a <a style="color: #C41331;">Payment</a></h3>

		</td>
	  	</tr>

</table>
</center></div>



<div align="center" style="margin-top: 20px; width: 100%; margin-bottom: 30px;"><center>



		<div align="center" style="margin-top: 40px;"><center>

			<ul id="nav" style="max-width: 400px; background-color: #fff; padding: 30px 50px 50px 50px; border-radius: 10px;">


			<div class="pageh1" style="margin: 0 auto; width: 100%; margin-top: 20px; margin-bottom: 0px; text-align: center;"><?php echo ($messageh1); ?></div>



			<div class="row" style="padding: 20px; margin-bottom: 20px; text-align: center;">
			<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: normal; line-height: 28px;"><?php echo ($messageh2); ?></span>
		</label>
		</div

		<div class="row" style="padding: 20px; margin-bottom: -20px; text-align: center;">
			<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: normal;">
			<div class="pagebulletpoints-prov" style="width: 100%; text-align: center; margin: 0 auto;" >
			<a href="http://cranberrypm.com">Return home</a>
			</div>
			</span>
		</label>
		</div>


			</ul>
			</center>
		</div>

</center>

</div>

</body>
</html>
