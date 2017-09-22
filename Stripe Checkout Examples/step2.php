<?php require_once('config.php');

session_start();

	$charge = $_POST['charge'];
	$community = $_POST['community'];
	$fee = 15;
	$totalamount = $charge + $fee;
	$stripeamount = $totalamount * 100;

	$_SESSION['charge'] = $charge;
	$_SESSION['community'] = $community;
	$_SESSION['fee'] = $fee;
	$_SESSION['totalamount'] = $totalamount;
	$_SESSION['stripeamount'] = $stripeamount;

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

	  	<tr>
	  	<td width="100%">
		<p align= "center">
		<div id="cd-logo" style="margin: 0 auto; text-align: center;"><a href="http://cranberrypm.com"><img src="images/logo.png" style="height: 78px; margin: 0 auto; text-align: center;" alt="Logo"></a></div>

		<h3>Make a <a style="color: #C41331;">Payment</a></h3>

		</td>
	  	</tr>

</table>
</center></div>




<div align="center" style="margin-top: 20px; width: 100%; margin-bottom: 30px;"><center>


		<div align="center"><center>

		</div>


		<div align="center" style="margin-top: 40px;"><center>



	<ul id="nav" style="max-width: 400px; background-color: #fff;  padding: 30px 50px 50px 50px; border-radius: 10px;">

	<div class="pageh1" style="margin: 0 auto; width: 100%; margin-top: 20px; margin-bottom: 0px; text-align: center;">Confirm Your Payment:</div>


	<div class="row" style="padding: 20px; margin-bottom: 10px; text-align: center;">
		<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333;">Your Community: <strong><?php echo($community); ?></strong></span>



		</label>
		</div>


		<div class="row" style="padding: 20px; margin-bottom: -20px; text-align: right;">
			<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: normal;">Payment Amount: $<?php echo money_format('%=*(#10.2n', $charge) . "\n"; ?></span>
		</label>
		</div>


		<div class="row" style="padding: 20px; margin-bottom: -20px; text-align: right;">
			<label>
			<span style="font-family:'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: normal;">Processing Fee: $<?php echo money_format('%=*(#10.2n', $fee) . "\n"; ?></span>
		</label>
		</div>


		<div class="row" style="padding: 20px; margin-bottom: 20px; text-align: right;">
		<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: bold;">Your Total: $<?php echo money_format('%=*(#10.2n', $totalamount) . "\n"; ?></span>



		</label>
		</div>



<form action="/charge" method="POST">
  <script
    src="https://checkout.stripe.com/checkout.js" class="stripe-button"
    data-key="<?php echo $stripe['publishable_key']; ?>"
    data-image="https://s3.amazonaws.com/stripe-uploads/acct_1676U9EmUEsU9zJfmerchant-icon-1432750028813-stripelogo.png"
    data-name="Cranberry Community Mgmt"
    data-description="Enter your billing details below",
	data-billing-address="true",
    data-zip-code="true",
    data-amount="<?php echo($stripeamount); ?>">
  </script>


	<p style="font-family: Georgia; font-size: 14px; line-height: 22px;"><br/><br/><i>Click the button above to pay via Credit Card using Stripe, a secure payment processing system.</i></p>


	</form>
	</ul>
	</div>

	</td><td width="50%"></td></tr></table></center>

</div>

</body>
</html>
