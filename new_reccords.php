<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Record</title>
    <style>
        .centered_div {
            max-width: 700px;
            margin: 20px auto;
        }
    </style>
</head>
<body>
    <div class="centered_div">
    <?php
        session_start();

        if (isset($_SESSION['validate_user_is_ok']) && $_SESSION['validate_user_is_ok'] == 1) {
            echo "<h3>Нов на запис</h3>";

            if (isset($_POST['confirm'])) {

                $first_date = trim(htmlspecialchars($_POST['first_date']));
                $second_date = trim(htmlspecialchars($_POST['second_date']));
                $message_me = trim(htmlspecialchars($_POST['message_me']));
                

                $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
                $result = mysqli_query($connection, "INSERT INTO stop_period (first_date, second_date, stop_period.message) VALUES ('$first_date', '$second_date', '$message_me')");

                if ($result) {
                    header('Location: work_with_periods.php');
                } else {
                    echo mysqli_error($connection);
                }

            }
            else {
                echo '<form action="" method="POST">';
                echo '<input type="text" name="first_date" placeholder="Първа дата: г-м-д">';
                echo '<input type="text" name="second_date" placeholder="Втора дата г-м-д">';
                echo '<input type="text" name="message_me" placeholder="Съобщение">';
                echo '<input type="submit" value="Save" name="confirm">';
                echo '</form>';
            }
        
        } else{
            header('Location: index.php');
        }
    ?>
    </div>
</body>
</html>