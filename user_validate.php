<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <title>UserLigin</title>
    <style>
        .center_div {
            max-width: 500px;
            margin: 50px auto;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    // email: korea60@abv.bg
    // password: borko

    function validate_input($value) {
        $value = trim($value);
        $value = htmlspecialchars($value);
        return $value;
    }

    function check_user_exists_in_db($email, $password) {
        $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not established.");
        $user_check = mysqli_query($connection, "SELECT * FROM unreal_users WHERE email = '{$email}' and password = '{$password}' ");
        $rowCount = mysqli_num_rows($user_check);
        if ($rowCount > 0) {
            return true;
        } else {
            return false;
        }
    }

    if (isset($_POST['from_submit'])
    && (!empty($_POST['email']))
    && (!empty($_POST['pass']))
    ) {
        $user_email = validate_input($_POST['email']);
        $user_password = validate_input($_POST['pass']);
        $_SESSION["user_email"] = $user_email;
        $_SESSION["user_password"] =  hash('sha256', $user_password);

        if (check_user_exists_in_db($_SESSION["user_email"], $_SESSION["user_password"])) {
            $_SESSION['validate_user_is_ok'] = 1;
            header('Location: index.php');
        }

    }

    ?>

    <div class="center_div">
        <form method="POST" action="">
        <div class="form-outline mb-4">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control">
        </div>
        <div class="form-outline mb-4">
            <label for="pass" class="form-label">Password</label>
            <input type="password" name="pass" id="pass" class="form-control">
        </div>
            <button type="submit" class="form-control btn btn-primary" name="from_submit">Log In</button>
        </form>
    </div>
</body>
</html>