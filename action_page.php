<?php

require "../init.php";

echo "<br/>You have searched for:<br/>";
echo "Artist: ", $_POST["artist"] , "<br/>";
echo "Song Title: ", $_POST["song_title"], "<br/>";
echo "Year: ", $_POST["year"], "<br/><br/>";



$params = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'body' => [
        'query' => [
            'match' => [
                'artist' => $_POST["artist"],
				'song' => $_POST["song_title"],
				'year' => $_POST["year"]
            ]
        ]
    ]
];

$results = $client->search($params);

$number_of_results = $results['hits']['total'];

if ($number_of_results > 10) {
    $x = 10;
} else {
    $x = $number_of_results;
}

echo "<br/>Total number of results: ", $number_of_results, "<br/>";

for ($i = 0; $i < $x; $i++) {
	//print_r($results['hits']['hits'][$i]['_source']['song']);
	$song = $results['hits']['hits'][$i]['_source']['song'];
	$artist = $results['hits']['hits'][$i]['_source']['artist'];
	$year = $results['hits']['hits'][$i]['_source']['year'];
    
    ?>
    <p>
    Song is <?php echo $song ?>
    <br>
    Artist  is <?php echo $artist ?>
    <br>
    Year is <?php echo $year ?>
    </p>
    <?php
}


?>


<html>
<body>




</body>

</html>


