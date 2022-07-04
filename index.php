<?php
  session_start();
  $_SESSION["reload_page"] = '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous">
    <script src="js/jquery-ui.js"></script>
    </script>
  <script src=check_for_free.js></script>
    <title>Reservations form</title>
</head>
<body>


<div class="glob_container">
        <!-- <ul>
            <li><a href="return_room_occupacy.php">Проверка за свободни помещения</a></li>
        </ul> -->

    <div class="author_logo">
        <h3>Форма за резервация</h3>
        <span class="center_span"><a href="return_room_occupacy.php" class="link-secondary">Може да проверите заетостта. Или изберете конкретни дати.</a></span>
    </div>

    <form action="result.php" method='POST' name="total_form">

    <!-- Checking for free room about date to income and going -->
        <div class="form-group">
            <label for="human_count">Брои гости</label>
            <select id="human_count" class="form-control" name='human_count'>
                <option value="2">Възрастни 2</option>
                <option value="3">Възрастни 3</option>
                <option value="3:6">Възрастни 2 дете 1 до 6г</option>
                <option value="3:12">Възрастни 2 дете 1 до 12г</option>
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
            <!-- <h5>Свободни помещения</h5> -->
 

                <?php
                    echo "<h5>Свободни помещения</h5>";
                    echo "<div class='free_in_grid_system' id='msg'></div>";
                ?>

            <!-- END  -->

            <br />
            <!-- Need person information -->
            <div class="person_info">
                <!-- <h5>Данни за госта</h5> -->
                <div class="form-group">
                    <label for="person_name"></label>
                    <i class="fa fa-user"></i>
                    <input type="text" class="form-control left_padding" id="person_name" name="person_name" required placeholder='Име и Фамилия'>
                </div>

                <div class="form-group">
                    <label for="person_tel"></label>
                    <i class="fa fa-phone"></i>
                    <input type="text" class="form-control left_padding" id="person_tel" name='person_tel' required placeholder="Телефон">
                </div>

                <div class="form-group">
                    <label for="person_email"></label>
                    <i class="fa fa-envelope"></i>
                    <input type="text" class="form-control left_padding" id="person_email" name='person_email' required placeholder='Email'>
                </div>

                <div class="form-group">
                    <label for="person_note"></label>
                    <i class="fa fa-sticky-note-o"></i>
                    <textarea id="person_note" class="form-control left_padding" name='person_note' placeholder='Забележка'></textarea>
                </div>

                <br />
                <div class="form-group">
                    <input type="number" name="random_num" class="input_in_one_line" readonly value="<?php echo rand(); ?>">
                    <input type="number" name="human_number" placeholder="Въведете числото от ляво за проверка" class="input_in_one_line">
                </div>
                <br />
                <div class="form-group">
                    <input type="submit" value="напред" class="btn btn-primary my-text-transform form-control" name="submit_me">
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

    var date = new Date();
    var today = new Date();
    var tommorow = new Date();

    var dd = today.getDate();
    var tommorow_day = dd + 1;
    var mm = today.getMonth()+1;
    var yyyy = today.getFullYear();
    if(dd<10){
    dd='0'+dd
    } 
    if(mm<10){
    mm='0'+mm
    } 

    today = yyyy+'-'+mm+'-'+dd;
    tommorow = yyyy+'-'+mm+'-'+tommorow_day;

    document.getElementById('income_date').valueAsDate = date;
    document.getElementById("income_date").setAttribute("min", today);

    document.getElementById("outcome_date").setAttribute("min", tommorow);

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
