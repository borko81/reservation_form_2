<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="form_style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>return_room_occupacy</title>
    <style>
        table, td, th {
            border: 1px solid black;
            border-collapse: collapse;
        }
        td, th {
            width: 90px !important;
            height: 50px !important;
        }
        .free_room {
            background: lightgreen;
        }
        .occupaed_room {
            background: ##dc143c;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
    <?php
        include 'const.php';
        // Get data for room id and name/ TODO: need total rooms by type to remove something here!!!!!!!!


        // $URL_FOR_CHECK = 'http://127.0.0.1:8080/api/configuration/RoomTypes?token=test1234';
        // $curl = curl_init();
        // curl_setopt($curl, CURLOPT_URL, $URL_FOR_CHECK);
        // curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_HEADER, false);

        // $data = curl_exec($curl);
        // $data = json_decode($data);
        
        // curl_close($curl);


        // Get data for occupaed room by period
        date_default_timezone_set('Europe/Sofia');
        $datetime = new DateTime();
        $array_assoc_search_for_free = array(
            3=>[2, 'Апартамент Superior'],
            4=>[1, 'Апартамент ВИП']
        );


        $URL_FOR_CHECK = $URL_FOR_CHECK;
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $URL_FOR_CHECK);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);

        $data = curl_exec($curl);
        $data = json_decode($data);
        
        curl_close($curl);

        
        echo "<table>";
        echo "<tr>";
        echo "<th>Дати</th>";
        for($i=0;$i<=$HOW_DAY_TO_CHECK;$i++) {
            $tomorow = date('Y-m-d', strtotime("now + " . $i ."day"));
            echo "<th>$tomorow</th>";
        }
        echo "</tr>";
        
        foreach($array_assoc_search_for_free as $room=>$room_value) {
            echo "<tr>";
            echo "<td>$room_value[1]</td>";

            for($day=0;$day<=$HOW_DAY_TO_CHECK;$day++) {
                $day_to_check = date('Y-m-d', strtotime("now + " . $day ."day"));
                $return_in_table = "<td class='free_room'></td>";

                for($i=0;$i<sizeof($data);$i++) {
                    if(
                        ($data[$i]->roomTypeId == $room) &&
                        (explode('T', $data[$i]->date)[0] == $day_to_check) &&
                        ($data[$i]->count - $array_assoc_search_for_free[$room][0]) == 0
                    ) {
                        $return_in_table = "<td class='occupaed_room'>X</td>";
                    }
                }

                echo $return_in_table;
            }

            echo "</tr>";
        }


        echo "</table>";
    ?>
    </div>
</body>
</html>