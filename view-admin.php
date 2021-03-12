<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM adminexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_admin DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Past UiTM Administrative Experience</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">Year Start</th>
  <th width="20%">Year End</th>
  <th width="40%">Position</th>
  <th width="40%">Institute</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["startYear_admin"].'</td>
  <td>'.$row["endYear_admin"].'</td>
  <td>'.$row["position_admin"].'</td>
  <td>'.$row["institute_admin"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>