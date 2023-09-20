<?php
   include('session.php');
?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>Midterm Topics</title>
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
		<th>Topics</th>
		<th>Replies</th>
		<th>Author</th>
		<th>Date</th>
		</tr>
		<?php
			if($_POST) { //declare useful variables
				$catID = $_POST['catID'];
				$catName = $_POST['catName'];
				//tell user what they clicked on
				echo "<h2>" . $catName . "</h2>";
			}
			
			$sql = "SELECT topicID, topicName, firstName, dateCreated FROM ams539.topics INNER JOIN ams539.users ON userID_fk=userID WHERE categoryID_fk = $catID";
			$result = mysqli_query($connect,$sql);
			if (mysqli_num_rows($result) > 0) {
			// output data of each row
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$topicName = $row['topicName'];
					$topicID = $row['topicID'];
					$date = $row['dateCreated'];
					$name = $row['firstName'];
					//get count of replies
					$sqlRepliesCount = "SELECT replyID FROM ams539.replies WHERE topicID_fk = $topicID";
					$resultRepliesCount = mysqli_query($connect,$sqlRepliesCount);
					$repliesCount = mysqli_num_rows($resultRepliesCount);
					//add hidden info to be moved along for further queries and inserts
					echo "<tr><td>" . "<form action='replies.php' method='post'>" . "<input type='hidden' id='topicID' name='topicID' value='$topicID'>" . "<input type='hidden' id='catName' name='catName' value='$catName'>" . "<input type='hidden' id='topicName' name='topicName' value='$topicName'>" . "<input type='submit' value='$topicName'>" . "</form>" . "</td><td>" . $repliesCount . "</td><td>" . $name . "</td><td>" . $date . "</td></tr>";
				}
	echo "</table>";
			} 
			else { 
				echo "0 results"; 
			}
			// add button if logged in to add topic
			if(isset($_SESSION['login_user'])){ 
				echo "<form action='topic_create.php' method='post'>" . "<input type='hidden' id='catID' name='catID' value='$catID'>" . "<input type='hidden' id='catName' name='catName' value='$catName'>" . "<input type='submit' value='Post Topic?'>";
			}
		?>

</body>
</html>