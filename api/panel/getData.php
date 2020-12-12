<?php
    include('../../lib/db.php');
 
    if(!empty($_GET['id']) && !empty($_GET['token']) && !empty($_GET['module']))
    {
        $id = $_GET['id'];
        $token = $_GET['token'];
        $module = $_GET['module'];

        $query = "SELECT * FROM panelData WHERE token = $token AND module = '$module'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_assoc($result);
        // if data doesn't exist, calculate it
        if(mysqli_num_rows($result) == 0){

            //get image name which is to be processed 
            $query = "SELECT data FROM panels WHERE id = $id AND token = '$token'";
            $result = mysqli_query($mysqli, $query);
            $row = mysqli_fetch_row($result);
            echo $row[0];
            $command = escapeshellcmd('python3 /var/www/thedisplay.studio/api/panel/imageToModule.py '.$row[0].' '.$id.' '.$module);
            $output = shell_exec($command);
            echo $output;
        }
        
        $query = "SELECT data FROM panelData WHERE panelID = $id AND module = '$module'";
        $result = mysqli_query($mysqli, $query);
        $row = mysqli_fetch_row($result);

        echo $row[0];
               
    }
    else{
        die("No POST Parameters passed.");
    }
?>