

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
?>