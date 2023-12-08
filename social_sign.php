<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('memory_limit', '256M');


include 'connect.php';
if($_SERVER['REQUEST_METHOD']=='POST'){

    
    $email_exist=0;
    $user=0;
    $success=0;
	function Validate($input) {
		$input = trim($input);             // Remove leading and trailing spaces
		$input = stripslashes($input);     // Remove backslashes
		$input = htmlspecialchars($input); // Convert special characters to HTML entities
		return $input;
	}

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

    // $email=Validate($email);
    // $pass=Validate($pass);

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
    $sql="Select * from login where email='$email'";

    $result=mysqli_query($con,$sql);

    if($result){
        $num=mysqli_num_rows($result);
        if($num>0){
            $email_exist=1;
        }else{
            $sql="Select * from login where username='$u_name'";
            $result=mysqli_query($con,$sql);
            if($result){
                $num=mysqli_num_rows($result);
                if($num>0){
                    $user=1;
                }else{
                    $sql="INSERT INTO login (firstname,lastname,username,pass,c_pass,email,dob,gender,hometown,about) VALUES ('$f_name','$l_name','$u_name','$pass','$c_pass','$email','$dob','$gender','$hometown','$about')";
                    $result=mysqli_query($con,$sql);
                    save($email,$con,$u_name);
                    if($result){
                        $success=1;
                    }
                }
            }
        }
    }
}
else{
    die(mysqli_error($con));
}
?>


