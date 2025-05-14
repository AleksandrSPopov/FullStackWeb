<?php
$tmp_file_name = $_FILES['userFile']['tmp_name'];
$file_name = $_FILES['userFile']['name'];
$dest = $_SERVER['DOCUMENT_ROOT'] . "/upload/" . $_FILES['userFile']['name'];
$upload = move_uploaded_file($tmp_file_name, $dest);
$cont = file_get_contents($dest);
echo $cont;
?>