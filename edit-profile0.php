<?php
session_start();
if(isset($_POST['submit'])){
    include "./connection/dbconn.php";
    if($_POST['submit'] == "save"){
        var_dump($_POST['user']);
        //echo $_FILES["profileimg"];
            date_default_timezone_set("Asia/Kuala_Lumpur");
            $currentdate = date('Y-m-d H:i:s',time());
            $errors = array();
            $updateProfile = "UPDATE systemuser SET ";
            if($_POST['user']['officeno']!="" ){
                $officephone = strval($_POST['user']['officeno']);
                $updateProfile .= "officephonenum='$officephone',";
            }
            if($_POST['user']['hpno']!=""){
                $hpno = strval($_POST['user']['hpno']);
                $updateProfile .= "hpnum = '$hpno',";
            }
            if($_POST['user']['currPos']!=""){
                $currentPos = $_POST['user']['currPos'];
                $updateProfile .= "currentpos = '$currentPos',";
            }
            if($_POST['user']['datejoin']!=""){
                $dateJoin = $_POST['user']['datejoin'];
                $updateProfile .= "datejoinuitm='$dateJoin',";
            }
            if($_POST['user']['campus']!=""){
                $campus= $_POST['user']['campus'];
                $updateProfile .= "id_campus = '$campus',";
            }
            //update data
            // $updateProfile = "UPDATE systemuser 
            // SET hpnum = '$hpno', officephonenum='$officephone', datejoinuitm='$dateJoin', 
            // edit_DATETIME = '$currentdate', currentpos = '$currentPos', dptcampus_id = '$dptcampus'
            // WHERE user_user_id='".$_SESSION['staffid']."'";
            $updateProfile .= "edit_DATETIME = '$currentdate' WHERE user_user_id='".$_SESSION['staffid']."'";
            //echo $updateProfile;
            if(mysqli_query($dbconn, $updateProfile)){

            }else{
                array_push($errors, mysqli_error($dbconn));
            }
            $pic = $_FILES["profileimg"];
            //update profile pic
            if(isset($pic) && ($pic['tmp_name'] != "" || $pic['tmp_name'] != null)){
                print_r($pic);
                //get file name
                $picname = $pic['name'];
                //get tmp name
                $pictmp = $pic['tmp_name'];
                //get file size
                $picSize = $pic['size'];
                //get error
                $picErr = $pic['error'];
                //get file type
                $picType = $pic['type'];

                /**
                 * dapatkan file extension
                 * untuk hadkan file ape boleh upload
                 */
                $fileExt = explode('.', $picname);
                /**
                 * memudahkan penggunaan file ext
                 * biasanya file extension semua small letter 
                 * */ 
                $fileExt = strtolower(end($fileExt));

                //specify jenis file yang boleh diupload
                $allowed = array('jpeg', 'jpg', 'png', 'gif','svg');
                
                //check allowed file n file extension
                if(in_array($fileExt, $allowed)){
                    //make sure no error
                    if($picErr === 0){
                        //make new name for file so it will not change the other file
                        /**
                         * 2 option gambar 
                         * 1 - semua upload & x akan delete
                         * 2 - replace gambar bagi setiap kali upload
                         */
                        //1 st option
                        //$picNewName = $_SESSION['staffid']."-".uniqid('', true).".".$fileExt;
                        //2 nd option
                        $picNewName = $_SESSION['staffid'].".".$fileExt;
                        //set file destination
                        $fileDestination = "./uploads/img-profile/".$picNewName;
                        /**
                         * move the file to the set location
                         * 1st param => temporary location == tempname
                         * 2nd param => new location
                         */
                        move_uploaded_file($pictmp, $fileDestination);
                        $sqlUpdatePic = "UPDATE systemuser SET profilepic='$fileDestination' WHERE user_user_id = '".$_SESSION['staffid']."'";
                        //echo $sqlUpdatePic;
                        if(mysqli_query($dbconn,$sqlUpdatePic)){

                        }else{
                            //echo mysqli_error($dbconn);
                            array_push($errors, mysqli_error($dbconn));
                        }
                        
                    }else{
                        array_push($errors, "WARNING: THERE WAS AN ERROR IN THE UPLOADED FILE");
                    }
                }else{
                    array_push($errors, "WARNING: UPLOADED FILE ARE NOT ALLOWED");
                }
             }
            
            //indication errors found or not
             if(sizeof($errors)>0){
                //foreach($errors as $error){echo $error;}
                $errors = addslashes(json_encode($errors));
                echo "<script>window.alert('ERRORS FOUND: ".$errors."');</script>";
             }
            else{
                echo "<script>window.alert('SUCESSFULLY UPDATED');</script>";
             }
         }
}else{
    header("location: edit-profile.php");
}

?>