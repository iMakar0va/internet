<?php
$conn = pg_connect("host = localhost port = 5432 user = postgres dbname = internet password = 123");
if (!$conn)
    die(pg_last_error());
