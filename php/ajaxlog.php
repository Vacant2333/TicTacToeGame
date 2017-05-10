<?php
$log = file_get_contents("../data/set.data");
echo json_encode(array('success' => true,'msg' => "$log"));
?>