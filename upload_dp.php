<?php
session_start();

include 'connect.php';

$em = 1;

if (isset($_POST['submit'])) {
    $email = $_SESSION['email'];

    function save($email, $con)
    {
        if (!isset($_FILES['dp']['error']) || $_FILES['dp']['error'] !== UPLOAD_ERR_OK) {
            // No file uploaded or an error occurred
            $dp_name = "default.jpg";
            $dp = file_get_contents('avatar.jpg');
            $dp = base64_encode($dp);
        } else {
            $dp_tmp_name = $_FILES['dp']['tmp_name'];
            $dp_name = "$email" . ".jpg";
            $dp = file_get_contents($dp_tmp_name);
            $dp = base64_encode($dp);
        }

        $sql = "UPDATE login SET dp_name=?, dp=? WHERE email=?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "sss", $dp_name, $dp, $email);

        if (mysqli_stmt_execute($stmt)) {
			header('location:Dashboard.php');
        } else {
            echo "Image upload problem";
        }

        mysqli_stmt_close($stmt);
    }

    $sql = "SELECT * FROM login WHERE email=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($result) {
        $num = mysqli_num_rows($result);
        if ($num > 0) {
            save($email, $con);
        }
    } else {
        $em = 0;
    }

    mysqli_stmt_close($stmt);
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
			background-color: #4CAF50;
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
			background-color: yellow;
			color: green;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
		}
        .prof{
			margin: 100px auto;
			width: 310px;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
		}
    </style>
</head>

<body background="Login.jpg">

    <?php
    if ($em == 0) {
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Sorry! </strong> Email Doesn\'t exist
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>';
    }

    ?>

    <div class="container">
        <div class="head">
            <h2>Upload Profile Picture</h2>
        </div>
        <form method="post" action="upload_dp.php" enctype="multipart/form-data">
            <div class="prof">
                <h3>Upload New Profile Picture</h3>
                <br><br><input type="file" name="dp" id="dp" class="dp" required>
            </div>
            <button type="submit" name="submit">Upload</button>
        </form>
    </div>
</body>

</html>
