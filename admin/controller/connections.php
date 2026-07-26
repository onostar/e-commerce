<?php
    $connectdb = new PDO("mysql:host=localhost; dbname=realcare", "onostarmedia", "yMcmb@her0123!");
    $connectdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $connectdb->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ)

?>