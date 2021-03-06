<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
    <link rel='stylesheet' href='bootstrap.css'>
    <title>Document</title>
    <style>
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        
        /* Modal Content/Box */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
        }
        
        /* The Close Button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }
        
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php include 'const.php';?> 

    <?php
    
        // var_dump($_POST);

        function data_is_not_null($variable) {
            if ((isset($variable)) && (!empty($variable))) {
                return true;
            } 
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
            data_is_not_null($_SESSION['name']) &&
            data_is_not_null($_SESSION['tel']) &&
            data_is_not_null($_SESSION['email']) &&
            data_is_not_null($_SESSION['human_counts']) &&
            data_is_not_null($_SESSION['income_date']) &&
            data_is_not_null($_SESSION['outcome_date']) &&
            data_is_not_null($_SESSION['room_id'])
        ) {

            $splitted_hidden_date = explode(":", htmlspecialchars(trim($_SESSION['human_counts'])));
            $adult = $splitted_hidden_date[0];

            $children = array_slice($splitted_hidden_date, 1);

            $child_count = [];

            if(sizeof($children) > 0) {
                for ($i=0; $i<sizeof($children); $i++) {
                    array_push($child_count, $children[$i]);
                }
            }

            $arrival = $_SESSION['income_date'];
            $departure = $_SESSION['outcome_date'];
            $guestName = $_SESSION['name'];
            $phoneNumber = $_SESSION['tel'];
            $emailAddress = $_SESSION['email'];
            $note = $_SESSION['note'];
            $room_id = $_SESSION['room_id'];
            $room_tip = $_SESSION['room_tip'];
            $child_count_for_potv = sizeof($child_count);

            $data = array(
                "arrival"=> $arrival,
                "departure"=> $departure,
                "guestName"=> $guestName,
                "phoneNumber"=> $phoneNumber,
                "emailAddress"=> $emailAddress,
                "note"=> substr(preg_replace("/\"/","'",htmlspecialchars(trim($note))), 0, 150),
                "paymentType"=> 0,
                "referenceNumber"=> "string",
                "rooms"=> [
                
                    array(
                        "roomTypeId"=> $room_id,
                        "adults"=> $adult,
                        "boardTypeId"=> null,
                        "childrenAge"=> $child_count
                    )
                ]
                );

                $json_data = json_encode($data);
                $response_data = httpPost($URL_FOR_ADD_RESERV, $json_data);
                $php_readable_data = json_decode($response_data, true);

                if (isset($php_readable_data['bookingId']) && (!empty($php_readable_data['bookingId']))) {
                    $RES_ID = $php_readable_data['bookingId'];
                    if ($_SESSION['reload_page'] == 'borko') {
                        header("Location: index.php"); 
                    }
                    $_SESSION["reload_page"] = "borko";

                    echo "<div id='myModal' class='modal'>";
    
                    echo    "<div class='modal-content'>";
                    echo        "<span class='close'>&times;</span>";
                    echo        "<p>?????????????? ?????????????????? ?????????????????? ?? ?????????? :  $RES_ID ?????????????????? ???????????????????????? ???? ?????? ????????????????</p>";
                    echo        "?????? $guestName , ??????????????: $phoneNumber, email: $emailAddress<br />";
                    echo        "???????? ???? ??????????????: ??????????????????: $adult, ????????: $child_count_for_potv<br />";
                    echo        "?????????????? ????????. ????????????????: $arrival, ????????????????: $departure<br />";
                    echo        "???????????? ?????? ??????????????????: $room_tip<br />";
                    echo        "<input  type='button' value='Print this Page' onclick='window.print();'>";
                    echo        "<button onclick=\"location.href='index.php'\">Back to Home</button>";
                    echo     "</div>";
    
                    echo "</div>";
                    echo "<script>let modal=document.getElementById('myModal');modal.style.display = 'block';</script>";
    
                } else {
                    echo "???????????????? ????????????, ???????? ???????????????? ?????? ?????? ???? ?????????????? ???? ????????????????.<br />";
                    echo $php_readable_data['note'][0] ? $php_readable_data['note'][0] : '';
                }

                // var_dump($json_data);
        } else {
            echo "???????????????? ????????????, ???????? ???????????????? ?????? ?????? ???? ?????????????? ???? ????????????????.<br />";
            echo "<button class='btn btn-primary form-control go_back_button' id='go_back_button'>?????????????? ???? ?????????????? ?? ?????????????????? ??????????????.</button>";
        }

    ?>

<script>

var span = document.getElementsByClassName("close")[0];

span.onclick = function() {
  modal.style.display = "none";
  window.location.assign("index.php");
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
  if (event.target == modal) {
    modal.style.display = "none";
    window.location.assign("index.php");
  }
}

function go_back() {
    window.history.back();
}

</script>
</body>
</html>