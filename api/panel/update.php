<?php
    include('../../lib/db.php');
    
    // Check connection
    if ($mysqli->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
 
    if(!empty($_POST['id']) && !empty($_POST['hash']) && !empty($_POST['rfid']) && !empty($_POST['rewardpoints']))
    {
    	$id = $_POST['id'];
        $hash = $_POST['hash'];
        $rfid = $_POST['rfid'];
        $rewardmultiplier = $_POST['rewardpoints'];
 
	    $sql = "INSERT into rewarddata (dustbinid, rfid, rewardpoints) VALUES ('$id', '$rfid', $rewardmultiplier)";
        
        if ($mysqli->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $sql = "SELECT * FROM users WHERE rfid='$rfid'";
        $result = $mysqli->query($sql);
        $user   = mysqli_fetch_assoc($result);  

        if($user['currentrewards'] <= $user['level']){

            $reward = $user['rewardpoints'] + $rewardmultiplier;
            $currreward = $user['currentrewards'] + $rewardmultiplier;  
            


            $sql = "UPDATE users SET rewardpoints='$reward', currentrewards='$currreward' ";
        }
    }
    else{
        die("No POST Parameters passed.");
    }
	$conn->close();
?>
