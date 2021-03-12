<?php
//insert.php
if(isset($_POST["startYear_admin"]))
{
 $connect = mysqli_connect("localhost", "root", "", "etp");
 session_start();
 $yearS = $_POST["startYear_admin"];
 $yearE = $_POST["endYear_admin"];
 $pos = $_POST["position_admin"];
 $inst = $_POST["institute_admin"];
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
   INSERT INTO adminexp(systemuser_idsystemuser,startYear_admin, endYear_admin, position_admin, institute_admin) 
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

