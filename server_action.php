<?php
    session_start();
?>

<?php include 'const.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CheckForFree</title>
</head>
<body>
    <?php
        $income = trim(isset($_POST['income']) ? htmlspecialchars($_POST['income']) : '');
        $outcome = trim(isset($_POST['outcome']) ? htmlspecialchars($_POST['outcome']) : '');
        $people = isset($_POST['people']) ? explode(":", trim($_POST['people'])) : '';
        $people_count='';
        $SITE_URL = $NEEDED_URL;


        if(!empty($income) && !empty($outcome) && !empty($people)) {

            $connection = mysqli_connect('localhost', 'root', '', 'mysql') or die("Database connection not establish");
            $result = mysqli_query($connection, "select message FROM stop_period where '$income' between first_date and second_date or '$outcome' between first_date and second_date") or die ("Error acquire");

            $rowCount = mysqli_num_rows($result);

            if ($rowCount) {
                foreach($result as $mess) {
                    echo $mess['message'];
                }
                return;
            }

            $SITE_URL .= 'Arrival=' . $income;
            $SITE_URL .= '&Departure=' . $outcome;
            
           
            if (sizeof($people) == 1) {
                $SITE_URL .= '&Adults=' . $people[0];
            } else {
                $SITE_URL .= '&Adults=' . $people[0];
                for($i=1; $i<sizeof($people); $i++) {
                    $SITE_URL .= '&ChildrenAge=' . $people[$i];
                }
            }

            $SITE_URL .= "&token=$TOKEN";

            // echo $SITE_URL;
            
            // Send data to API
            $cURLConnection = curl_init();
                curl_setopt($cURLConnection, CURLOPT_URL, $SITE_URL);
                curl_setopt($cURLConnection, CURLOPT_RETURNTRANSFER, true);
                $result = curl_exec($cURLConnection);
                curl_close($cURLConnection);
                $result_php = json_decode($result, true);

                
                if (!array_key_exists('roomPrices', $result_php)) {
                    echo "???????????????? ???????????? ???????????????? ?? ?????????? ????????...<br />";
                } elseif (array_key_exists('roomPrices', $result_php) && sizeof($result_php['roomPrices']) == 0){
                    echo "???????? ???????????????? ?????????????????? ???? ?????????????????? ????????????.";
                } else {
                    for ($i=0; $i<sizeof($result_php['roomPrices']); $i++) {
                        $price = round($result_php['roomPrices'][$i]["price"], 2);
                        $room_tipe = $result_php['roomPrices'][$i]["roomType"]["name"];
                        $room_id =  $result_php['roomPrices'][$i]["roomType"]["id"];
                        $name_and_id = $room_id . ":" . $room_tipe;
    
                        echo "<div class='card' style='width: 18rem;'>";
                        echo     "<div class='card-body'>";
                        echo         "<h5 class='card-title'>$room_tipe</h5>";
                        echo         "<h6 class='card-subtitle mb-2 text-muted'>????????  $price ????</h6>";
                        echo         "<a href='#' class='card-link' id=$room_id onclick='showModal(this.id)'>??????????????</a>&nbsp;&nbsp;&nbsp;??????????:&nbsp;<input type='radio' name='room_choice_radio' value=$name_and_id' onclick='when_radio_is_clicked();'>";
                        echo     "</div>";
                        echo "</div>";
                    }
                }
        }
    ?>
<script>
    if ( window.history.replaceState ) {
        window.history.replaceState( null, null, window.location.href );
    }
</script>
</body>
</html>