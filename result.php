<?php
session_start();
if (!isset($_SESSION['validate_user_is_ok'])) {
  header('Location: user_validate.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form_style.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    </script>
    <title>Reservation</title>
</head>
<body>
    <div class="content">
        <h3>Въведени данни</h3>
        
    <?php

        //var_dump($_POST);

        function clear_input($input) {
            return trim(htmlspecialchars($input));
        }

        function httpPost($url, $data) {
          $curl = curl_init($url);
          curl_setopt($curl, CURLOPT_POST, true);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
          $headers = array(
              "Accept: application/json",
              "Content-Type: application/json",
          );
          curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
          curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
          $response = curl_exec($curl);
          curl_close($curl);
          return $response;
      }

        if (
            isset($_POST['person_name']) &&
            isset($_POST['person_tel']) &&
            isset($_POST['person_email']) && filter_var($_POST['person_email'], FILTER_VALIDATE_EMAIL) &&
            isset($_POST['person_note']) &&
            isset($_POST['human_count']) &&
            isset($_POST['income_date']) &&
            isset($_POST['outcome_date']) &&
            isset($_POST['room_choice_radio'])
        ) {
            $name = clear_input($_POST['person_name']);
            $tel = clear_input($_POST['person_tel']);
            $email = clear_input($_POST['person_email']);
            $note = clear_input($_POST['person_note']);
            $human_counts = clear_input($_POST['human_count']);
            $income_date = clear_input($_POST['income_date']);
            $outcome_date = clear_input($_POST['outcome_date']);
            $room_choice_radio = clear_input($_POST['room_choice_radio']);
            $room_id = explode(":", $room_choice_radio)[0];
            $room_tip = explode(":", $room_choice_radio)[1];


            $_SESSION['name'] = $name;
            $_SESSION['tel'] = $tel;
            $_SESSION['email'] = $email;
            $_SESSION['note'] = $note;
            $_SESSION['human_counts'] = $human_counts;
            $_SESSION['income_date'] = $income_date;
            $_SESSION['outcome_date'] = $outcome_date;
            $_SESSION['room_tip'] = $room_tip;
            $_SESSION['room_id'] = $room_id;

            echo "Име $name, телефон: $tel, email: $email<br />";
            echo "Брои на гостите: $human_counts<br />";
            echo "Избрани дати. Пристига: $income_date, отпътува: $outcome_date<br />";
            echo "Избран тип помещение: $room_tip<br />";

            if (strlen($note) > 0) {
                echo "Оставен коментар: $note";
            }
            echo "<p class='common_information' data-toggle='modal' data-target='#myModal'>Общи условия</p>";
            echo "<form method='POST' action='payment.php'>";
            echo "<input type='submit' value='Направи резервация' class='form-control'>";
            echo "</form>";
        } else {
          echo "<input type='button' class='btn btn-success' value='Некоректни данни опитаите отново или се обадете на рецепция' onClick='window.history.back()' >";
        }

    ?>

      <!-- Modalen prozorec s obshtite uslowiq -->
      <div class="modal fade" id="myModal" role="dialog">
        <div class="modal-dialog">
        
          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Общи условия UnrealSoft LTD</h4>
            </div>
            <div class="modal-body">
              <p>Полето "Забележки" в бланката за резервация няма задължаващ характер за , като всички желания на клиента, попълнени във въпросното поле, ще бъдат удовлетворени при възможност.</p>
              <p>Цените във формата са в лева (BGN), с включен 9% ДДС, застраховка и туристически данък в размер 2,02лв на човек на възрастен. Общата дължима от клиента сума по резервацията се калкулира автоматично, в зависимост от броя дни, броя възрастни и деца, и от актуалната ценова оферта за съответния период.</p>
              <strong>ЛИЧНИ ДАННИ</strong>

              <p>Вашите лични данни са защитени съгласно законодателството на Република България и се използват единствено от резервационния отдел на хотела.
              Вашите лични данни няма да бъдат предоставяни на трети лица.</p>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>
          
        </div>
      </div>

</div>
</body>
</html>
