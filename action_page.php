<?php

require_once "../init.php";

if(!empty($_POST['genres'])) {
    $genres = $_POST['genres'];
} else {
    $genres = ['rock', 'hiphop', 'country', 'pop', 'metal', 'other', 'jazz', 'electronic', 'indie', 'folk', 'rb'];
}

echo "start year:", substr($_POST['time_period'], 0, 4), "<br/>";
echo "end year: ", substr($_POST['time_period'], 7, 11), "<br/>";

$start_time = substr($_POST['time_period'], 0, 4);
$end_time = substr($_POST['time_period'], 7, 11);


$params = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'body' => [
        'query' => [
            'bool' => [
                'filter' => [ 
                    ['terms' => [ 'genre' => $genres ]],
					['range' => [
						'year' => [
							'gte' => $start_time,
							'lte' => $end_time,
						]
					]]
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
	$id = $results['hits']['hits'][$i]['_id']
    
    ?>
    <p>
    <a href="lyric_page.php?id=<?php echo $id; ?>"><b>Song is</b> <?php echo $song; ?>
    <br>
    <b>Artist</b>  is <?php echo $artist; ?>
    <br>
    <b>Year</b> is <?php echo $year; ?>
	</a>
    </p>
    <?php
}


?>


<html>
<body>




</body>

</html>

