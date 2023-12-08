<html><head><title>Chat</title>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <?php
    session_start();
    include 'connect.php';

    if (isset($_SESSION['username']) && isset($_SESSION['chat_user'])) {
        $username = $_SESSION['username'];
        $chat_user = $_SESSION['chat_user'];
    }

    if (isset($_POST['send'])) {
        $message = $_POST['message'];
        $sender = $_SESSION['username'];
        $receiver = $_SESSION['chat_user'];

        $query = "INSERT INTO chat (sender, receiver, msg) VALUES (?, ?, ?)";
        $stmt = $con->prepare($query);
        $stmt->bind_param("sss", $sender, $receiver, $message);

        if (!$stmt->execute()) {
            die("Query execution failed: " . $stmt->error);
        }
        $stmt->close();
    }
    if (isset($_SESSION['chat_user'])) {
            echo "<h1>Chatting with " . $_SESSION['chat_user'] . "</h1>";
            echo "<div id='chat-box' style='height: 300px; overflow-y: scroll;'>";

            $user1 = $_SESSION['username'];
            $user2 = $_SESSION['chat_user'];
            $query = "SELECT * FROM chat WHERE (sender = '$user1' AND receiver = '$user2') OR (sender = '$user2' AND receiver = '$user1') ORDER BY time";
            $result = $con->query($query);

            while ($row = $result->fetch_assoc()) {
                if($row['sender']===$user1){
                    echo "<br><br><p style='float:right;'><strong><b>" . $row['sender'] . ":</b></strong> ". $row['time']. "<br><br>" . "<strong><b>" . $row['msg'] . "</b></strong></p>";
                }else{
                    echo "<br><br><p><strong><b>" . $row['sender'] . ":</b></strong> ". $row['time']. "<br><br>" . "<strong><b>" . $row['msg'] . "</b></strong></p>";
                
                
                
                
                    //this part wrong



                }
            }

            echo "</div><form method='post' action='dm_con.php'>";
            echo "<input type='text' name='message' placeholder='Type your message...'>";
            echo "<input type='submit' name='send' value='Send'>";
            echo "</form></div>";
        } else {
            echo "Please select a user to start chatting.";
        }
?>
<script>
    function scrollToBottom() {
        var chatBox = document.getElementById("chat-box");
        chatBox.scrollTop = chatBox.scrollHeight;
    }
    scrollToBottom();
</script>

    <script>
        $(document).ready(function() {
            $("#message-form").submit(function(e) {
                e.preventDefault(); // Prevent the default form submission

                var message = $("input[name='message']").val(); // Get the message input value

                // Send the message using AJAX
                $.ajax({
                    type: "POST",
                    url: "dm_con.php", // Replace with your PHP script for sending messages
                    data: { message: message }, // Data to be sent
                    success: function(response) {
                        // Update the chat box with the new message
                        $("#chat-box").append(response);
                        // Clear the message input
                        $("input[name='message']").val("");
                    }
                });
            });
        });
    </script>
    