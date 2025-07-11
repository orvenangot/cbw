<?php
$host     = '127.0.0.1';            // Use IP to avoid socket issues
$port     = '3307';                 // Update to 3306 if your MySQL runs on default
$dbname   = 'cbws';                  // Your database name
$username = 'root';                 // XAMPP default user
$password = '';                     // Leave blank unless you manually set a root password
$charset  = 'utf8mb4';

$dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   // Throws exceptions
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Returns rows as associative arrays
    PDO::ATTR_PERSISTENT         => true                      // Persistent connection for performance
];

// ✅ Attempt connection
try {
    $pdo = new PDO($dsn, $username, $password, $options);
    echo "✅ Connected to database: $dbname";

    // Insert admin company if not exists
    $admin_email = 'arsenesoftware@ebisx.com';
    $admin_pin_plain = '110239';
    $admin_pin_hash = password_hash($admin_pin_plain, PASSWORD_DEFAULT);
    $admin_comp_id = uniqid();
    $admin_comp_name = 'Admin Company';
    $admin_comp_address = '981 Katipunan St. Cebu City';
    $admin_comp_type = 0; // 0 = Administrator
    $admin_comp_stat = 1;

    // Check if admin company already exists
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM tbl_companies WHERE comp_email = ?");
    $stmt->execute([$admin_email]);
    if ($stmt->fetchColumn() == 0) {
        $insert = $pdo->prepare("INSERT INTO tbl_companies (comp_id, comp_pin, comp_name, comp_address, comp_type, comp_stat, comp_email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insert->execute([$admin_comp_id, $admin_pin_hash, $admin_comp_name, $admin_comp_address, $admin_comp_type, $admin_comp_stat, $admin_email]);
        echo "<br>✅ Admin company inserted.";
    } else {
        echo "<br>ℹ️ Admin company already exists.";
    }

    // Hash all existing comp_pin values if not already hashed
    $companies = $pdo->query("SELECT unique_id, comp_pin FROM tbl_companies")->fetchAll();
    foreach ($companies as $company) {
        $pin = $company['comp_pin'];
        // If not already hashed (length < 30, since hashes are 60+ chars)
        if (strlen($pin) < 30) {
            $hashed = password_hash($pin, PASSWORD_DEFAULT);
            $update = $pdo->prepare("UPDATE tbl_companies SET comp_pin = ? WHERE unique_id = ?");
            $update->execute([$hashed, $company['unique_id']]);
        }
    }

} catch (PDOException $e) {
    echo "❌ Connection failed: " . $e->getMessage();
}
?>
