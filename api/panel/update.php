<?php
    include('../../lib/db.php');
 
    if(!empty($_POST['id']) && !empty($_POST['token']) && !empty($_POST['temperature']) && !empty($_POST['brightness']))
    {
    	$id = $_POST['id'];
        $token = $_POST['token'];
        $temperature = $_POST['temperature'];
        $brightness = $_POST['brightness'];
 
	    $sql = "UPDATE panels SET temperature = $temperature, brightness = $brightness WHERE id = $id AND token = '$token'";
        
        if ($mysqli->query($sql) === TRUE) {
		    echo "OK";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
        }
        
    }
    else{
        die("No POST Parameters passed.");
    }
?>
