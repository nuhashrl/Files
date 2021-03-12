<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM academicqualification a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_aq DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Academic Qualification</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">Date</th>
  <th width="20%">Organisation/ University</th>
  <th width="40%">Qualification</th>
  <th width="40%">Area Of Expertise</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["date_aq"].'</td>
  <td>'.$row["organisation_aq"].'</td>
  <td>'.$row["qualification_aq"].'</td>
  <td>'.$row["areaExpertise_aq"].'</td>
 </tr>
 ';
}
$output .= '</table>';
echo $output;
?>