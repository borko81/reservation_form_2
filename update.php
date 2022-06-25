<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update</title>
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

            echo "<h3>Корекция на запис</h3>";

            if (isset($_GET['id'])) {
                $id = $_GET['id'];
                
                $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
                $result = mysqli_query($connection, "select * FROM stop_period where id=$id") or die ("Error acquire");

                $first_date = '';
                $second_date = '';
                $message = '';

                foreach($result as $r) {
                    $first_date = $r['first_date'];
                    $second_date = $r['second_date'];
                    $message = $r['message'];
                }

                if (isset($_POST['confirm']) && $_POST['confirm'] == 1) {
                    $edit_first_date = $_POST['first_date'];
                    $edit_second_date = $_POST['second_date'];
                    $edit_message = $_POST['new_message'];

                    
                    $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
                    $edditable = mysqli_query($connection, "update stop_period set first_date='$edit_first_date', second_date = '$edit_second_date', message='$edit_message' where id=$id") or die ("Error acquire query not save.");
                    if ($edditable) {
                        header('Location: work_with_periods.php');
                    } else {
                        echo "Error acquire, try again if you want.";
                    }
                    
                }

                else {
                    echo 'Are you sure you want to edit record with id: ' . $id. '?';
                    echo '<form action="" method="POST">';
                    echo '<input type="hidden" name="id" value="' . $_GET['id'] . '" />';
                    echo '<input type="hidden" name="confirm" value="1" />';
                    echo '<input type="text" value=' . "$first_date" . ' name="first_date">';
                    echo '<input type="text" value=' . "$second_date" . ' name="second_date">';
                    echo '<input type="text" value=' . "$message" . ' name="new_message">';
                    echo '<input type="submit" value="Yes" />';
                    echo '</form>';
                }

            }
            else {
                echo 'You must specify an ID';
            }
        } else {
            header('Location: index.php');
        }
    ?>
    </div>
</body>
</html>