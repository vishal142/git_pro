<?php 
require("vendor/autoload.php");
$swagger = \Swagger\scan('/path/to/project');
echo $swagger;
?>