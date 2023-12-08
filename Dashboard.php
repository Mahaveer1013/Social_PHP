<?php
include 'connect.php';
session_start();
$post=0;
$post_delete=0;
if(!isset($_SESSION['email'])){
    header('location:index.php');
}

$email=$_SESSION['email'];
$username=$_SESSION['username'];
$sql="Select * from login where email='$email'";

    $result=mysqli_query($con,$sql);

    if(mysqli_num_rows($result)>0){
		while($row=mysqli_fetch_assoc($result)){
			$f_name=$row['firstname'];
			$l_name=$row['lastname'];
			$username=$row['username'];
			$dob=$row['dob'];
			$gender=$row['gender'];
            if($row['hometown']!="1"){
                $hometown=$row['hometown'];
            }
            if($row['about']!="1"){
                $about=$row['about'];
            }
            
            $dp=$row['dp'];
        }
    }
    if($_SERVER['REQUEST_METHOD']=='POST'){
        if(isset($_POST['submit'])){
            $post_msg=$_POST['post'];
            if(getimagesize($_FILES['img']['tmp_name'])==false){
                echo "please select image"; 
            }
            else{
                $img=$_FILES['img']['tmp_name'];
                $name=$_FILES['img']['name'];
                $img=file_get_contents($img);
                $img=base64_encode($img);
                
                $sql="INSERT INTO post (email,post_msg,post_img) VALUES ('$email','$post_msg','$img')";
                $result=mysqli_query($con,$sql);
                if(!$result){
                    echo "Select An Image";
                }
                else{
                    $post=1;
                }

            }
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
		}
        p{
            font-size: 18px;
        }
        a{
            font-size: 20px;
            text-decoration: none;
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
        .submit{
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
        <?php
            if($post){
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                   <strong>Great! </strong> Posts Added Successfully
                   <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                   </div>';           
            }
            if (isset($_SESSION['post_delete']) && $_SESSION['post_delete'] == 1) {
                echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                       <strong>Great! </strong> Posts Deleted Successfully
                       <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                       </div>';
                unset($_SESSION['post_delete']); // Unset the session variable
            }            
            ?>
        <center>
        <div class="container">
            <h1>Social Network </h1>
            <div>
            <form class="example" action="search.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
            </form>
            <p>Dont Forget To -><a href="#" onclick="window=window.open('feedback.php','MyWindow',width=400,height=100); return false;">Give Feedback</a></p>
            <br><p style="float: right;">Personal Chat -><a href="#" onclick="window=window.open('dm.php','MyWindow',width=400,height=100); return false;">Direct Messages</a></p>
                <div class="profile">
                    <h3>Profile</h3>
                    <?php echo "<img  width='auto' height='100px' src='data:dp;base64,{$dp}' alt='img'>"; ?>
                    <br><a href="upload_dp.php">Upload Profile Picture</a>
                    <table>
                        <tr><th>Name : </th>
                            <td><?php echo $f_name.$l_name; ?></td>
                        </tr>
                        <tr><th>Username : </th>
                            <td><?php echo $username; ?></td>
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
                        <?php 
                        if(isset($hometown)){
                         echo "<tr><th>Hometown : </th>
                            <td> $hometown </td>
                        </tr>"; 
                        }

                        if(isset($about)){
                         echo "<tr><th>About : </th>
                            <td> $about </td>
                        </tr>";
                        } 
                        ?>
                        
                    </table>
                </div>
                <div class="post">
                    <h2> Add Post Here </h2>
                    <div class="post1">
                        <form action="Dashboard.php" method="post" enctype="multipart/form-data">
                        <input type="textarea" name="post" id="post"><br>
                        <input type="file" name="img" id="img"><br><br>
                        <input type="submit" name="submit" class="submit" value="POST">
                    </form>
                    </div>
                </div>
                <div class="myposts">
                <h2>My Posts</h2>
                <?php
                $sql="Select * from post where email='$email'";

                $result=mysqli_query($con,$sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $post_id = $row['id'];
                        $post_msg = $row['post_msg'];
                        $post_img = $row['post_img'];
                        
                        echo "POST ID: $post_id <br>";
                        echo "POST Msg: $post_msg <br>";
                        echo "<img width='auto' height='200px' src='data:post_img;base64,{$post_img}' alt='img'><br><br>";
                        
                        ?>
                        <form action="Dashboard.php" method="post">
                            <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                            <input style="float: right;" type="submit" name="delete" value="Delete">
                        </form>
                        <?php
                    }
                }

                if (isset($_POST['delete'])) {
                    $post_id_to_delete = $_POST['post_id'];
                    $sql = "DELETE FROM post WHERE id = ?";
                    $stmt = mysqli_prepare($con, $sql);
                    mysqli_stmt_bind_param($stmt, "i", $post_id_to_delete);
                    $result = mysqli_stmt_execute($stmt);
                    
                    if ($result) {
                        $_SESSION['post_delete'] = 1;
                        header('location:Dashboard.php');
                    } else {
                        $post_delete=0;
                        echo "Error deleting post: " . mysqli_error($con); // Debugging line
                    }
                }
                ?>



                </div>
            </div>
        <a style="text-decoration: none;" href="index.php">Logout</a>
        </div>
        </center>
    </body>
</html>