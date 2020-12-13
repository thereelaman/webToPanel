<?php
    include('../../lib/db.php');
    
 
    if(!empty($_GET['id']) && !empty($_GET['token']) && !empty($_GET['module']))
    {
        $id = $_GET['id'];
        $token = $_GET['token'];
        $module = $_GET['module'];

        $query = "SELECT * FROM panelData WHERE token = '$token' AND module = ".$module;
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);
 
        // if data doesn't exist, calculate it
        if(mysqli_num_rows($result) == 0){

            //get image name which is to be processed 
            $query = "SELECT data FROM panels WHERE id = ".$id." AND token = '$token'";
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_row($result);

            $rawCommand = 'python3 /var/www/thedisplay.studio/api/panel/imageToModule.py '.$row[0].' '.$id.' '.$module.' '.$token;
            echo $rawCommand;
            $command = escapeshellcmd($rawCommand);
            $output = shell_exec($command);
        }
        
        $query = "SELECT data FROM panelData WHERE token = '$token' AND module = ".$module;
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($result);
        echo $row['data'];
               
    }
    else{
        die("No GET Parameters passed.");
    }
?>