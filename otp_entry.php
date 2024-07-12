<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <style>
body {
    font-family: 'Cabin', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #ffccbc;
}
.container {
    background-color: #ffffff;
    padding: 20px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    width: 320px;
    text-align: center;
    border: 2px solid #ff7043;
}

 .container h2 {
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 15px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .btn {
            background-color: #007bff;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Enter OTP</h2>
        <form action="verify_otp.php" method="post">
            <div class="input-group">
                <input type="text" name="otp" placeholder="OTP" required>
            </div>
            <button type="submit" class="btn">Verify OTP</button>
        </form>
    </div>
</body>
</html>
