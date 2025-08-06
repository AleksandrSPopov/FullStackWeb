<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 40px;
        }
    </style>
</head>

<body>
    <form action="action.php" method="POST">
        <label for="year">Enter your year of birth:</label>
        <input type="number" name="yearOfBirth">
        <input type="submit" value="Calculate current age">
    </form>
    <br>
    
    <?php
    $currentYear = date('Y');
    $yearOfBirth = $_POST['yearOfBirth'];
    $currentAge = $currentYear - $yearOfBirth;
    ?>
    Your current age is <?php echo $currentAge; ?> years old.
    <br>
    <br>
    <?php
    if ($currentAge >= 18) {
        echo "Your are of legal age.";
    } else {
        echo "Your are a minor.";
    }
    ?>
</body>

</html>