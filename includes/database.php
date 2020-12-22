<?php

//Database Config
$db_host = "localhost";
$db_user = "root";
$db_password = "";
$db_name = "srs";

try
{
    $conn = new PDO("mysql:host=$db_host;dbname=$db_name",$db_user,$db_password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
    echo "Connection failed: " . $e->getMessage();
}