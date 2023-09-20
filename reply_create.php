<?php //remove user if not logged in
    include('session.php');
    if(!isset($_SESSION['login_user'])){
		header("location: login.php");
		die();
    }
   
    if($_POST) { //declare relevant variables
		$topicID = $_POST['topicID'];
		$catName = $_POST['catName'];
		$topicName = $_POST['topicName'];
    }
?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>Midterm Create Reply</title>
	<meta name="author" content="Addison Shroyer">
	<link rel="stylesheet" type="text/css" href="homework.css">
</head>
<body>
    <h1>Logged in as <?php echo $login_session; ?></h1> 
    <h2><a href = "categories.php">Return to Main Forum</a></h2>
    <h2><a href = "logout.php">Log Out</a></h2><br>
	<?php //create form that passes relevant data
		echo "<h2>" . $catName . " - " . $topicName . "</h2>"; //show user what topic they are adding to
		echo "<form action='reply_create_confirm.php' method='post'>";
		echo "<h2>Reply:<h2>";
		echo "<textarea name='replyCreate' cols='100' rows='10' value='' required></textarea>" . "<br>";
		echo "<input type='hidden' id='topicID' name='topicID' value='$topicID'>";
		echo "<input type='submit' name='submit' value='Post Reply'>";
		echo "</form>";
    ?>
    <input type="button" name="cancel" value="Cancel" onClick="window.location.href='categories.php'">
</body>
</html>
	