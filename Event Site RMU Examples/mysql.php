<?php
//mysql.php - mysql connections and functions
//set up variables, regardless if we need them or not

require("utility.php");

//contact information variables
$contact = array(c_name => $c_name,troop =>$troop,c_addr1 => $c_addr1,c_addr2 => $c_addr2,c_zip=>$c_zip,c_state=>$c_state,c_city=>$c_city,c_phone => $c_phone,c_email => $c_email, password => $password);
//student variables
$student = array(id => $id,f_name =>$f_name,l_name => $l_name);
//teacher variables
$teacher = array(id => $id,f_name =>$f_name,l_name => $l_name,phone => $phone);
//login
$login = array(troop => $troop,password => $password);


//connect to the server
mysql_connect('localhost','mbc_registration','XXXXXXXX');
mysql_select_db('epsilont_mbc');


//function pertaining to dbase entry

//contact functions
function add_contact($info)
{
	$query = "insert into troop values('$info[c_name]','$info[troop]','$info[c_addr1]','$info[c_addr2]','$info[c_zip]','$info[c_city]','$info[c_state]','$info[c_phone]','$info[c_email]','$info[password]')";

	return mysql_query($query);

}


function update_contact($info)
{
	$query = "update troop set c_name='$info[c_name]',c_addr1='$info[c_addr1]',c_addr2='$info[c_addr2]',c_zip='$info[c_zip]',c_city='$info[c_city]',c_state='$info[c_state]',c_phone='$info[c_phone]',c_email='$info[c_email]',password='$info[password]' where troop ='$info[troop]'";

	return mysql_query($query) or die($query);
}


function delete_contact($info)
{
	$query = "delete from troop where troop='$info[troop]'";
	return mysql_query($query);
}

//login functions
function authenticate($user,$password)
{
	$query = "select * from troop where troop='$user' && password=md5('$password')";
	$adminquery = "select * from admin where troop='$user' && password=md5('$password')";
	$result = mysql_query($query);
	$adminresult = mysql_query($adminquery);

	if(mysql_num_rows($result) == 1){
		return(true);
	}
	else if(mysql_num_rows($adminresult) == 1){
		return(true);
	}
	else{
		return(false);
	}
}

function addSession($year,$chair){
	$query = "insert into year set year='$year', chair='$chair', register_status='O'";
	return mysql_query($query);
}


function getClassInfo($id,&$info)
{
	$query = "select * from class where id='$id'";
	$result = mysql_query($query);
	$info = mysql_fetch_array($result);
	return;
}


function getClassName($classID){
	if($classID == '-1') return "---------";
	$query = "select name from class where id='$classID'";
	$result = mysql_query($query);

	$info = mysql_fetch_array($result);

	return $info[name];
}



function getContactInfo($troop,&$info){
	$query = "select * from troop where troop='$troop'";
	$result = mysql_query($query);
	$info = mysql_fetch_array($result);
	return;
}

function getSessionYear(){
	$query = "select * from year";
	$result = mysql_query($query);

	$year = -1;
	while($array = mysql_fetch_array($result)){
		if($array[year] > $year) $year = $array[year];
	}

	return $year;
}


function addClass($name,$section,$capacity,$teacher,$room,$period,$length){
	$query = "insert into class set name='$name', section='$section',capacity='$capacity',teacher='$teacher',room='$room',period='$period',length='$length'";
	return mysql_query($query) or die(mysql_error());
}



function editClass($name,$section,$capacity,$teacher,$room,$period,$length,$id){
	$query = "update class set name='$name', section='$section',capacity='$capacity',teacher='$teacher',room='$room',period='$period',length='$length' where id='$id'";
	return mysql_query($query) or die(mysql_error());
}


function addScout($f_name,$l_name,$tshirt,$troop)
{
	$query = "insert into student set f_name='$f_name',l_name='$l_name',tshirt='$tshirt',troop='$troop'";
	return mysql_query($query) or die(mysql_error());
}


function deleteClass($id)
{
	$query = "update register set class1_id='-1' where class1_id='$id'";
	mysql_query($query);
	$query = "update register set class2_id='-1' where class2_id='$id'";
	mysql_query($query);
	$query = "update register set class3_id='-1' where class3_id='$id'";
	mysql_query($query);
	$query = "update register set class4_id='-1' where class4_id='$id'";
	mysql_query($query);
	$query = "delete from class where id='$id'";
	return mysql_query($query);
}


function deleteScout($id)
{
	$query = "delete from student where id='$id'";
	return mysql_query($query);
}


function getClassList(&$list)
{
	$query = "select * from class order by name";
	$result = mysql_query($query);
	$i = 0;

	while($array = mysql_fetch_array($result)){
		$list[$i][id] 		= $array[id];
		$list[$i][name] 	= $array[name];
		$list[$i][section] 	= $array[section];
		$list[$i][capactiy] 	= $array[capacity];
		$list[$i][teacher] 	= $array[teacher];
		$list[$i][room]		= $array[room];
		$i++;
	}
}


function getClassLength($id)
{
	$query = "select length from class where id='$id'";
	$result = mysql_query($query);

	$info = mysql_fetch_array($result);

	return($info[length]);
}


function getClassRegNum($year,$id)
{
	$query = "select * from register where class1_id='$id' || class2_id='$id' || class3_id='$id' && year = '$year'";

	$result = mysql_query($query) or die($query);
	return mysql_num_rows($result);
}


function getNumScouts($troop)
{
	$query = "select * from student where troop='$troop'";
	$result = mysql_query($query) or die(mysql_error());
	return(mysql_num_rows($result));
}


function getTroopList(&$info)
{
	$query = "select * from troop order by troop";
	$result = mysql_query($query);

	$i = 0;

	while($array = mysql_fetch_array($result)){
		$info[$i][troop] 	= $array[troop];
		$info[$i][c_name]	= $array[c_name];
		$info[$i][c_email]	= $array[c_email];
		$i++;
	}
}


function getNumScoutsReg($troop,$year)
{
	$query = "select * from student,register where student.id=register.student_id && student.troop='$troop' && register.year='$year'";
	$result = mysql_query($query);

	return(mysql_num_rows($result));
}

function getNumTroops()
{
	$query = "select troop from troop";
	$result = mysql_query($query);

	return(mysql_num_rows($result));
}

function getAdminStats()
{
	$query = "select * from student";
	$result = mysql_query($query) or die(mysql_error());
	return(mysql_num_rows($result));
}

function getAdminRegStats($year)
{
	$query = "select * from student,register where student.id=register.student_id && register.year='$year'";
	$result = mysql_query($query);

	return(mysql_num_rows($result));
}

function getTroopInfo($year,&$info)
{
	getTroopList(&$troops);
	for($i=0;$i<sizeof($troops);$i++)
	{
		$troop = $troops[$i][troop];
		$query = "select * from register,student where student.troop = '$troop' && register.year = '$year' && student.id = register.student_id";
		$result = mysql_query($query) or die($query);
		$info[$i][troop] 	= $troop;
		$info[$i][cur_session] 	= mysql_num_rows($result);
		$info[$i][c_name] 	= $troops[$i][c_name];
		$info[$i][c_email]	= $troops[$i][c_email];


		$query = "select * from student where troop = '$troop'";
		$result = mysql_query($query) or die($query);
		$info[$i][num_scouts]	= mysql_num_rows($result);
	}
}

function classIsFull($id,$year,$capacity){
	//checks to see if a class is full for the year
	$query = "select * from register where year='$year' && class1_id='$id' || class2_id='$id' || class3_id='$id' || class4_id='$id'";
	$result = mysql_query($query);

	if(mysql_num_rows($result) >= $capacity){
		 return true;
	}
	else{
		return false;
	}

	return false;

}


function removeScout($id,$year)
{
	$query = "delete from register where student_id='$id' && year='$year'";
	return mysql_query($query);
}


function scoutIsRegistered($id,$year)
{
	$query = "select * from register where student_id = '$id' && year = '$year'";
	$result = mysql_query($query) or die($query);

	if(mysql_num_rows($result) > 0){
		return true;
	}
	else{
		return false;
	}
}



function troopExists($troop)
{
	$query = "select * from troop where troop='$troop'";
	$result = mysql_query($query);

	if(mysql_num_rows($result) == 0) return false;
	else return true;
}


function registerScout($id,$year,$c1,$c2,$c3,$c4){
	$query = "select * from register where student_id='$id' && year='$year'";
	$result = mysql_query($query);

	if(mysql_num_rows($result) > 0){
		return false;
	}
	else
	{
		switch(getClassLength($c1))
		{
			case 4:
				$c4 = -4;
			case 3:
				$c3 = -3;
			case 2:
				$c2 = -2;
				break;
			default:
				break;
		}

		switch(getClassLength($c2))
		{
			case 3:
				$c4 = -4;
			case 2:
				$c3 = -3;
				break;
			default:
				break;
		}
		switch(getClassLength($c3))
		{
			case 2:
				$c4 = -4;
				break;
			default:
				break;
		}

		$query = "insert into register set student_id='$id',class1_id='$c1',class2_id='$c2',class3_id='$c3',class4_id='$c4',year='$year'";
		return mysql_query($query);
	}
}

function updateRegisterScout($id,$year,$c1,$c2,$c3,$c4,$lunch){
	switch(getClassLength($c1))
	{
		case 4:
			$c4 = -4;
		case 3:
			$c3 = -3;
		case 2:
			$c2 = -2;
			break;
		default:
			break;
	}

	switch(getClassLength($c2))
	{
		case 2:
			$c3 = -3;
			break;
		default:
			break;
	}
	switch(getClassLength($c3))
		{
			case 2:
				$c4 = -4;
				break;
			default:
				break;
		}


	$query = "update register set class1_id='$c1',class2_id='$c2',class3_id='$c3',class4_id='$c4',lunch='$lunch' where student_id='$id'";
	return mysql_query($query);

}

//This is called by system.php?$action=14
function toggleRegistration($status)
{
	$query = "update year set register_status = '$status'";
	return mysql_query($query);
}

//Check if registration is open.  Trus is returned if open; otherwise false
function isRegistrationOpen()
{
	//Get the current registration status
	$year = getSessionYear();
	$query = "select register_status from year where year = '$year'";
	$result = mysql_query($query);
	$info = mysql_fetch_array($result);
	if($info[register_status] == "O")
	        return true;
	else
	        return false;
}

?>
