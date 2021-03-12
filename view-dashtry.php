<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM subject a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY idsubject DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Subject Registered</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">COURSE CODE</th>
  <th width="40%">UPLOAD MATERIAL</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["name_course"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>