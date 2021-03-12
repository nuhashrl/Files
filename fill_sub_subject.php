<?php

//fill_sub_category.php

include "./connection/dbconn.php";

echo fill_select_box($dbconn, $_POST["idsubject"]);

?>