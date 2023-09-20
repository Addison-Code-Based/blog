<?php //remove user if not logged in
    include('session.php');
    if(!isset($_SESSION['login_user'])){
		header("location: login.php");
		die();
    }
   
    if($_POST) { //validate/sanitize data and insert into database
		date_default_timezone_set('US/Eastern');
		$date=date("h:i:sa m/d/Y");
		
		$topicCreate = $_POST['topicCreate'];
		$topicCreateSanitized = filter_var($topicCreate, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$replyCreate = $_POST['replyCreate'];
		$replyCreateSanitized = filter_var($replyCreate, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
		$catID = $_POST['catID'];
		
		$sql = "INSERT INTO ams539.topics (topicName, dateCreated, categoryID_fk, userID_fk) VALUES ( '{$topicCreateSanitized}', '{$date}', '{$catID}', '{$login_sessionID}' )";
        $resultFromInsert = mysqli_query($connect, $sql);
        if($resultFromInsert){
            echo "<h1>Successfully added topic!</h1>";
        }
        else {
            die("Database query failed" . $sql);
        }
		//do quick query to get the topic id that was just created for the reply insert
		$sql2 = "SELECT MAX(topicID) FROM ams539.topics";
		$result = mysqli_query($connect,$sql2);
			while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)) {
					$topicID = $row['MAX(topicID)'];
			}
	    $sql3 = "INSERT INTO ams539.replies (reply, dateCreated, topicID_fk, userID_fk) VALUES ( '{$replyCreateSanitized}', '{$date}', '{$topicID}', '{$login_sessionID}' )";
        $resultFromInsert2 = mysqli_query($connect, $sql3);
        if($resultFromInsert2){
            echo "<h1>Successfully added reply!</h1>";
        }
        else {
            die("Database query failed" . $sql3);
        }
    }
?>
<!doctype html>
<html lang ="en">
<head>
	<meta charset="utf-8">
	<title>Midterm Create Topic Confirmation</title>
	<meta name="author" content="Addison Shroyer">
	<link rel="stylesheet" type="text/css" href="homework.css">
</head>
<body>
   <h1>Logged in as <?php echo $login_session; ?></h1> 
   <h2><a href = "categories.php">Return to Main Forum</a></h2>
   <h2><a href = "logout.php">Log Out</a></h2><br>   
</body>
</html>
	