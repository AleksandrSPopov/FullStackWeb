<html>

<body>
    <form method="POST">
        First size:
        <input type="text" name="SizeOne" /><br />
        Second size: <input type="text" name="SizeTwo" /><br />
        <input type="submit" name="submit" value="count" /><br />
    </form>
</body>

</html>

<?php
$size_1 = $_POST['SizeOne'];
$size_2 = $_POST['SizeTwo'];
$area = $size_1 * $size_2;
echo "First size = ", "$size_1 <br/>";
echo "Second size = ", "$size_2 <br/>";
echo "Area = First size * Second size <br/>";
echo "Area = ", $area;
?>