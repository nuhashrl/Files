<?php
//insert.php
if(isset($_POST["date_aq"]))
{
 $connect = mysqli_connect("localhost", "root", "", "etp");
 session_start();
 $yearS = $_POST["date_aq"];
 $yearE = $_POST["organisation_aq"];
 $pos = $_POST["qualification_aq"];
 $inst = $_POST["areaExpertise_aq"];
 $iduser = $_SESSION['userid'];
 $query = '';
 for($count = 0; $count<count($yearS); $count++)
 {
  $yearS_clean = mysqli_real_escape_string($connect, $yearS[$count]);
  $yearE_clean = mysqli_real_escape_string($connect, $yearE[$count]);
  $pos_clean = mysqli_real_escape_string($connect, $pos[$count]);
  $inst_clean = mysqli_real_escape_string($connect, $inst[$count]);
  if($yearS_clean != '' && $yearE_clean != '' && $pos_clean != '' && $inst_clean != '' )
  {
      
   $query .= '
   INSERT INTO academicqualification(systemuser_idsystemuser,date_aq, organisation_aq, qualification_aq, areaExpertise_aq) 
   VALUES("'.$iduser.'","'.$yearS_clean.'", "'.$yearE_clean.'", "'.$pos_clean.'", "'.$inst_clean.'"); 
   ';
  }
 }
 if($query != '')
 {
  if(mysqli_multi_query($connect, $query))
  {
   echo 'Item Data Inserted';
  }
  else
  {
   echo 'Error';
  }
 }
 else
 {
  echo 'All Fields are Required';
 }
}
?>

