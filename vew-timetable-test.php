<?php
session_start();

include "./connection/dbconn.php";
$sql = "SELECT * FROM portfolio WHERE systemuser_idsystemuser = 8";
$qry = mysqli_query($dbconn, $sql);
$result = mysqli_fetch_assoc($qry);
?>
<html>
    <body>
        <img src="<?php echo $result['timetable'];?>" alt ="timetable"/>
    </body>

</html>