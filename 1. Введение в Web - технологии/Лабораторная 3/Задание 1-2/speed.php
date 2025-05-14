<html>

<body>
    <form method="POST">
        Distance:
        <input type="text" name="NewDistance" /><br />
        Time: <input type="text" name="NewTime" /><br />
        <input type="submit" name="submit" value="count" /><br />
    </form>
</body>

</html>

<?php
$distance = $_POST['NewDistance'];
$time = $_POST['NewTime'];
$speed = $distance / $time;
echo 'Distance = ', "$distance <br/>";
echo 'Time = ', "$time <br/>";
echo 'Speed = ', "$speed <br/";
?>