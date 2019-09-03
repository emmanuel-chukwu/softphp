<?php

require "routers/index.php";

$router = new Router();

$router->addEndpointFiles();
$router->handle_request();

?>
