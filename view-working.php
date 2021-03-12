<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM workingexp a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser ORDER BY id_workexp DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Past Working Experience</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="20%">Year Start</th>
  <th width="20%">Year End</th>
  <th width="40%">Position</th>
  <th width="40%">Institute/Company</th>
  <th width="10%">Remove</th>
  
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["startYear_workexp"].'</td>
  <td>'.$row["endYear_workexp"].'</td>
  <td>'.$row["position_workexp"].'</td>
  <td>'.$row["institute_workexp"].'</td>
  <td><button type="button" name="remove" data-row="row"+count+"" class="btn btn-danger btn-xs remove">-</button></td>
  
 </tr>
 ';
}

    
$output .= '</table>';
echo $output;
?>
<script>
    $(document).on('click', '.remove', function(){
  var delete_row = $(this).data("row");
  $('#' + delete_row).remove();
 });
</script>