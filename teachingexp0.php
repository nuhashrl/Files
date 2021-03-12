<?php
//insert.php
if(isset($_POST["startYear_teachexp"]))
{
 $connect = mysqli_connect("localhost", "root", "", "etp");
 session_start();
 $yearS = $_POST["startYear_teachexp"];
 $yearE = $_POST["endYear_teachexp"];
 $pos = $_POST["position_teachexp"];
 $inst = $_POST["institute_teachexp"];
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
   INSERT INTO teachingexp(systemuser_idsystemuser,startYear_teachexp, endYear_teachexp, position_teachexp, institute_teachexp) 
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

