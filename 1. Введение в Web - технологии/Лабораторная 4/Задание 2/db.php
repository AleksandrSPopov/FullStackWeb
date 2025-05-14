<?php
$link = mysqli_connect('localhost', 'root', '');
mysqli_select_db($link, 'Info');
$result = mysqli_query($link, 'SELECT * FROM staff');
while ($arrStaff = mysqli_fetch_assoc($result)) {
    echo $arrStaff['id'] . "<br />";
    echo $arrStaff['FirstName'] . "<br />";
    echo $arrStaff['LastName'] . "<br />";
    echo $arrStaff['Phone'] . "<br />";
}
?>