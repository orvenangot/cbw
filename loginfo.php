<?php
date_default_timezone_set("Asia/Manila");
$uid =$_POST['userid'];
$upass = $_POST['userpassword'];
$db = $_POST['db'];
$useraddress = $_POST['useraddress'];
$userhost = $_POST['userhost'];
$dbu = $_POST['dbu'];
$dbp = $_POST['dbp'];

if($upass==$useraddress)
{
	
	$tdate = date("Y-m-d");
	$tm = date("H:i:s");
	$yearid = date('Y');
	/*
	$loghost = 'localhost';
	$logdb = $db;
	$loguser = 'root';
	$logpass = '';
	$charset = 'utf8mb4';
	*/

	$loghost = 'localhost';
	$logdb = $db;
	$loguser = $dbu;
	$logpass = $dbp;
	$charset = 'utf8mb4';

	//$logdsn = "mysql:host=$loghost;dbname=$db;charset=$charset";
	try
		{
			
			session_start();
			$_SESSION['sessusername'] = $uid;

			//session_start();
			$_SESSION['sessuserdb'] = $db;
			//session_start();
			$_SESSION['sessuserdbu'] = $dbu;
			//session_start();
			$_SESSION['sessuserdbp'] = $dbp;


			include("connect.php");
			$logquery = "ALTER TABLE parameters ADD online_customer varchar(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE purchasejournal ADD storepurchase INT NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE closing_dates ADD remarks varchar(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE closing_dates ADD actualcount DECIMAL(12,2) NOT NULL DEFAULT '0',ADD auditor varchar(100) NOT NULL DEFAULT '',ADD audit_date DATE NOT NULL DEFAULT '2001-01-01'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE closing_dates ADD editremarks varchar(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE timetable ADD userlocation varchar(200) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "CREATE TABLE IF NOT EXISTS tendergroups(tendergroup VARCHAR(100) NOT NULL, PRIMARY KEY (tendergroup)) ENGINE = MyISAM";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE tender_types ADD tendergroup varchar(200) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "CREATE TABLE IF NOT EXISTS conversion_items(unique_id INT NOT NULL AUTO_INCREMENT, itemid VARCHAR(100) NOT NULL DEFAULT '',
			PRIMARY KEY (unique_id)) ENGINE = MyISAM";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE billboards ADD costcenter varchar(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE salesorder ADD no_of_guests INT NOT NULL DEFAULT '0',ADD no_of_beds INT NOT NULL DEFAULT '0',
			ADD no_of_adults INT NOT NULL DEFAULT '0',ADD no_of_children INT NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE parameters ADD real_estate varchar(5) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE billboards ADD no_of_guests INT NOT NULL DEFAULT '0',ADD no_of_beds INT NOT NULL DEFAULT '0',
			ADD no_of_adults INT NOT NULL DEFAULT '0',ADD no_of_children INT NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			
			include("connect.php");
			$logquery = "ALTER TABLE accountjournal ADD room_id varchar(100) NOT NULL DEFAULT '',ADD date_start DATE NOT NULL DEFAULT '2001-01-01'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE salesorder ADD order_type varchar(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE jobs ADD labor_budget DECIMAL(12,2) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE jobs ADD created_by VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE estimate ADD warranty VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE estimate ADD leadtime VARCHAR(100) NOT NULL DEFAULT '',ADD materials VARCHAR(100) NOT NULL DEFAULT '',ADD otherdetails VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE jobs ADD created_by VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE estimate CHANGE address address TEXT NULL";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE estimate ADD charge_mobilization VARCHAR(20) NOT NULL DEFAULT 'INCLUDE'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE customers ADD customer_pin VARCHAR(10) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE parameters ADD hotel varchar(5) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE billboards ADD extraperson DECIMAL(12,2) NOT NULL DEFAULT '0',ADD extrabed DECIMAL(12,2) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE disbursementjournal ADD imagelocation VARCHAR(200) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "CREATE TABLE IF NOT EXISTS hotel_reservation(unique_id INT NOT NULL, reservation_date DATE NOT NULL DEFAULT '2000-01-01', arrival_date DATE NOT NULL DEFAULT '2000-01-01',
			departure_date DATE NOT NULL DEFAULT '2000-01-01',salutation VARCHAR(10) NOT NULL DEFAULT '',firstname VARCHAR(100) NOT NULL DEFAULT '',lastname VARCHAR(100) NOT NULL DEFAULT '',
			birthdate DATE NOT NULL DEFAULT '2000-01-01',home_address VARCHAR(100) NOT NULL DEFAULT '',home_country VARCHAR(100) NOT NULL DEFAULT '',no_of_adults INT(10) NOT NULL DEFAULT '0',
			no_of_children INT(10) NOT NULL DEFAULT '0',category VARCHAR(100) NOT NULL DEFAULT '',room_id VARCHAR(100) NOT NULL DEFAULT '',email VARCHAR(100) NOT NULL DEFAULT '',amount DECIMAL(12,2) NOT NULL DEFAULT '0',
			mobile VARCHAR(100) NOT NULL DEFAULT '',status VARCHAR(100) NOT NULL DEFAULT '',duration INT(10) NOT NULL DEFAULT '0',extracharge DECIMAL(12,2) NOT NULL DEFAULT '0',totalamount DECIMAL(12,2) NOT NULL DEFAULT '0', 
			invoice VARCHAR(100) NOT NULL DEFAULT '',
			PRIMARY KEY (unique_id)) ENGINE = MyISAM";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE items ADD extra_person_charge DECIMAL(12,2) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE employees ADD account_number VARCHAR(100) NOT NULL DEFAULT '',ADD bank VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE employee_files ADD file_location VARCHAR(200) NOT NULL DEFAULT '',ADD file_id VARCHAR(100) NOT NULL DEFAULT '',
			ADD add_date DATE NOT NULL DEFAULT '2000-01-01'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE employee_files CHANGE unique_id unique_id INT(100) NOT NULL AUTO_INCREMENT";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE jobs CHANGE estimate_no estimate_no INT(11) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE jobs CHANGE estimate_no estimate_no VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			
			include("connect.php");
			$logquery = "ALTER TABLE salesjournal ADD imagelocation VARCHAR(200) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE parameters ADD home_currency VARCHAR(100) NOT NULL DEFAULT 'Peso',ADD currency_symbol VARCHAR(100) NOT NULL DEFAULT 'Php'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			
			include("connect.php");
			$logquery = "ALTER TABLE borrowers ADD borrower_type VARCHAR(100) NOT NULL DEFAULT 'Regular',ADD civil_status VARCHAR(100) NOT NULL DEFAULT '',ADD membership_date DATE NOT NULL DEFAULT '2000-01-01',
			ADD birth_place VARCHAR(200) NOT NULL DEFAULT '',ADD education_level VARCHAR(100) NOT NULL DEFAULT '',ADD occupation VARCHAR(100) NOT NULL DEFAULT ''";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE borrowers CHANGE borrower_id borrower_id VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE salutation salutation VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE firstname firstname VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE middlename middlename VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE lastname lastname VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE businessname businessname VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE address address VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE city city VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE province province VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE zipcode zipcode VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE phone phone VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE mobile mobile VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE tin tin VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE gender gender VARCHAR(10) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE imagelocation imagelocation VARCHAR(200) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', 
			CHANGE birthdate birthdate DATE NOT NULL DEFAULT '2000-01-01'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

			include("connect.php");
			$logquery = "ALTER TABLE borrowers CHANGE email email VARCHAR(100) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT '', CHANGE active active INT(11) NOT NULL DEFAULT '0'";
			$logresult = $con->prepare($logquery);
			$logresult->execute();
			$con = null;

		
			
			
			//update system
				include("connect.php");
				$dashuquery = "SELECT default_dashboard,userposition FROM users WHERE email LIKE ? AND active='0'";
				$dashustmt = $con->prepare($dashuquery);
				$dashustmt->bindParam(1, $uid);
				$dashustmt->execute();
				$dashunum = $dashustmt->rowCount();
				
				if ($dashunum > 0) {
					$dashustmt->bindColumn('default_dashboard', $userdashboard);
					$dashustmt->bindColumn('userposition', $loginuserposition);
					
					$dashrow = $dashustmt->fetch( PDO::FETCH_BOUND );
					$con = null;
					if($loginuserposition=="POS User" || $loginuserposition=="Dispensing")
					{
						header("Location: mobileselectcenter.php");
					}
					elseif($loginuserposition=="POS Supervisor")
					{
						header("Location: mobileselectcenter.php");
					}
					elseif($loginuserposition=="POS Manager")
					{
						header("Location: mobilemenu.php");
					}
					elseif($loginuserposition=="Tenant")
					{
						header("Location:tenantpin.php");
					}
					elseif($loginuserposition=="Front Desk")
					{
						header("Location:hotel_menu.php");
					}
					elseif($loginuserposition=="Guest")
					{
						header("Location:hotel_client_menu.php");
					}
					
					else
					{
						if($userdashboard=="Financial"){
							header("Location: financialdashboard.php");
						}
						elseif($userdashboard=="Project"){
							header("Location: projectdashboard.php");
						}
						elseif($userdashboard=="Project Calendar"){
							header("Location: ongoingprojectscalendar.php");
						}
						elseif($userdashboard=="Task Calendar" || $userdashboard=="Ticket Calendar"){
							header("Location: taskcalendar.php");
						}
						elseif($userdashboard=="Sales"){
							header("Location: salesdashboard.php");
						}
						else{
							header("Location: taskcalendar.php");
						}
					}
					
				}
				else{
					$link = "https://".$userhost."/passwordentry.php?userid=".urlencode(base64_encode($uid))."&db=".urlencode(base64_encode($db))."&useraddress=".urlencode(base64_encode($useraddress))."&userhost=".urlencode(base64_encode($userhost))."&dbu=".urlencode(base64_encode($dbu))."&dbp=".urlencode(base64_encode($dbp));

					header("Location: ".$link);
				}
			
	}
	catch (\PDOException $e)
	{
		throw new \PDOException($e->getMessage(), (int)$e->getCode());
	}
}
else{

	$link = "https://".$userhost."/passwordentry.php?userid=".urlencode(base64_encode($uid))."&db=".urlencode(base64_encode($db))."&useraddress=".urlencode(base64_encode($useraddress))."&userhost=".urlencode(base64_encode($userhost))."&dbu=".urlencode(base64_encode($dbu))."&dbp=".urlencode(base64_encode($dbp));

	header("Location: ".$link);
}


	
	include('themeconfig.php');?>
    <script type="text/javascript">
	var debugScript = true;
	function openConfirmation() {
    	document.getElementById("confirmationform").style.display = "block";
	}

	function closeConfirmation() {
		document.getElementById("confirmationform").style.display = "none";
	}
	
    </script>




