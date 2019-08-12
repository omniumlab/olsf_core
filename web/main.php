<?php

$enviroment = isset($_SERVER["OLSF_ENVIROMENT"]) ? $_SERVER["OLSF_ENVIROMENT"] : "prod";

$files = glob("../env.*");
//$files = glob("../private/env.*");

if (count($files) > 0) {
    if (count($files) > 1) {
        header("Internal error", true, 500);
        die("<h1>There are more than one ennv.xyz file</h1>");
    }

    $file = basename($files[0]);

    $enviroment = substr($file, "4");
}

if ($enviroment === "prod")
    $appFile = "app.php";
else
    $appFile = "app_" . $enviroment . ".php";

if (!file_exists($appFile)) {
    header("Internal error", true, 500);
    die("<h1>File " . $appFile . " does not exists</h1>");
}

include($appFile);
