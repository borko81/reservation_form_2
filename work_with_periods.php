<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">

    <title>Periods</title>
    <style>
        .centered_div {
            max-width: 700px;
            margin: 20px auto;
        }
        table {
            border-collapse: collapse;
        }
        th, td {
            width: 350px;
            text-align: left;
        }
        .what_i_like {
            text-transform: uppercase;
            letter-spacing: .2rem; 
        }
    </style>
</head>
<body>
    <div class="centered_div">
    <h3>Стоп или редакция на период</h3>
    <?php

        session_start();
        if (isset($_SESSION['validate_user_is_ok']) && $_SESSION['validate_user_is_ok'] == 1) {

            function retur_all_rows() {
                $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
                $row_check = mysqli_query($connection, "SELECT * FROM stop_period");

                $rowCount = mysqli_num_rows($row_check);

                if ($rowCount > 0) {
                    echo "<table class='table'>";
                    echo "<thead>";
                    echo "<tr>";
                    echo "<th>Id</th>";
                    echo "<th>First Date</th>";
                    echo "<th>Second Date</th>";
                    echo "<th>Message</th>";
                    echo "<th colspan='2'>Action</th>";
                    echo "</tr>";
                    echo "</thead>";

                   foreach ($row_check as $row) {
                        // var_dump($row);
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>" . $row['first_date'] . "</td>";
                        echo "<td>" . $row['second_date'] . "</td>";
                        echo "<td>" . $row['message'] . "</td>";
                        echo "<td><a class='btn btn-info' href='update.php?id=" . $row['id'] . "'>Edit</a></td>";
                        echo "<td><a class='btn btn-danger' href='delete.php?id=" . $row['id'] . "'>Delete</a></td>";
                        echo "</tr>";
                   }
                   echo "<tr><td colspan='6'><a href='new_reccords.php' class='btn btn-primary form-control what_i_like'>Нов Запис</a></td></tr>";
                   echo "</table>";

                } else {
                    return false;
                }
            }
            retur_all_rows();
        }
        
        else {
            echo "Not corect login";
        }
    ?>
    </div>
</body>
</html>