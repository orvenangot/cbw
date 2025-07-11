<?php
session_start();
require_once 'dbconnect.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = isset($_POST['userid']) ? trim($_POST['userid']) : '';
    $pin = isset($_POST['password']) ? trim($_POST['password']) : '';

    if ($email === '' || $pin === '') {
        header('Location: loginpage.php?error=empty');
        exit();
    }

    // Fetch company by email
    $stmt = $pdo->prepare('SELECT * FROM tbl_companies WHERE comp_email = ? LIMIT 1');
    $stmt->execute([$email]);
    $company = $stmt->fetch();

    if ($company && password_verify($pin, $company['comp_pin'])) {
        // Login success - store company data in session
        $_SESSION['company_id'] = $company['comp_id'];
        $_SESSION['company_email'] = $company['comp_email'];
        $_SESSION['company_name'] = $company['comp_name'];
        $_SESSION['company_type'] = $company['comp_type'];
        $_SESSION['company_status'] = $company['comp_stat'];
        
        // Check company status
        if ($company['comp_stat'] == 0) {
            header('Location: loginpage.php?error=inactive');
            exit();
        }
        
        // Redirect based on company type
        if ($company['comp_type'] == 0) {
            // Administrator
            $_SESSION['user_role'] = 'admin';
            header('Location: admin_dashboard.php');
        } else {
            // Regular user
            $_SESSION['user_role'] = 'user';
            header('Location: index.php');
        }
        exit();
    } else {
        // Login failed
        header('Location: loginpage.php?error=invalid');
        exit();
    }
} else {
    header('Location: loginpage.php');
    exit();
}
?> 