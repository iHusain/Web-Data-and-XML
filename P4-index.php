<?php

session_start();

if ($_SESSION['login'] == 1) {
    if ($_POST['signout']) {
        unset($_SESSION['username']);
        unset($_SESSION['login']);
        header('Location: index.php');
    }
    if ($_POST['post']) {
        header('Location: post.php');
    }
    if ($_POST['reply']) {
        $_Session['messageID'];
        header('Location: post.php?id=' . $_POST['id']);
    }
} else {
    
    header('Location: login.php');
    
}
;
$username = $_SESSION['username'];  
require 'core/connect.php';
$query = dbConnect()->prepare("SELECT * from posts where postedby ='$username' order by datetime");
$exec = $query->execute();

?>      

    <html>
    <head>
    	<title>Message Board</title>
    </head>
    
    <body>
    	<center>
			Hi <?
			echo $username;
			?>!<br/>
		
		<form name = 'message' method = "POST"> 
			<input type="hidden" name="id" value="<?php
			echo $_POST['id'];
			?>"/>
			<input type="submit" name = "post" value= "New Post"/>
			<input type="submit" value= "Logout" name = 'signout'/>
		</form>
		</center>
    	<?php
		while ($row = $exec->fetch()) {
			if ($row['5'] == null) {
				print("New Post" . "<br/>");
				print("Message id: " . $row['0'] . "<br/>" . "Message: " . $row['1'] . "<br/>" . "Posted by: " . $row['2'] . "<br/>" . "Name: " . $row['3'] . "<br/>" . "Timestamp: " . $row['4'] . "<br/>");
		?>
			
			<form name = 'reply' method = "POST" >
			<input type = "hidden" name='id' value="<?
				echo ($row['0']);
		?>"/>
			<input type="submit" name = "reply" value= "Reply"/>
			</form>
			<?
			} else {
				if ($row['5'] != null) {
					print("Reply : " . $row['5'] . "</u><br/>");
					print("Message id: " . $row['0'] . "<br/>" . "Message: " . $row['1'] . "<br/>" . "Posted by: " . $row['2'] . "<br/>" . "Name: " . $row['3'] . "<br/>" . "Timestamp: " . $row['4']);		
		?>
			
			<form name = 'reply' method = "POST" >
				<input type = "hidden" name='id' value="<?
						echo ($row['0']);
			?>"/>
				<input type="submit" name = "reply" value= "Reply"/>
			</form>
			<?
				}
			}
			;
		}

		?>
	</div>
</body>
</html>
