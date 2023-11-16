<?php

if(isset($_POST['submit'])){
    session_start();
    $otp=$_SESSION['otp'];
    $data=0;
    
    $userotp=$_POST['otp'];
    if($otp == $userotp){
        // echo '<script> alert("Verified Susscefully");</script>';
    header("Location: userdashboard.php");
        
    }
    else{
        // $_SESSION['data']=1;
        $data=1;
        header("Location:verified.php");
    }

    if($data==1){
        echo '<script>alert("Wrong OTP try again");</script>';
    }
}
?>

<style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image:url("photo.png");
        }
        .signup-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #ffffff;
            padding: 20px;
            margin-top: 100px;
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.1);
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group input[type="text"], 
        .form-group input[type="email"],
        .form-group input[type="password"] {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
            display: inline-block;
        }
        .form-group input[type="submit"] {
            width: 100%;
            background-color: #4caf50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            padding: 10px;
            font-size: 16px;
        }
        .form-group input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="signup-container">
        <h2>Verify your Email</h2>
        <form action="verified.php" method="post">
            <div class="form-group">
                <label for="username">OTP:</label>
                <input type="text" id="otp" name="otp" required>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Verify the OTP">
            </div>
            <h>SignUP with other account </h>
            <a href="signup.html">Click here.</a>
        </form>
    </div>
</body>
</html>
