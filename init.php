<<<<<<< HEAD


<?php

require '/Applications/XAMPP/xamppfiles/htdocs/vendor/autoload.php';

use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

echo "Here there should be python:";

echo "";
$python = `python /lyrics_search_engine/read_lyrics.py`;
echo $python;

echo "hey";
echo "";


echo "";


echo "End of init";

echo "";
=======


<?php

require 'C:\Users\rob\vendor\autoload.php';


use Elasticsearch\ClientBuilder;

$client = ClientBuilder::create()->build();

echo "Here there should be python:";


echo "";


echo "";
$python = `python read_lyrics.py`;
echo $python;


echo "hey";
echo "";


echo "";


echo "End of init";

echo "";
>>>>>>> 4643bf24a68dbfe667b2fce440e65300b33ff223
?>