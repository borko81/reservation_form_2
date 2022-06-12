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


<div class="glob_container">
    <h3>Форма за резервация</h3>

    <form action="result.php" method='POST' name="total_form">

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
            <h5>Свободни помещения</h5>
 

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
                    <input type="text" class="form-control" id="person_name" name="person_name" required>
                </div>

                <div class="form-group">
                    <label for="person_tel">Телефон</label>
                    <input type="text" class="form-control" id="person_tel" name='person_tel' required>
                </div>

                <div class="form-group">
                    <label for="person_email">Email</label>
                    <input type="text" class="form-control" id="person_email" name='person_email' required>
                </div>

                <div class="form-group">
                    <label for="person_note">Забележка</label>
                    <textarea id="person_note" class="form-control" name='person_note'></textarea>
                </div>

                <br />
                <div class="form-group">
                    <input type="number" name="random_num" class="input_in_one_line" readonly value="<?php echo rand(); ?>">
                    <input type="number" name="human_number" placeholder="Въведете числото от ляво за проверка" class="input_in_one_line">
                </div>
                <br />
                <div class="form-group">
                    <input type="submit" value="Направи резерация" class="btn btn-primary my-text-transform form-control" name="submit_me">
                </div>
 
            </div>
            <!-- END -->

        </div>

    </form>
    <?php

        echo "<div class='load_center'>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
            echo "<div class='wave'></div>";
        echo "</div>";

    ?>

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

    $('form').submit(function() {
        let income = document.getElementById("income_date").value
        let people_name = document.getElementById("person_name").value

        if (income == "") {
            alert("Въведете дата на пристигане")
            return false;
        }

        if (people_name == "") {
            alert("Въведете име")
            return false;
        }
        
        if (parseInt($('input[name="random_num"]').val()) == parseInt($('input[name="human_number"]').val())) {
            return true;
        }
        else{
            alert('Въведете кода за проверка.');
            return false;
        }
    });


    let income_input = document.getElementById("income_date");
    let outcome_input = document.getElementById("outcome_date");
    
    income_input.addEventListener("click", function () {
        income_input.showPicker()
    });

    outcome_input.addEventListener("click", function () {
        outcome_input.showPicker()
    });

    var $wave = $(".wave").hide();
    var $loader = $(".load_center").hide();

    $(document)
    .ajaxStart(function () {
        $loader.show();
        $wave.show();
    })
    .ajaxStop(function () {
        $wave.hide();
        $loader.hide();
    });

</script>
</body>
</html>
