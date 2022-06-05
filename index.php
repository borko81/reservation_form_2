<?php
  session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    </script>
  <script src=check_for_free.js></script>
    <title>Reservations form</title>
</head>
<body>
<div class="container">
    <h3>Форма за резервация</h3>
    <form action="">

    <!-- Checking for free room about date to income and going -->
        <div class="form-group">
            <label for="human_count">Брои гости</label>
            <select id="human_count" class="form-control" name='human_count'>
                <option value="2">Възрастни 2</option>
                <option value="3">Възрастни 3</option>
            </select>
        </div>

        <div class="form-group">
            <label for="income_date">Дата на пристигане</label>
            <input type="date" class="form-control" id="income_date" name='income_date'>
        </div>

        <div class="form-group">
            <label for="outcome_date">Дата на отпътуване</label>
            <input type="date" class="form-control" id="outcome_date" name='outcome_date'>
        </div>

        <!-- END -->

        <br />
        <!-- Show what system found  -->
        <div class="form-group free_rooms">
            <h5>Свободни помещение</h5>
 

                <?php
                  echo "<div class='free_in_grid_system' id='msg'></div>";
                ?>

            <!-- END  -->

            <br />
            <!-- Need person information -->
            <div class="person_info">
                <h5>Данни за госта</h5>
                <div class="form-group">
                    <label for="person_name">Име и Фамилия</label>
                    <input type="text" class="form-control" id="person_name">
                </div>

                <div class="form-group">
                    <label for="person_tel">Телефон</label>
                    <input type="text" class="form-control" id="person_tel">
                </div>

                <div class="form-group">
                    <label for="person_email">Email</label>
                    <input type="text" class="form-control" id="person_email">
                </div>

                <div class="form-group">
                    <label for="person_note">Забележка</label>
                    <textarea id="person_note" class="form-control"></textarea>
                </div>

            </div>
            <!-- END -->

        </div>

    </form>
</div>

<!----modal starts here--->
    <div id="myModal-borko" class="modal-borko">

      <!-- Modal content -->
      <div class="modal-content-borko">
        <span class="close">&times;</span>
        <p id="here_picture"></p>
      </div>

    </div>
<!--Modal ends here--->

<script type="text/javascript">
</script>
</body>
</html>
