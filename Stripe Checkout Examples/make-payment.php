<?php require_once('config.php'); ?>

<!DOCTYPE html>

<html>

<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
<meta http-equiv="description" content="Make a payment to Cranberry Community Management Co." />
<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1">

<head>
	<title>Cranberry Community Management Co. | Make a Credit Card Payment</title>


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


			#payAmount, #communityName {
				width: 90%;
			}

			span {
				text-align: left;
				padding: 0;
				float: left;

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

<table border="0" cellpadding="0" cellspacing="0" style="width: 100%; background-color: #fff; padding: 10px; -webkit-box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4);
-moz-box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4);
box-shadow: 0px 0px 29px -20px rgba(0,0,0,0.4)">

	  	<tr>
	  	<td width="100%" ><p align= "center">

		<div id="cd-logo" style="margin: 0 auto; text-align: center;"><a href="http://cranberrypm.com"><img src="images/logo.png" style="height: 78px; margin: 0 auto; text-align: center;" alt="Logo"></a></div>

		<h3>Make a <a style="color: #C41331;">Credit Card Payment</a></h3></p>

		</td>
	  	</tr>

</table>
</center></div>



<div align="center" style="margin-top: 20px; width: 100%; margin-bottom: 30px;"><center>


		<div align="center"><center>

		</div>


		<div align="center" style="margin-top: 40px;"><center>



	<ul id="nav" style="max-width: 450px; background-color: #fff; padding: 30px 50px 50px 50px; border-radius: 10px;">


	<div class="pageh1" style="margin: 0 auto; width: 100%; margin-top: 20px; margin-bottom: 0px; text-align: center;">Please fill out the form below:</div>


		<form action="/step2" method="post">


		<div class="row" style="padding: 20px; margin-bottom: -20px; text-align: right;">
		<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333; font-weight: bold;">Payment Amount: $</span>
			<input type="text" id="payAmount" name="charge" style="padding: 8px; font-family: Arial; font-size: 14px;" required aria-required="true" >


		</label>
		</div>


		<div class="row" style="padding: 20px; margin-bottom: 10px; text-align: right;">
		<label>
			<span style="font-family: 'Open Sans', Arial, sans-serif; font-size: 17px; padding: 8px; color: #333;">Your Community: </span>
			<input id="communityName" name="community" type="text" style="padding: 8px; font-family: Arial; font-size: 14px;" required aria-required="true" >


		</label>
		</div>



		 <input id="customButton" type="submit"
			style="margin-left: 12px; padding: 12px 26px 24px 18px; border: 0px solid blue; color:white; background: url(images/redbtn.png) no-repeat; cursor:pointer; font-weight: bold; font-family: Arial; font-size: 13px;" value="Click to Continue">



		<p style="font-family: Georgia; font-size: 14px; line-height: 22px;"><br/><br/><i>Please note: There is a <strong>$15 charge</strong> for this service that will be automatically added onto your payment amount.</i></p>


		</form>


		<script>

		$('#customButton').on('click', function(e) {

					var CurrencyField = $('#payAmount').val()
				  //return amount without $
				  $('#payAmount').val( CurrencyField.replace('$', '') );

		});

		</script>

		</ul>


		</div>

	</td><td width="50%"></td></tr></table></center>

</div>

</body>
</html>
