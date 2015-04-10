<h1>Login</h1>
<form method="POST">
<table celpadding="1"><tr>
    <td>Username:</td> <td><input type="text" name="username"></td></tr>
    <tr><td>Password:</td> <td><input type="password" name="password"></td></tr><br />
    <tr><td>
    <input type="submit" value = Login></td></tr></table><br />
</form>

<?php
session_start();
    if(isset($_POST['username'], $_POST['password'])){
        require 'core/connect.php';

        $query = dbConnect()->prepare("SELECT username, password FROM users WHERE username=:username AND password=:password");
        $query->bindParam(':username', $_POST['username']);
        $query->bindParam(':password', md5($_POST['password']));
        $query->execute();

        if($row = $query->fetch()){
            $_SESSION['username'] = $row['username'];
            $_SESSION['login'] = 1;
            header("Location: index.php");
        }
        else
        	print("Invalid Username/Password<br />");
    }
    echo '<a href="register.php">Register here!</a><br />';
?>
