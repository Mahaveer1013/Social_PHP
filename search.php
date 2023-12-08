<?php
include 'connect.php';
$search=$_GET['search'];
$sql="SELECT * FROM login WHERE username = '$search'";
$result=mysqli_query($con,$sql);
if(mysqli_num_rows($result)>0){
    while($row=mysqli_fetch_assoc($result)){
		$f_name=$row['firstname'];
		$l_name=$row['lastname'];
		$email=$row['email'];
		$dob=$row['dob'];
		$gender=$row['gender'];
        $hometown=$row['hometown'];
        $about=$row['about'];
        $dp=$row['dp'];
    }
}
?>
<html>
    <head>
        <title><?php echo $f_name.$l_name."'s Dashboard"; ?></title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <style>
            body {
			margin: 0;
			padding: 0;
			background-color: #f1f1f1;
			background-image: ;
		}
        h3{
			text-align: center;
            background-color: inline-block;
		}
		.container {
			margin: 100px auto;
			width: 80%;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
		}
        table{
            text-align: left;            
        }
        input[type=textarea]{
            height: 250px;
            width: 250px;
        }
        input[type=submit]{
            background-color: #4CAF50;
			color: white;
			padding: 14px 20px;
			margin: 8px 0;
			border: none;
			border-radius: 4px;
			cursor: pointer;
			width: 100%;
        }
        th,td{
            padding: 15px;
            font-style: ;
        }
        .profile,.post,.myposts{
            margin: 100px auto;
			width: 70%;
			background-color: #fff;
			padding: 20px;
			border-radius: 10px;
			box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }
        </style>
    </head>
    <body background="Login.jpg">
        <center>
        <div class="container">
            <h1><?php echo "$search".' Profile' ?></h1>
            <div>
                <div class="profile">
                    <h3>Profile</h3>
                    <?php echo "<img  width='auto' height='100px' src='data:dp;base64,{$dp}' alt='img'>"; ?>
                    <table>
                        <tr><th>Name : </th>
                            <td><?php echo $f_name.$l_name; ?></td>
                        </tr>
                        <tr><th>Username : </th>
                            <td><?php echo $search; ?></td>
                        </tr>
                        <tr><th>Mail id : </th>
                            <td><?php echo $email; ?></td>
                        </tr>
                        <tr><th>Date Of Birth : </th>
                            <td><?php echo $dob; ?></td>
                        </tr>
                        <tr><th>Gender : </th>
                            <td><?php echo $gender; ?></td>
                        </tr>
                        <tr><th>Hometown : </th>
                            <td><?php echo $hometown; ?></td>
                        </tr>  
                    </table>
                </div>
                <div class="myposts">
                <h2>Posts</h2>
                <?php
                $sql="Select * from post where email='$email'";

                $result=mysqli_query($con,$sql);

                if(mysqli_num_rows($result)>0){
                    while($row=mysqli_fetch_assoc($result)){
                        $post_msg=$row['post_msg'];
                        $post_img=$row['post_img'];
                        echo "$post_msg <br>";
                        echo "<img  width='auto' height='200px' src='data:post_img;base64,{$post_img}' alt='img'><br><br>";
                    }
                }
                ?>

                </div></body></html>

                    


