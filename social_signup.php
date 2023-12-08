<?php
include 'connect.php';
$email_exist=0;
$user=0;
$success=0;
if($_SERVER['REQUEST_METHOD']=='POST'){

    $f_name=$_POST['f_name'];
    $l_name=$_POST['l_name'];
    $u_name=$_POST['u_name'];
    $pass=$_POST['pass'];
    $c_pass=$_POST['c_pass'];
    $email=$_POST['email'];
    $dob=$_POST['dob'];
    $gender=$_POST['usergender'];
    if (isset($_POST['hometown'])){
        $hometown = $_POST['hometown'];
    }else{
        $hometown="0";
    }
    if (isset($_POST['about'])){
        $about = $_POST['about'];
    }else{
        $about="0";
    }
    function save($email,$con,$u_name){
        if(!isset($_POST['dp'])){
        $dp_name="default.jpg";
        $dp_file=file_get_contents('avatar.jpg');
        $dp=base64_encode($dp_file);
        }
        else{
            $dp=$_FILES['dp']['tmp_name'];
            $dp_name="$u_name".".jpg";
            $dp=file_get_contents($dp);
            $dp=base64_encode($dp);
        }
        $sql="UPDATE login SET dp_name='$dp_name',dp='$dp' WHERE email='$email'";
        $result=mysqli_query($con,$sql);
        if(!$result){
        echo "image problem in upload";
        }
    }
    $sql="SELECT * FROM login WHERE email='$email'";

    $result=mysqli_query($con,$sql);

    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $email_exist=1;
        }
    }
    
    $sql="SELECT * FROM login WHERE username='$u_name'";
    $result=mysqli_query($con,$sql);
    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $user=1;
        }
    }

    if($email_exist!=1 && $user!=1){
        $sql="INSERT INTO login (firstname,lastname,username,pass,c_pass,email,dob,gender,hometown,about) VALUES ('$f_name','$l_name','$u_name','$pass','$c_pass','$email','$dob','$gender','$hometown','$about')";
        $result=mysqli_query($con,$sql);
        save($email,$con,$u_name);
        if($result){
            $success=1;
        }
    }    
}
else{
    die(mysqli_error($con));
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Create Account</title>

    <script type="text/javascript">
		function ValidateSignup(){
            var email,pass,c_pass;
            email=document.getElementById('email').value;
            pass=document.getElementById('pass').value;
            c_pass=document.getElementById('c_pass').value;
            if(pass.length<8){
                alert("Password Length Must Be Atleast 8");
                return false;
            }
            if(pass!=c_pass){
                alert("Password And Confirm Password Do Not Match.");
                return false;
            }
            return true;
		}
    </script>

    <style>
        body {
			margin: 0;
			padding: 0;
			background-color: #f1f1f1;
		}
		.container {
			margin: 100px auto;
			width: 500px;
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
        input[type=radio] {
            width: auto;
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
        .signup,.marks{
			margin: 100px auto;
			width: 400px;
			/* background-color: #fff; */
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
		}
        a{
            text-decoration: none;
        }
        span{
            color:red;
        }
    </style>
</head>
<body background="Login.jpg">

<?php
    if($user==1){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  	<strong>Sorry! </strong> Username Already exists
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
    }

    if($email_exist==1){
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
  	<strong>Sorry! </strong> Account Already exists
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
    }

    if($success==1){
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
  	<strong>Great! </strong> Account Created Successfully.
  	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
	</div>';
    }
    ?>

	<div class="container">
        <div class="head">
		    <h2>PEC Social Media</h2>
        </div>
		<form method="post" action="social_signup.php" onsubmit="return ValidateSignup()" enctype="multipart/form-data">
            <div class="signup">
                <h3>Welcome To My Network</h3>
                <table style="font-size:15px;">
                    <tr><th>First Name :<span>*</span></th>
                    <td><input type="text" placeholder="Enter First Name" name="f_name" id="f_name" required></td></tr>
                    <tr><th>Last Name :<span>*</span></th>
                    <td><input type="text" placeholder="Enter Last Name" name="l_name" id="l_name" required></td></tr>
                    <tr><th>Username :<span>*</span></th>
                    <td><input type="text" placeholder="Enter Username" name="u_name" id="u_name" required></td></tr>
                    <tr><th>Password :<span>*</span></th>
                    <td><input type="password" placeholder="Enter Password" name="pass" id="pass" required></td></tr>
                    <tr><th>Confirm Password :<span>*</span></th>
                    <td><input type="password" placeholder="Enter Confirm Password" name="c_pass" id="c_pass" required></td></tr>
                    <tr><th>Email : <span>*</span></th>
                    <td><input type="text" placeholder="Enter Your Email" name="email" id="email" required></td></tr>
                    <tr><th>DOB :<span>*</span></b></t>
                    <td><input type="date" placeholder="Enter Date of Birth" name="dob" id="dob" required></td></tr>
                    <tr><th>Gender :<span>*</span></th>
                    <td><input type="radio" name="usergender" value="Male" id="malegender" class="gen">Male
                       <input type="radio" name="usergender" value="Female" id="femalegender" class="gen">Female            
                    <tr><th>Hometown :</th>
                    <td><input type="text" placeholder="Enter Your Hometown" name="hometown" id="hometown"></td></tr>
                    <tr><th>About Me :</th></tr>                
                </table>
                <textarea rows="4" cols="50" name="about"></textarea>
                <label><b>Upload Profile Picture : </b></label>
                <input type="file" name="dp" id="dp">
            </div>
		<button type="submit">Sign Up</button>
        </form>
        <p>Already Have An Account ? <a href="index.php">Login Here</a></p>
        </div>
          

</body></html>