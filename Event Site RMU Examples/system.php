<?
session_start();
if(isset($_SESSION['admin'])){
setcookie("admin", "Yes", time()+3600);
}
else{};


if(!session_is_registered("SESSION"))
{
	//if session check fails, invoke error handler
	header("Location: error?e=2");
	exit();
}

require_once("interface.php");
require_once("lib/mysql.php");


//actions that must occur first
switch($action){
	case 1://change troop
		if(isset($_SESSION['admin'])){
			$_SESSION['troop'] = $newtroop;

		}
		break;
	case 2: //add class
		if(isset($_SESSION['admin'])){
			addClass($name,$section,$capacity,$teach,$room,$period,$length);
		}
		break;
	case 3: //add session
		if(isset($_SESSION['admin'])){
			addSession($new_year,$new_chair);
		}
		break;
	case 4: //delete class
		if(isset($_SESSION['admin'])){
			deleteClass($id);
		}
		break;
	case 5: //add scout, tshirt size
		addScout($f_name,$l_name,$tshirt,$_SESSION['troop']);
		break;
	case 6: //delete scout
		deleteScout($id);
		break;
	case 7: //remove scout from current roster
		removeScout($id,$_SESSION['year']);
		break;
	case 8: //
		break;
	case 9:
		updateRegisterScout($id,$_SESSION['year'],$c1,$c2,$c3,$c4,$lunch);
		break;
	case 10:
		registerScout($id,$_SESSION['year'],$c1,$c2,$c3,$c4);
		break;
	case 11:
		editClass($name,$section,$capacity,$teach,$room,$period,$length,$id);
		break;
	case 12://
		break;
	case 13://update registration info
		update_contact($contact);
		break;
	case 14:
		//Open / Close Registration
		toggleRegistration($status);
	default:
		break;
}

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
        <meta charset="utf-8">
        <title>Merit Badge College @ RMU - Registration System</title>
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" type="image/x-icon" href="/favicon.ico">

        <!-- CSS -->

        <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Roboto:400,300,100,100italic,300italic,400italic,700,700italic">
		<link rel="stylesheet" href="lib/bootstrap.min.css">
        <link rel="stylesheet" href="lib/style.css">
		<link rel="stylesheet" href="bak/form-elements.css">
		<link rel="stylesheet" href="lib/media-queries.css">

		<!-- Google Charts -->
		<script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

    // Load the Visualization API and the piechart package.
    google.load('visualization', '1', {packages:['corechart']});

    // Set a callback to run when the Google Visualization API is loaded.
    google.setOnLoadCallback(drawChart);

    function drawChart() {
      var jsonData = $.ajax({
          url: "class_capacity.php",
          dataType:"json",
          async: false
          }).responseText;
       var jsonData1 = $.ajax({
          url: "lunch_percent.php",
          dataType:"json",
          async: false
          }).responseText;
        var jsonData2 = $.ajax({
          url: "register_stats.php",
          dataType:"json",
          async: false
          }).responseText;

      // Create data table out of JSON data loaded from server.
      var data = new google.visualization.DataTable(jsonData);
      var data1 = new google.visualization.DataTable(jsonData1);
      var data2 = new google.visualization.DataTable(jsonData2);

      // Instantiate and draw chart, passing in some options.
      var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
      chart.draw(data, {width: 500, height: 400,legend:{position:'none'},vAxis:{maxValue:100}});

      var chart1 = new google.visualization.PieChart(document.getElementById('chart_div1'));
      chart1.draw(data1, {width: 500, height: 400, pieHole:0.4,legend:{position:'none'}, pieSliceText:'label'});

      var chart2 = new google.visualization.PieChart(document.getElementById('chart_div2'));
      chart2.draw(data2, {width: 500, height: 400, pieHole:0.4});
    }


    </script>
		<!-- End Google Charts -->

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
				<li><a href="logout.php">Log out</a></li>
				<li><a href="system?option=12">View Schedule</a></li>
				<li><a href="system?option=2">Troop Roster</a></li>
				<li><a href="system">Home</a></li>
				<li class="mainlogo_loggedin"><a href="/system" style="line-height: 0px;"><img src="images/templogo.png" class="logosize_loggedin"></a></li>
			</ul>

			<div style="clear: both;"></div>

        </div>

	<!-- this div prevents things from being hidden under the nav bar -->
	<div id="buffer"></div>


	<!-- this is the "registration is open / closed" notification div -->
	<? if(isRegistrationOpen()) : ?>
	        	<div id="registrationnotif_loggedin" class="regopen_loggedin">
		Registration is <strong>open!</strong>
	</div>
	<? else : ?>
	  <div id="registrationnotif_loggedin" class="regclosed_loggedin">
		Registration is <strong>closed</strong>
		</div>
	<? endif; ?>


<!-- Start Main Table -->
<? if(isset($_SESSION['admin']))
{
?>
<table border="0" width="88%" cellspacing="0" cellpadding="0" style="margin:0 auto;">
<tr>
<td valign='top' width="12%">
<!--Lefthand Admin Menu-->
<?
	drawCurrentTroop($_SESSION['troop']);
	drawAdminMenu();
	drawAdminExportMenu();
?>
</td>
<td width="1%"> </td>

<td width="73%" valign="top">
<?
}
?>
<!--Case statement...chooses what menu items we want and were the data should go-->
<?
if(!isset($option))
//if option is not set, send to stats page
{
	$option = 1;
}

switch($option){
	case 1:
    ?>
        <?
        if(isset($_SESSION['admin'])){
        	?>
       	<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>ADMIN DASHBOARD</h2>
        </div>
        <?
        }
        else{ ?>
        <div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>REGISTRATION DASHBOARD</h2>
        </div>
        <? } ?>

        <!-- Start Main Table -->
        <table border='0' style='width: 88%; margin:0 auto;'>

            <tr>
                <td valign='top' style='float: left; width: 30%;'>
                    <!--Lefthand Menu-->

                    <div class='leftwidget_loggedin'>

                        <h2 class='troopname_loggedin'>
                            <?
                            if(isset($_SESSION['admin'])){
								print ($year);
								echo " STATISTICS";
							}
							else {
								print("Troop ");
								print($_SESSION['troop']);
							}
             	?>
                        </h2>

                        <h2 class='scoutsroster_loggedin'>
                            <?
                            if(isset($_SESSION['admin'])){
								print(getAdminStats());
							}
							else {
								print(getNumScouts($troop));
							}
              ?>
                        </h2>

                        <p class='scoutsrosterdesc_loggedin'>
                            Scouts on Attendance Roster
                        </p>



                        <h2 class='scoutsroster_loggedin'>
                            <?
                            if(isset($_SESSION['admin'])){
								print(getAdminRegStats($year));
							}
							else {
								print(getNumScoutsReg($troop,$year));
							}
                            ?>
                        </h2>

                        <p class='scoutsrosterdesc_loggedin'>
                            Scouts Registered for Classes
                        </p>


<?
                        if(isset($_SESSION['admin'])){
                        ?>
                         <h2 class='scoutsroster_loggedin'>
             				<?
             				print(getNumTroops($year));
             				?>
                        </h2>

                        <p class='scoutsrosterdesc_loggedin'>
                            Troops Registered
                        </p>
                        <?
                    }
                    ?>

                    </div><!-- end left widget -->

                </td>

                <td valign='top' style='float: right; width: 65%;'>


                	<?
                	if(isset($_SESSION['admin'])){
                		?>
                			<div class="leftwidget_loggedin" style="width:100%;">
    						<h2 class="troopname_loggedin">Class Capacity</h2>
    						<div align="center" id="chart_div"></div>
                			</div>
                			<div class="leftwidget_loggedin" style="width:100%;">
                			<h2 class="troopname_loggedin">Lunch Orders</h2>
                			<div align="center" id="chart_div1"></div>
                			</div>
                			<div class="leftwidget_loggedin" style="width:100%;">
                			<h2 class="troopname_loggedin">Troop Locations</h2>
                			<div align="center" id="chart_div2"></div>
                			</div>

                	<?
                	}
                	else{
                	?>

                    <div class='rightwidget_loggedin'>

                        <a href='system?option=2'>
                            <div id='step_loggedin' class='step1' style='background-color: #2285C8;'>

                                <div style='float: left;'>
                                    <img src='images/add_check.png' style='height: 74px; margin-top: -5px;'>
                                </div>
                                <div style='float: left; margin-left: 20px;'>
                                    <p>Step 1:</p>
                                    <h3>Add Scouts to Roster</h3>
                                </div>

                            </div></a>

                        <a href='system?option=3'>
                            <div id='step_loggedin' class='step2' style='background-color: #D5394B;'>

                                <div style='float: left;'>
                                    <img src='images/register_check.png' style='height: 74px;'>
                                </div>

                                <div style='float: left; margin-left: 20px;'>
                                    <p>Step 2:</p>
                                    <h3>Register Scouts for Classes</h3>
                                </div>

                            </div></a>



<? if(isRegistrationOpen()) : ?>
													<!-- href=#, or When time to pay href=system?option=14-->
                           <a href="#">
                                <div id='step_loggedin' class='step3_beforepayment' style='background-color: #bbb; '>

                                    <div style='float: left;'>
                                        <img src='images/dollar_check.png' style='height: 74px; margin-top: -5px;'>
                                    </div>

                                    <div style='float: left; margin-left: 20px;'>
                                        <p style='color: #fff;'>Step 3:</p>
                                        <h3 style='color: #fff;'>Make Payment <span style='font-size: 12px;'></span></h3>
                                    </div></div></a>
            <div class='stepoverlay'>
				<p>
				This option is not available until registration closes.
				</p>
			</div>
	<? else : ?>
                           <a href="system?option=14"> <!-- Time to pay - option available now-->
                                <div id='step_loggedin' class='step3' style='background-color: #bbb; '>

                                    <div style='float: left;'>
                                        <img src='images/dollar_check.png' style='height: 74px; margin-top: -5px;'>
                                    </div>

                                    <div style='float: left; margin-left: 20px;'>
                                        <p style='color: #fff;'>Step 3:</p>
                                        <h3 style='color: #fff;'>Make Payment <span style='font-size: 12px;'></span></h3>
                                    </div></div></a>
	<? endif; ?>

  </div>
  <?
  }
	?>

                    </div>
                </td>
            </tr>
        </table>


        <div class='leftwidget_loggedin' style='width: 88%; text-align: center; margin-top: 20px;'>

            Contact us via email at <a href='mailto:xxxxxx@mail.rmu.edu'>xxxxxxxx@mail.rmu.edu</a> with any questions

        </div>
    <?
        break;
	case 2:
		if(troopExists($_SESSION['troop']))
		{
			?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>TROOP ROSTER</h2>
</div>


<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawTroopRoster($_SESSION['troop']);
			drawAddScout();
		}
		break;
	case 3:
		if(troopExists($_SESSION['troop'])){

			?>
<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>REGISTER SCOUTS</h2>
</div>


<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawRegisterScout();
			if($action == '8'){
				drawUpdateScoutReg($id,$_SESSION['year']);
			}

			?>
			<div style='width: 100; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 30px 0 10px 0; font-weight: 600; font-size: 22px;'>SCOUTS REGISTERED FOR <? print($year) ?></h2>
</div>
			<?
			drawListRegistered($_SESSION['year'],$_SESSION['troop']);
		}
		break;
	case 4:
		if(troopExists($_SESSION['troop'])){
			getContactInfo($_SESSION['troop'],&$info);
			 drawRegEditForm($info);
		}
		break;
	case 5:
		if(isset($_SESSION['admin'])){
			drawAddClass();
		}
		break;
	case 6:
		if(isset($_SESSION['admin'])){
			?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>SELECT TROOP</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawSelectTroop();
			drawTroopList($_SESSION['year']);
		}
		break;
	case 7:
		if(isset($_SESSION['admin'])){
									?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>ADD CLASS</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawAddClass();
			if($action == '12')
				drawEditClass($id);
			drawListClasses();
		}
		break;
	case 8:
		if(isset($_SESSION['admin'])){
		?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>ADD SESSION</h2>
			</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawAddSession();
		}
		break;

	case 9:
		if(isset($_SESSION['admin'])){
															?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>EXPORT SPECIFIC CLASS</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			//specific class
			drawExportSpecificClass();
		}
		break;

	case 10:
		if(isset($_SESSION['admin'])){
																	?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>EXPORT SPECIFIC TROOP</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			//specific troop
			drawExportSpecificTroop();
		}
		break;

	case 11:
		if(isset($_SESSION['admin'])){
												?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>OPEN OR CLOSE REGISTRATION</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			//open / close registration
			drawToggleRegistration();
		}
		break;

	case 12:

		if(troopExists($_SESSION['troop']))
			?>
	<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>SCOUTS REGISTERED FOR <? print($year) ?></h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
			drawListRegistered($_SESSION['year'],$_SESSION['troop']);
		break;

	case 13:
		if(troopExists($_SESSION['admin'])){
			getContactInfo($_SESSION['admin'],&$info);
			 drawRegEditForm($info);
		}

	default:
		break;
    case 14:
        if(isset($_SESSION['admin'])){
        	?>
			<div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>THE FOLLOWING TROOPS HAVE PAID:</h2>
</div>
<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
<table class='S_MENU_BODY' width='100%'>
			<?
        	//print("The following troops paid:");
        	?>
        	<br/>
        	<?
        	require_once('_lib/Stripe.php');
			Stripe::setApiKey("sk_live_XXXXXXXXXXXXXXXXXXXXXXXX");

        	$charges = Stripe_Charge::all();
        	$data1 = $charges->data;

        	foreach ($data1 as $key => $value) {
        		$dollar = (($value->amount)/100);

        		echo $value->description;
        		echo ' - ';
        		echo '$'.$dollar;
        		?>
        		<br/>
        		<?
        	}
		}
        if(troopExists($_SESSION['troop'])){
            require_once('_lib/config.php');
           	require_once('lib/mysql.php');
           	$cemailq = (mysql_query("select c_email from troop where troop = '$troop'"));
           	$cemail = (mysql_result($cemailq, 0));
	      	$lunchdue = (mysql_query("select count(*) from register, student where student.troop = '$troop' and register.student_id = student.id and register.lunch = 1"));
	      	$lunchduesafe = (mysql_result($lunchdue, 0));
	      	$nolunchdue = (mysql_query("select count(*) from register, student where student.troop = '$troop' and register.student_id = student.id and register.lunch = 0"));
	      	$nolunchduesafe = (mysql_result($nolunchdue, 0));
	      	$lunch = ($lunchduesafe * 20);
	      	$nolunch = ($nolunchduesafe * 10);
	      	$dueamt = ($lunch + $nolunch);
            $amtdue = ($dueamt*100); ?>

            <?if($dueamt==0){
            	?>
            	<div class='leftwidget_loggedin' style='width: 88%; text-align: center; margin-top: 20px;'>

	No Payment Currently Required. <br /> You currently owe <strong>$<?echo($friendlyamtdue); ?></strong> For the Scouts you have registered.

	</div>
            	<?
            }
            else{?>

            <div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 50px 0 0px 0; font-weight: 600;'>MAKE PAYMENT</h2>
</div>
			<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>

            <h2 class='maindesc' style='margin: 0; padding:0px 0 30px; font-weight:600; font-size: 22px;'>Welcome Troop <? print($troop); ?>,</h2>
            <p>You currently have <b><? print(getNumScoutsReg($troop,$year));?> Scouts </b> registered.
                This comes to a total of <b> $<? print($dueamt);?>. </b></p>
            <br />
            <?
            if ($amtdue != 0){
            ?>
            <p>
                Please click the button below to pay with a Credit Card, or send a check to:
            <br/>
            <br/>
            <b>Epsilon Tau Pi</b>
            <br/>
                6001 University Blvd
            <br/>
                Box XXXX
            <br/>
                Moon Township, PA 15108</p>
            <br/>

            <form action='system?option=15' method='post'>
                <script src='https://checkout.stripe.com/checkout.js' class='stripe-button'
                data-key="<?php echo $stripe['publishable_key']; ?>"
                data-amount="<? echo $amtdue; ?>"
                data-description="Troop <? print($troop); ?>"
                data-name="ETPi - Merit Badge College"
                data-image="images/logo.png"
                data-zip-code="true">
                </script>
            </form>
            </p>


			<br/>

			<p><i>Payments are processed through <a target="_blank" href="https://stripe.com/">Stripe</a>, so your Credit Card information is safe and secure.</i></p>
		<?
        }
        ?>
		</div>
		<?
		}
		?>
		<div class='leftwidget_loggedin' style='width: 88%; text-align: center; margin-top: 20px;'>

	Contact us via email at <a href='mailto:XXXXXXXX@mail.rmu.edu'>XXXXXXXX@mail.rmu.edu</a> with any questions

	</div>
    <?
        }
        break;

    case 15:
         if(troopExists($_SESSION['troop'])){
             require_once('_lib/config.php');
	     	 require_once('lib/mysql.php');
	     	$cemailq = (mysql_query("select c_email from troop where troop = '$troop'"));
           	$cemail = (mysql_result($cemailq, 0));
	      	$lunchdue = (mysql_query("select count(*) from register, student where student.troop = '$troop' and register.student_id = student.id and register.lunch = 1"));
	      	$lunchduesafe = (mysql_result($lunchdue, 0));
	      	$nolunchdue = (mysql_query("select count(*) from register, student where student.troop = '$troop' and register.student_id = student.id and register.lunch = 0"));
	      	$nolunchduesafe = (mysql_result($nolunchdue, 0));
	      	$lunch = ($lunchduesafe * 20);
	      	$nolunch = ($nolunchduesafe * 10);
	      	$dueamt = ($lunch + $nolunch);
	            $amtdue = $dueamt*100; /*This converts the dollars to cents for Stripe */
              $desc1 = 'Troop ';
              $desc2 = ' Scouts';
              $numscouts = (' - '.getNumScoutsReg($troop,$year));

             $token  = $_POST['stripeToken'];

             $customer = Stripe_Customer::create(array(
                 'description' => $desc1.$troop,
                 'email' => $cemail,
                 'card'  => $token
             ));

             $charge = Stripe_Charge::create(array(
                 'customer' => $customer->id,
                 'amount'   => $amtdue,
                 'currency' => 'usd',
                 'description' => $desc1.$troop.$numscouts.$desc2
             ));

             ?>
			<div class='leftwidget_loggedin' style='width: 88%; padding: 40px;'>
             <div style='width: 88%; margin: 0 auto;'><h2 class='maindesc' style='margin: 0; padding: 0px 0 0px 0; font-weight: 600;'>Successfully charged $<? print($dueamt); ?>!</h2>
</div>
         </div>
         		<div class='leftwidget_loggedin' style='width: 88%; text-align: center; margin-top: 20px;'>

	</div>
             <?
            }
    break;
}




?>


<!-- Javascript -->

	 	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script>
			$(document).ready(function() {
				function scrollToAnchor(aid){
					var aTag = $("a[name='"+ aid +"']");
					$('html,body').animate({scrollTop: aTag.offset().top},'slow');
				}
				$("a").click(function() {
					var href = $(this).attr('href').replace('#', '')
					scrollToAnchor(href);
				});
			});
		</script>


        <script src="js/bootstrap.min.js"></script>
        <script src="js/jquery.backstretch.min.js"></script>
        <script src="js/jquery.countdown.min.js"></script>
        <script src="js/scripts.js"></script>

</body>
</html>
