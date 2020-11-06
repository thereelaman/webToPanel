<?php
    include('../../lib/db.php');
    
    // Check connection
    if ($mysqli->connect_error) {
        die("Database Connection failed: " . $conn->connect_error);
    }
 
    if(!empty($_POST['id']) && !empty($_POST['token']) && !empty($_POST['temperature']) && !empty($_POST['brightness']))
    {
    	$id = $_POST['id'];
        $token = $_POST['token'];
        $temperature = $_POST['temperature'];
        $brightness = $_POST['brightness'];
 
	    $sql = "INSERT into rewarddata (dustbinid, temperature, rewardpoints) VALUES ('$id', '$temperature', $rewardmultiplier)";
        
        if ($mysqli->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
        $sql = "SELECT * FROM users WHERE temperature='$temperature'";
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
