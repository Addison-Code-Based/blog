<?php
   include('session.php');
?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>Midterm Categories</title>
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
		echo "<h1>Welcome " . $login_session . "</h1><br><h2><a href = 'logout.php'>Log Out</a></h2>";
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
		<th>Categories</th>
		<th>Topics</th>
		</tr>
		<?php //https://www.codeandcourse.com/how-to-display-database-data-in-html-table/
			//populate categories table
			$sql = "SELECT categoryID, categoryName FROM ams539.categories";
			$result = mysqli_query($connect,$sql);
			if (mysqli_num_rows($result) > 0) {
			// output data of each row
				while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$catName = $row['categoryName'];
					$catID = $row['categoryID'];
					// get count of topics
					$sqlTopicsCount = "SELECT topicID FROM ams539.topics WHERE categoryID_fk = $catID";
					$resultTopicsCount = mysqli_query($connect,$sqlTopicsCount);
					$topicsCount = mysqli_num_rows($resultTopicsCount);
					//add hidden info to be moved along for further queries and inserts
					echo "<tr><td>" . "<form action='topics.php' method='post'>" . "<input type='hidden' id='catID' name='catID' value='$catID'>" . "<input type='hidden' id='catName' name='catName' value='$catName'>" . "<input type='submit' value='$catName'>" . "</form>" . "</td><td>" . $topicsCount . "</td></tr>";
				}
	echo "</table>";
			} 
			else { 
				echo "No Categories? Uh oh, that's not good!"; 
			}
?>
</body>
</html>