<?php
    $DOMAIN_ = 'http://127.0.0.1';
    $HOST_PORT = 8080;
    $NEEDED_URL = "$DOMAIN_:$HOST_PORT/api/Bookings/FreeRooms?";
    $TOKEN = 'test1234';
    $URL_FOR_ADD_RESERV="$DOMAIN_:$HOST_PORT/api/Bookings?token=$TOKEN";
    $URL_FOR_CHECK = "$DOMAIN_:$HOST_PORT/api/Bookings/OccupiedRooms?token=$TOKEN";
    $HOW_DAY_TO_CHECK = 10;
?>