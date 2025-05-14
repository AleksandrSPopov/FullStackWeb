<html>

<head>
    <meta charset="utf-8">
</head>

<body>
    <form method="POST">
        Сегодня рабочий день <input type="radio" name="radio1" value="рабочий" /><br />
        Сегодня выходной день <input type="radio" name="radio2" value="выходной" /><br />
        Сегодня четный день <input type="radio" name="radio3" value="четный" /><br />
        Сегодня нечетный день <input type="radio" name="radio4" value="нечетный" /><br />
        <input type="submit" name="submit" value="Start" /><br />
    </form>
</body>

</html>

<?php
$working_day = $_POST['radio1'];
$day_off = $_POST['radio2'];
$even = $_POST['radio3'];
$odd = $_POST['radio4'];
$duty_1 = "Вася";
$duty_2 = "Петя";

if ($working_day) {
    echo "Выберите четный или нечетный день";
}
if ($working_day & $even) {
    echo "Сегодня $working_day $even день, поэтому дежурит $duty_1";
} else {
    echo "Сегодня $working_day $odd день, поэтому дежурит $duty_2";
}
#else ($day_off) {
#echo "Сегодня $day_off день, поэтому никто не дежурит";
#} else {
#   echo "Выберите день";
#}
?>