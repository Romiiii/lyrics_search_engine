
<?php

require "../init.php";

echo $_POST["artist"];

$params = [
    'index' => 'my-index',
    'type' => 'my-type',
    'body' => [
        'query' => [
            'match' => [
                'Artist' => $_POST["artist"]
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
	$song = $results['hits']['hits'][$i]['_source']['Song'];
	$artist = $results['hits']['hits'][$i]['_source']['Artist'];
	$year = $results['hits']['hits'][$i]['_source']['Year'];
    
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


