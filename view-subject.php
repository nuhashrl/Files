<?php
//fetch.php
$connect = mysqli_connect("localhost", "root", "", "etp");
$output = '';
$query = "SELECT * FROM subject a JOIN systemuser b ON a.systemuser_idsystemuser=b.idsystemuser JOIN  semester c ON a.SEMESTER_ID=c.SEMESTER_ID JOIN jengka.course d ON a.id_course=d.id_course ORDER BY idsubject DESC";
$result = mysqli_query($connect, $query);
$output = '
<br />
<p align="center">Course Registered</p>
<table class="table table-bordered table-striped">
 <tr>
  <th width="40%">COURSE NAME</th>
 </tr>
';
while($row = mysqli_fetch_array($result))
{
 $output .= '
 <tr>
  <td>'.$row["code_course"].'</td>
  
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