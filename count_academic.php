<?php
//insert.php;

if(isset($_POST["specializationArea_aq"]))
{
 $connect = new PDO("mysql:host=localhost;dbname=etp", "root", "");
 $order_id = uniqid();
 for($count = 0; $count < count($_POST["specializationArea_aq"]); $count++)
 {  
  $query = "INSERT INTO academicqualification"; 
  (order_id, item_name, item_quantity, item_unit) 
  VALUES (:order_id, :item_name, :item_quantity, :item_unit)
  ";
  $statement = $connect->prepare($query);
  $statement->execute(
   array(
    ':order_id'   => $order_id,
    ':item_name'  => $_POST["item_name"][$count], 
    ':item_quantity' => $_POST["item_quantity"][$count], 
    ':item_unit'  => $_POST["item_unit"][$count]
   )
  );
 }
 $result = $statement->fetchAll();
 if(isset($result))
 {
  echo 'ok';
 }
}
?>
