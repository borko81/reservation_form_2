<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
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
            echo "<h3>Изтриване на запис</h3>";

            if (isset($_GET['id'])) {
                $id = $_GET['id'];

                if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
                    $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
                    $result = mysqli_query($connection, "delete FROM stop_period where id=$id") or die ("Error acquire");
                    if ($result) {
                        header('Location: work_with_periods.php');
                    } else {
                        echo "Something wrong";
                    }
                }
                else {
                    echo 'Are you sure you want to delete record with id: ' . $id. '?';
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
                    echo '<input type="hidden" name="confirm" value="1" />';
                    echo '<input type="submit" value="Yes" />';
                    echo '</form>';
                }

            }
            else {
                echo 'You must specify an ID';
            }
        } else{
            header('Location: index.php');
        }
    ?>
    </div>
</body>
</html>