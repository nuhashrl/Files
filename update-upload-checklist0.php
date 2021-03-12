<?php
session_start();
include "./connection./dbconn.php";
if(isset($_POST["submit"])){
    //var_dump($_POST['item']);
    //$idportfolio = $_POST['idportfolio'];
    //print_r($_FILES['item']);
    //echo "<br>";
    //print_r($_POST['idportcheck']);
    date_default_timezone_set("Asia/Kuala_Lumpur");
    $currentdate = date('Y-m-d H:i:s',time());
    $filesname = array();
    $tempnames = array();
    $fileErrors = array();
    $filesExt = array();
    $portchk = array();
    $errors = array();
    foreach($_FILES['item']['name'] as $filename){
        if(isset($filename)){
            array_push($filesname, $filename);
            //echo $file."<br>";
        }
     }
    //exit get name
    //get tempname
    foreach($_FILES['item']['tmp_name'] as $tempname){
        if(isset($tempname)){
            array_push($tempnames, $tempname);
        }
     }
     //exit get tempname
    //get file error
    foreach($_FILES['item']['error'] as $fileError){
        if(isset($fileError)){
            array_push($fileErrors, $fileError);
        }
     }
    //exit get Error
    //get file extension
    foreach($filesname as $filename){
        if(isset($filename)){
            $fileExt = explode('.',$filename);
            $fileExt = strtolower(end($fileExt));
            array_push($filesExt, $fileExt);
        }
     }
    
    //get id portcheck
    foreach($_POST['idportcheck'] as $idportcheck){
        if(isset($idportcheck)){
            array_push($portchk, $idportcheck);
        }
    }

    //exit get extension
    //make an array for allowed file
    $allowed = array('pdf','jpeg', 'jpg', 'png', 'gif','svg');
    //evaluate file extension
    $index = 0;
        //echo "<br><br>";
        //echo count($filesExt);
        //echo "<br><br>";
        /*
        foreach($filesExt as $f){
            echo $f;
        }*/
    foreach($filesExt as $fileExt){
        if($fileExt != null || $fileExt != ''){
            if(in_array($fileExt, $allowed)){
                if($fileErrors[$index] === 0){
                    $selSId = "SELECT b.checkitem,a.idport_check FROM port_check a 
                    JOIN checklist b ON b.idchecklist = a.checklist_id 
                    WHERE idport_check = '$portchk[$index]'";
                    $rSPort = mysqli_fetch_assoc(mysqli_query($dbconn, $selSId));
                    $fileNewName = "".$_SESSION['staffid']."-".$rSPort['idport_check'].".".$fileExt;
                    $fileDestination = "./uploads/portfolio-items/".$fileNewName;
                    /**
                     * move the file to the set location
                     * 1st param => temporary location == tempname
                     * 2nd param => new location
                     */
                    move_uploaded_file($tempnames[$index], $fileDestination);
                    //echo $index."<br>";
                    $sqlUpdateFileLoc = "UPDATE port_check SET edit_DATETIME = '$currentdate', workstatus = 1, uploadURL = '$fileDestination' 
                    WHERE idport_check='$portchk[$index]'";
                    if(!mysqli_query($dbconn, $sqlUpdateFileLoc)){
                        array_push($errors, mysqli_error($dbconn));
                    }
                }else{
                    array_push($errors, "WARNING: THERE WAS AN ERROR IN THE UPLOADED FILE");
                }
            }else{
                array_push($errors, "ERROR: FILE FORMAT");
            }
        }
        $index++;
    }
    if(sizeof($errors) == 0){
        echo "<script>window.alert('SUCCESSFULLY UPDATED');window.location.href='./view-checklist.php';</script>";
    }else{
        $jserrors = json_encode($errors);
        echo "<script>window.alert('".addslashes($jserrors)."');</script>";
    }
}else{
    echo "<script>window.alert('NO DATA');window.location.href='./view-checklist.php';</script>";
}
?>