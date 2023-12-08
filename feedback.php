<?php

$failure=0;
$success=0;
//include required php file
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
			
//define namespaces
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
			
if($_SERVER['REQUEST_METHOD']=='POST'){
    include 'connect.php';
	session_start();
	$email=$_SESSION['email'];
	$username=$_SESSION['username'];
    $msg=$_POST['feedback'];

	$mail=new PHPMailer();
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->SMTPAuth="true";
	$mail->SMTPSecure="tls";
	$mail->Port="587";
	$mail->Username="mahaveer.header@gmail.com";
	$mail->Password="idetogyryhbhoydr";
	$mail->Subject="Feedback";
	$mail->setFrom("Mahaveer A");
	$mail->isHTML(true);
	$mail->Body="<h3>Dear ".$username.",</h3></br></br><p>Thank You For Contacting Us. Your Feedback Has Been Received By Us And Will Be Addressed Soon</p></br></br><p>Message: </p></br>".$msg."<br><br>Best regards,<br>Your Team";
	$mail->addAddress($email);
	if($mail->Send()){
		$success=1;
	}else{
		$failure=1;
	}
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Feedback Form</title>
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
        textarea{
			width: 300px;
			height: 300px;
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
        a{
            text-decoration: none;
			background-color: white;
        }
    </style>
</head>
<body background="Login.jpg">

<?php
	if($success==1){
		echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
	<strong>Thanks For Contacting Us </strong>We Will Be In Touch Shortly.
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
	echo "<center><a href='#' onclick='window.close();'>Close Window</a></center>";
	}

    if($failure==1){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  	<strong>Opps! </strong>Error Sending mail
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
    }

    ?>

	<div class="container">
        <div class="head">
		    <h2>Feedback Form</h2>
        </div>
		<form method="post" action="feedback.php" autocomplete="off">
            <div class="feedback">
                <label><b>Feedback: </b></label><br>
                <center>
					<textarea name="feedback" placeholder="Feel Free To Express Your View" id="feedback" required></textarea>
				</center>
            </div>
            
		<button type="submit">Send Feedback</button>
        </form>
    </div>
</body></html>