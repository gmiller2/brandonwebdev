<?php
require_once("lib/mysql.php");
require_once("interface.php");
require_once("FormValidator.class.inc");
require_once("utility.php");
?>

<head>
        <meta charset="utf-8">
        <title>Merit Badge College @ RMU - Registration System</title>
       <!--  <meta name="viewport" content="width=device-width, initial-scale=1.0"> -->
        <meta name="description" content="">
        <meta name="author" content="">

        <!-- CSS -->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,100italic,300italic,400italic,700,700italic">
		<link rel="stylesheet" href="lib/bootstrap.min.css">
        <link rel="stylesheet" href="lib/style.css">
        <link rel="stylesheet" href="lib/style.css">
		<link rel="stylesheet" href="bak/form-elements.css">
		 <link rel="stylesheet" href="lib/media-queries.css">

        <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
        <!--[if lt IE 9]>
            <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->

        <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-55359054-1', 'auto');
  ga('require', 'displayfeatures');
  ga('send', 'pageview');

</script>
</head>
<body class="body_loggedin">

<div class="logo_loggedin">

			<ul>
				<li><a href="login">Log In</a></li>
				<li><a href="http://meritbadge.rmu.edu">Back to Home</a></li>
				<li class="mainlogo_loggedin"><a href="http://meritbadge.rmu.edu" style="line-height: 0px;"><img src="images/templogo.png" class="logosize_loggedin"></a></li>
			</ul>

			<div style="clear: both;"></div>

        </div>
        <div id="buffer"></div>

<!--Start Header Table-->

<!--Start Main Table-->
<table class="Standard" border="0" width="80%" style='margin: 0 auto;'><tr>
<td align="center" width="100%">
<?

//Do validation if not the first time through
if(isset($running))
{
	//validate input data
	$fv = new FormValidator;

	$fv->isEmpty("c_name","Contact Name field requires an entry.");
	$fv->isEmpty("c_email","Contact email field requires an entry.");
	$fv->isEmpty("c_phone","Contact Phone field requires an entry.");
	$fv->isEmpty("c_addr1","Contact Address Line 1 field requires an entry.");
	$fv->isEmpty("c_city","Contact City field requires an entry.");
	$fv->isEmpty("c_state","Contact State field requires an entry.");
	$fv->isEmpty("c_zip","Contact Zip Code field requires an entry.");

	$errors = $fv->getErrorList();

	if(sizeof($errors) == 0 )
	//Go into the second round of testing
	{
		$fv->isEmailAddress("c_email","Email Address is not valid.");
		$fv->isZIP("c_zip","Contact Zip code is not valid.");
		$fv->isPhone("c_phone","Contact Phone number is not valid.");
		//$fv->isNumber("troop","Troop number is not valid.");

		$errors = $fv->getErrorList();
	}
}

if(!isset($running))
{
	//Draw form without error checking
	drawRegForm($contact);
}
else if(sizeof($errors) > 0) //there are errors
{
	//Draw form with error checking
	drawErrors($errors);
	drawRegForm($contact);
}
else
{
	//generate password
	$contact[password] = md5($c_pass);
	//Data is good, put it in the dbase then give success

	if(add_contact($contact)){

    // Send notification to Slack that new troop has registered
		$curl = curl_init();
		$fields = array (
			'channel' => '#newtroops',
			'username' => 'NotifyBot',
			'icon_emoji' => ':bey:',
			'text' => 'A new troop has registered for Merit Badge College!'
		);
		$payload = "payload=" . json_encode($fields);

		curl_setopt($curl, CURLOPT_URL,"https://etpi.slack.com/services/hooks/incoming-webhook?token=XXXXXXXXXX");
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($curl, CURLOPT_POST, count($fields));
		curl_setopt($curl, CURLOPT_POSTFIELDS, $payload);

		// Send the request & save response to $resp
		$resp = curl_exec($curl);
		// Close request to clear up some resources
		curl_close($curl);

		?>
		<section id="loginBox">
        <h2 class="maindesc" style="margin: 0; padding: 0px 0 20px 0; font-weight: 600;text-align:center;">THANKS FOR REGISTERING!</h2>
        <p style="text-align:center;">You're now registered for Merit Badge College.</br> <br /> If you forget your password, please email mbc_committee@mail.rmu.edu</p>
        <br />
        <p style="text-align:center!important;"><a href="/login"><button type="submit" class="btn-minimal" value="login">LOG IN</button></a></p>
        <br />
    	</section>
		<?
	}
	else{
	?>
	<section id="loginBox">
        <h2 class="maindesc" style="margin: 0; padding: 0px 0 20px 0; font-weight: 600;text-align:center;">ERROR</h2>
        <p style="text-align:center;">Your troop is already registered.</br> <br /> If you believe this is in error or need assistance, please email mbc_committee@mail.rmu.edu</p>
        <br />
    	</section>
	<?
	}


}
?>
</td>
</tr>
</table>

</body>
</html>
