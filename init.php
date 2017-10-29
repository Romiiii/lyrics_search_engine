<?php
# This file needs to be placed one folder down from the rest

# This path needs to be changed to point to your own local autoload.php file
require 'C:\Users\rob\vendor\autoload.php';


use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();


?>