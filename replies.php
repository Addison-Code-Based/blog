<?php
   include('session.php');
?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>Midterm Replies</title>
	<meta name="author" content="Addison Shroyer">
	<link rel="stylesheet" type="text/css" href="homework.css">
	<style>
		table, th, td {
		border: 1px solid black;
		}
	</style>
	<!--Made with much help from Jacky Joice-->
</head>
<body>
	<?php //top of page changes based on if a user is logged in
		if(isset($_SESSION['login_user'])){
			echo "<h1>Logged in as " . $login_session . "</h1><br><h2><a href = 'logout.php'>Log Out</a></h2>";
		}
    ?> 
    <h2><a href = "categories.php">Return to Main Forum</a></h2>
    <?php
    if(!isset($_SESSION['login_user'])){
		echo "<h2><a href = 'logout.php'>Log In</a></h2>";
    }
	?>
	<table style="width:100%">
		<tr>
		<th>Replies</th>
		<th>Author</th>
		<th>Date</th>
		</tr>
		<?php
			if($_POST) { //declare relevant variables
				$topicID = $_POST['topicID'];
				$catName = $_POST['catName'];
				$topicName = $_POST['topicName'];
				//tell user what they clicked on
				echo "<h2>" . $catName . " - " . $topicName . "</h2>";
			}
			//populate table from replies table
			$sql = "SELECT replyID, reply, firstName, dateCreated FROM ams539.replies INNER JOIN ams539.users ON userID_fk=userID WHERE topicID_fk = $topicID";
			$result = mysqli_query($connect,$sql);
			if (mysqli_num_rows($result) > 0) {
			// output data of each row
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$reply = $row['reply'];
					$replyID = $row['replyID'];
					$date = $row['dateCreated'];
					$name = $row['firstName'];
					
					echo "<tr><td>" . $reply . "</td><td>" . $name . "</td><td>" . $date . "</td></tr>";
				}
	echo "</table>";
			}		 
			else { //if there isn't a reply
				echo "Be the first to reply to this?" . "<br>"; 
			}
			//create option to add reply and pass hidden data needed
			if(isset($_SESSION['login_user'])){
				echo "<form action='reply_create.php' method='post'>" . "<input type='hidden' id='topicID' name='topicID' value='$topicID'>" . "<input type='hidden' id='topicName' name='topicName' value='$topicName'>" . "<input type='hidden' id='catName' name='catName' value='$catName'>" . "<input type='submit' value='Post Reply?'>";
			}
		?>
</body>
</html>