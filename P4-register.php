<h1>Register</h1>
<form method="POST">
    <table cellpadding="2"><tr><td>Username:</td>
    <td><input type="text" name="username"></td></tr>
    <tr><td>Full Name:</td>
    <td><input type="text" name="fullName"></td></tr>
    <tr><td>Email:</td>
    <td><input type="text" name="email"></td></tr>
    <tr><td>Password:</td>
    <td><input type="password" name="password"></td></tr>
    
    <tr><td><input type="submit" value="Register"></td></tr></table>
</form>

<?php
session_start();

    if(isset($_POST['username'], $_POST['password'],$_POST['fullName'], $_POST['email'])){
        require 'core/connect.php';
        $username = $_POST['username'];
        $email = $_POST['email'];
        
        $query = dbConnect()->prepare("SELECT * from users where username='$username'");
        $row = $query->execute();
        $result = $query->fetch();
        $duplicateEmail = $result['3'];
        $duplicateUsername = $result['0'];
        
        if($email == $duplicateEmail || $username==$duplicateUsername)
        {
        	echo ("<script type='text/javascript'>alert('User Already Exists!')</script>");
			header("Location: register.php");
			
		}
		else{

        $query = dbConnect()->prepare("INSERT INTO users (username, password, fullname, email) VALUES (:username, :password, :fullName, :email)");
        $query->bindParam(':username', $_POST['username']);
        $query->bindParam(':fullName', $_POST['fullName']);
        $query->bindParam(':email', $_POST['email']);
        $query->bindParam(':password', md5($_POST['password']));

        if($query->execute()){
        	//echo ("<script type='text/javascript'>alert('Reistered Successfully, Please login to begin!')</script>");
			header("Location: index.php");
        } else{
            echo 'ERROR';
        	}
        }
    }
?>
