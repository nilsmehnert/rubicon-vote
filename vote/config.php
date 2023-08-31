<?php

session_start();

error_reporting(E_ALL & ~E_NOTICE);

$config["db"]["host"] = "xxxxxx";
$config["db"]["user"] = "xxxxxx";
$config["db"]["password"] = "xxxxxx!";
$config["db"]["datenbank"] = "xxxxxx";

$db = mysqli_connect($config["db"]["host"], $config["db"]["user"], $config["db"]["password"], $config["db"]["datenbank"]);

$config["session"]["session_id"] = session_id();

$config["admin"]["password"] = "xxxxxx";
