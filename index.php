<?php

$failure=0;
$success=0;
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';

    $email=$_POST['email'];
    $pass=$_POST['pass'];
    
    $sql="SELECT * FROM login WHERE email='$email' AND pass='$pass'";

    $result=mysqli_query($con,$sql);

    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
			session_start();
			$_SESSION['email']=$email;
			$row=mysqli_fetch_assoc($result);
			$username = $row['username'];
			$_SESSION['username']=$username;
			$_SESSION['success_dp']=$success_dp;
			header('location:Dashboard.php');
            $success=1;
        }else{
            $failure=1;
        }
    }else{
        die(mysqli_error($con));
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Social Networking</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
    <style>
        body {
			margin: 0;
			padding: 0;
			background-color: #f1f1f1;
		}
		.container {
			margin: 100px auto;
			width: 400px;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
		}
		h2 {
			text-align: center;
			color: #333;
		}
        input{
			width: 100%;
			padding: 12px 20px;
			margin: 8px 0;
			display: inline-block;
			border: 1px solid #ccc;
			border-radius: 4px;
			box-sizing: border-box;
		}
		button {
			background-color: #4CAF50;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
		}
        .email{
			margin: 100px auto;
			width: 310px;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
		}
        a{
            text-decoration: none;
        }
    </style>
</head>
<body background="Login.jpg">

<?php

    if($failure){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  	<strong>Sorry! </strong>Username Or Email Doesn\'t Exists
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
    }

    ?>

	<div class="container">
        <div class="head">
		    <h2>PEC Social Network</h2>
        </div>
		<form method="post" action="index.php">
            <div class="email">
                <h3>Enter Login Details</h3>
                <table style="font-size:15px;">
                    <tr><td><b>Email</b></td>
                    <td><input type="text" placeholder="Enter Email" name="email" id="email" required></td></tr>
                    <tr><td><b>Password:</b></td>
                    <td><input type="password" placeholder="Enter Password" name="pass" id="pass" required></td></tr>
                </table>
            </div>
            
		<button type="submit">Login</button>
        </form>
        <p style="font-style:aria-busy; ">Don't Have An Account:  <a href="social_signup.php">Create Account</a></p>
    </div>
</body></html>