<?php
//insert.php
if(isset($_POST["courseId"]))
{

 $connect = mysqli_connect("localhost", "root", "", "etp");
 session_start();
 
 $iduser = $_SESSION['userid'];
 $subjects = $_POST["courseId"];
 $sessionId = $_POST["sessionId"];
 
 $query = '';
 foreach($subjects as $subject)
 {
 
   if($subject != '')
  {
      
   $query .= '
   INSERT INTO subject(systemuser_idsystemuser,id_course, SEMESTER_ID )
   VALUES("'.$iduser.'","'.$subject.'","'.$sessionId.'"); ';
      
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

