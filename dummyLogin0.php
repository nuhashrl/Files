<?php
if(isset($_POST["submit"])){
  include "./connection/dbconn.php";
  include "./functions/password.php";
  include "./functions/timeFunction.php";
  $staffid = mysqli_real_escape_string($dbconn, $_POST["username"]);
  $pass = mysqli_real_escape_string($dbconn,$_POST["password"]);
  $sqlPass = "SELECT user_password FROM systemuser WHERE user_user_id = '$staffid'";
  $qryPass = mysqli_query($dbconn, $sqlPass);
  if($qryPass){
    if(mysqli_num_rows($qryPass)>0){
      $res = mysqli_fetch_assoc($qryPass);
      $enc_pass = $res["user_password"];
      if(dec_password($pass, $enc_pass)){
        $sqlSearch = "SELECT a.idsystemuser, b.USER_ID, b.USER_NAME, a.sysacc_idsysaccess, c.acc_code
        FROM systemuser a 
         JOIN jengka.user b ON b.USER_ID = a.user_user_id
         JOIN sysaccess c ON a.sysacc_idsysaccess = c.idsysaccess
        WHERE a.user_user_id = '$staffid'";
        // echo $sqlSearch;
        if($qrySearch = mysqli_query($dbconn, $sqlSearch)){
          if(mysqli_num_rows($qrySearch)>0){
            session_start();
            $currentDate = getTimeMal();
            $sqlUpd = "UPDATE systemuser SET login_DATETIME = '$currentDate' WHERE user_user_id = '$staffid'";
            if(mysqli_query($dbconn, $sqlUpd)){
              echo "<script>alert('update Success')</script>";
            }else{
              echo mysqli_error($dbconn);
            }
            $r = mysqli_fetch_assoc($qrySearch);
            $_SESSION['userid'] = $r['idsystemuser'];
            $_SESSION['staffid'] = $r['USER_ID'];
            $_SESSION['username'] = $r['USER_NAME'];
            $_SESSION['usertype'] = $r['sysacc_idsysaccess'];
            $_SESSION['accessCode'] = $r['acc_code']; 
            // echo $_SESSION['tp']['userid'];
            // echo "login success";
              if($_SESSION['usertype'] == 1)
              {header("location: ./dashboard.php");}
              
            
          }#end if rows
          else{
            $message = "No such User";
            echo $message;
          }
        }#end if search user detail
        else{
          echo mysqli_error($dbconn);
        }
      }
    }#end if rows
  }#end if(qryPass)
}

?>