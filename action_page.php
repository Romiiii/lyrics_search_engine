
<?php

require "init.php";


echo "action_page has opened";

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

for ($i = 0; $i < 10; $i++) {
	//print_r($results['hits']['hits'][$i]['_source']['Song']);
	$song = $results['hits']['hits'][$i]['_source']['Song'];
	$artist = $results['hits']['hits'][$i]['_source']['Artist'];
	$year = $results['hits']['hits'][$i]['_source']['Year'];
	
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


