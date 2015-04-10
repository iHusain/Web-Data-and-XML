<?php
session_start();
if (($_SESSION['login'])==1) {
    if ($_POST['submitMsg']) {
        $message = $_POST['message'];
        require 'core/connect.php';
        
        try {
            $username = $_SESSION['username'];
            echo $_GET['id'];
            $query = dbConnect()->prepare("insert into posts (postedby, message, datetime, follows) values('$username','$message',NOW(),'$_GET[id]')");
        	$query->execute();
            $query->commit();
            
            header('Location: index.php');
        }
        catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        } 
    }
    ;
};
if ($_POST['home']) {
    header('Location: index.php');
}
;
?>

<html>
<head>
</head>
<body>
	<div>
		<div>
			<center><h2>Post a Message</h2></center>
		</div>
		<br/><br/>
		<center>
			<form method= "POST">
				<input type = "textarea" name = 'message'/>
				<input type="submit" value= "Post Message" name = "submitMsg" />
				<br/>
				<br/>
				<input type="submit" value= "Home" name = "home"/>
			</form>
		</center>
	</div>
</body>
</html>
