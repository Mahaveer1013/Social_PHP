<!--<html>
    /*<php
session_start();
$receiver_count=0;
if(!isset($_SESSION['email'])){
    header('location:index.php');
}
$email=$_SESSION['email'];
$username=$_SESSION['username'];
if(isset($_POST['submit'])){
    $temp=$_POST['search'];

    $sql="Select * from login where username='$temp'";
    $result=mysqli_query($con,$sql);
    if(mysqli_num_rows($result)>0){
        $receiver_count=1;
    }else{

    }
}
?>
<html>
<head><title>Personal Message</title></head>

<body>

<h1>Enter Username To Message</h1>

<form class="example" method="post" action="D_msg.php">
<input type="text" placeholder="Search.." name="search">
<button type="submit" name="submit" value="Search"><i class="fa fa-search"></i></button>
</form>
<div class="searched">
    
</div>

</body>
</html>-->
<!DOCTYPE html>
<html lang="en" dir="ltr">
    <head>
    <meta charset="utf-8">
    <title>Chat Application</title>
    <style media="screen">
      body{
        background-color: #c0c0c0;
        margin: 0px;
        padding: 0px;
      }
      #p1{
        background-color: teal;
        color: white;
        text-align: center;
        font-size: 40px;
        font-weight: bold;
        padding: 8px;
      }
      #div1{
        width: 600px;
        margin-left: 150px;
        margin-top: -20px;
        background-color: whitesmoke;
        padding-bottom: 30px;
        height: 510px;
        margin-bottom: 100px;

      }
      #chat{
        width: 600px;
        height: 50px;
        float: left;
        margin-left: 30px;
        margin-bottom: 30px;
        margin-top: 50px;
        font-size: 21px;
      }
      #sendbutton{
        float: left;
        margin-top: 50px;
        width: 150px;
        height: 55px;
        font-size: 25px;
        font-weight: bold;
        margin-left: 5px;
      }
      table{
        margin-left: 440px;
      }
      #td1{
        float: right;
        background-color: #0083fe;
        padding: 10px;
        color: white;
        border-radius: 20px;
        max-width: 230px;
        font-size: 19px;
        margin-top: 6px;
      }
      #div2{
        overflow: auto;
        width: 770px;
        height: 400px;
        padding: 10px;
      }
    </style>
    </head>
    <body>
        <div id="div1">
            <p id="p1">Chat Application</p>
            <div id="div2">
                <table>
                <?php
                //error_reporting(0);
                include 'connect.php';
                //if(!isset($_SESSION['email'])){
                    //header('location:index.php');
                    //}
                    //$email=$_SESSION['email'];
                    //$username=$_SESSION['username'];
                $sql1="SELECT * from chat";
                $query1=mysqli_query($con,$sql1);
                while ($info=mysqli_fetch_array($query1)) {
                    ?>
                    <tr>
                    <td id="td1"><?php echo $info['msg']; ?></td>
                    <td id="td2"><?php echo formatDate($info['time']); ?></td>
                    </tr>

                    <?php
                    function formatDate($date){
                        return date('g:i a',strtotime($date));
                    }
                }

                ?>
                </table>
                <form action="D_msg.php" method="post">
                <textarea id="chat" name="chat" rows="8" cols="80" placeholder="Write Message" required></textarea>
                <input id="sendbutton" type="submit" name="send" value="Send">

                </form>
                <?php
                    if (isset($_POST['send'])) {
                    header("Location: D_msg.php");
                    $chat=$_POST['chat'];
                    $sql="INSERT INTO chat (chat) values('$chat')";
                    $query=mysqli_query($con,$sql);
                    }
                ?>
            </div>
        </div>
    </body>
</html>
*/