<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter OTP</title>
    <style>
  body {
    font-family: 'Nunito', sans-serif;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
    margin: 0;
    background-color: #ffe0b2;
}
.container {
    background-color: #ffffff;
    padding: 35px;
    box-shadow: 0 6px 20px rgba(0, 0, 0, 0.2);
    border-radius: 25px;
    width: 340px;
    text-align: center;
    color: #ef6c00;
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
