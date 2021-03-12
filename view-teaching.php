<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM teachingexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_teachexp DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Past Teaching Experience</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">Year Start</th>
  <th width="20%">Year End</th>
  <th width="40%">Position</th>
  <th width="40%">Institute/Organisations</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["startYear_teachexp"].'</td>
  <td>'.$row["endYear_teachexp"].'</td>
  <td>'.$row["position_teachexp"].'</td>
  <td>'.$row["institute_teachexp"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>