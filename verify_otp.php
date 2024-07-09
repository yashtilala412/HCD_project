<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $entered_otp = $_POST['otp'];

    if ($entered_otp == $_SESSION['otp']) {
        echo "OTP verified successfully!";
        // Proceed with the next steps (e.g., create the account)
    } else {
        echo "Invalid OTP. Please try again.";
    }
}
?>
