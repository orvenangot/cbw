<?php
//session_start();
   // $uid=$_SESSION['sessusername'];
	if($_SESSION['sessusername']!="" && $_SESSION['sessuserdb']!="")
	{
		
			$db = $_SESSION['sessuserdb'];
			$dbuser = "arseneso_orven";
			$dbpass = "143sarah";
			$host = "localhost";

			/** online
			$db = $_SESSION['sessuserdb'];
			$dbuser = "arseneso_orven";
			$dbpass = "143sarah";
			$host_name = "localhost";
			 */
		
			
			$charset = 'utf8mb4';
			

			$dsn = "mysql:host=$host;dbname=$db;charset=$charset";
			try {
				$con = new PDO($dsn, $dbuser, $dbpass, array(PDO::ATTR_PERSISTENT => true));			
				
			} catch (\PDOException $e) {
				 throw new \PDOException($e->getMessage(), (int)$e->getCode());
			}
		
	}
		else {
			
		?>
			<a href="index.php">Session not started! Click here to log-in...</a>
		<?php
		  
    }

?>
