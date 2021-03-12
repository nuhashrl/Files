<?php
include "./connection/dbconn.php";
if(!isset($_POST['searchTerm'])){
    $sql = "SELECT * FROM jengka.course ORDER BY id_course LIMIT 5";
    $qry = mysqli_query($dbconn, $sql);
}else{
    $search = mysqli_real_escape_string($dbconn, $_POST['searchTerm']);
    $sql = "SELECT * FROM jengka.course WHERE 
    name_course LIKE '%".$search."%' OR code_course LIKE '%".$search."%' LIMIT 10"; 
    $qry = mysqli_query($dbconn, $sql);

}
//fetch data
$data = array();
while($r = mysqli_fetch_array($qry)){
    $data[] = array(
        "id" => $r['id_course'],
        "text" => $r['code_course']." : ".$r['name_course']
    );
}
//encode in json format
echo json_encode($data);
exit;
?>