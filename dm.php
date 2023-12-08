<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chat</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.0.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
    body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        h4 {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            margin: 0;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        #chat-box {
            max-height: 300px;
            overflow-y: scroll;
            padding: 10px;
            border: 1px solid #ccc;
        }

        p {
            margin: 0;
            padding: 5px 0;
            border-bottom: 1px solid #ccc;
        }

        form {
            display: flex;
            margin-top: 10px;
        }

        input[type="text"] {
            flex: 1;
            padding: 2px;
            border: 5px solid #ccc;
        }

        input[type="submit"] {
            background-color: #333;
            color: white;
            border: none;
            padding: 8px 20px;
            cursor: pointer;
        }

        .u_name{
            flex: 10;
            padding: 8px;
            border: 1px solid #ccc;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    include 'connect.php';
    $username = $_SESSION['username'];

    if (!isset($_POST['start_chat'])) {
        echo "<div class='container'><form class='example' method='post' action='dm.php'>";
        echo "<center><h4><span class='u_name'>Enter Username To Chat:</span></h4></center>";
        echo "<input type='text' placeholder='Search..' name='chat_user' required>";
        echo "<button type='submit' name='start_chat'><i class='fa fa-search'></i></button></form>";
    
        $query = "SELECT * FROM chat WHERE sender = ? OR receiver = ? ORDER BY time";
        $stmt = $con->prepare($query);
        $stmt->bind_param("ss", $username, $username);
        $stmt->execute();
        $result = $stmt->get_result();

        while ($row = $result->fetch_assoc()) {
            $chat_user = ($row['sender'] === $username) ? $row['receiver'] : $row['sender'];
            echo "<br><a href='dm_con.php?chat_user=$chat_user'>$chat_user</a>";
        }
    }
    if (isset($_SESSION['username']) && isset($_POST['start_chat'])) {
        $chat_user = $_POST['chat_user'];
        $query = "SELECT * FROM login WHERE username = '$chat_user'";
        $result = $con->query($query);

        if ($result->num_rows > 0) {
            $_SESSION['chat_user'] = $chat_user;
            header('location:dm_con.php');
        }
    }



    
    ?>


</body>
</html>
