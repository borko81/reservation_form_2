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
                    echo "Възникна грешка опитаите с други дати...<br />";
                } elseif (array_key_exists('roomPrices', $result_php) && sizeof($result_php['roomPrices']) == 0){
                    echo "Няма свободни помещения за зададения период.";
                } else {
                    for ($i=0; $i<sizeof($result_php['roomPrices']); $i++) {
                        $price = round($result_php['roomPrices'][$i]["price"], 2);
                        $room_tipe = $result_php['roomPrices'][$i]["roomType"]["name"];
                        $room_id =  $result_php['roomPrices'][$i]["roomType"]["id"];
    
                        echo "<div class='card' style='width: 18rem;'>";
                        echo     "<div class='card-body'>";
                        echo         "<h5 class='card-title'>$room_tipe</h5>";
                        echo         "<h6 class='card-subtitle mb-2 text-muted'>Сума  $price лв</h6>";
                        echo         "<a href='#' class='card-link' id=$room_id onclick='showModal(this.id)'>Галерия</a>&nbsp;&nbsp;&nbsp;Избор:&nbsp;<input type='radio' name='room_choice_radio' value=$room_id' onclick='when_radio_is_clicked();'>";
                        echo     "</div>";
                        echo "</div>";
                    }
                }
        }
    ?>
</body>
</html>