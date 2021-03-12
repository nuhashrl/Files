<?php
//insert.php
if(isset($_POST["name_course"]))
{
 $connect = mysqli_connect("localhost", "root", "", "etp");
 session_start();
 $name = $_POST["name_course"];
 $iduser = $_SESSION['userid'];
 $query = '';
 for($count = 0; $count<count($yearS); $count++)
 {
  $name_clean = mysqli_real_escape_string($connect, $name[$count]);
  if($yearS_clean != '' )
  {
      
   $query .= '
   INSERT INTO subject(systemuser_idsystemuser,name_course) 
   VALUES("'.$iduser.'","'.$name_clean.'"); ';
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

