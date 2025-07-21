<?php
$host     = 'localhost';            // Use IP to avoid socket issues
$port     = '3306';                 // Update to 3306 if your MySQL runs on default
$dbname   = 'arseneso_ahorros';                  // Your database name
$username = 'arseneso_orven';                 // XAMPP default user
$password = '143sarah';                     // Leave blank unless you manually set a root password
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

// arsenesoftware@ebisx.com
//110239
try
{
    $pdo = new PDO($dsn, $username, $password, array(PDO::ATTR_PERSISTENT => true));	
   
} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
