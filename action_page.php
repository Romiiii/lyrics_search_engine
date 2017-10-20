<?php
/*
{'Pop': 40456, 'Hip-Hop': 24847, 'Rock': 109119, 'Metal': 23720, 
'Other': 5188, 'Country': 14386, 'Jazz': 7971, 'Electronic': 7961, 
'Folk': 2243, 'R&B': 3400, 'Indie': 3149}
*/

require "../init.php";

if(!empty($_POST['genres'])) {
    $genres = $_POST['genres'];
} else {
    $genres = ['rock', 'hip-hop', 'country', 'pop', 'metal', 'other', 'jazz', 'electronic', 'indie', 'folk', 'r&b'];
}

$params = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'body' => [
        'query' => [
            'bool' => [
                'filter' => [ 
                    'terms' => [ 'genre' => $genres ]
                ],
                'should' => [
                    [ 'match' => [ 'artist' => $_POST["artist"] ] ],
                    [ 'match' => [ 'year' => $_POST["year"] ] ],
                    [ 'match' => [ 'song' => $_POST["song_title"] ] ],
                    [ 'match_phrase' => ['lyrics' => $_POST['lyrics'] ] ],
                ]
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

echo $number_of_results;

for ($i = 0; $i < $x; $i++) {
	$song = $results['hits']['hits'][$i]['_source']['song'];
	$artist = $results['hits']['hits'][$i]['_source']['artist'];
	$year = $results['hits']['hits'][$i]['_source']['year'];
    
    ?>
    <p>
    <b>Song is</b> <?php echo $song ?>
    <br>
    <b>Artist</b>  is <?php echo $artist ?>
    <br>
    <b>Year</b> is <?php echo $year ?>
    </p>
    <?php
}


?>


<html>
<body>




</body>

</html>

