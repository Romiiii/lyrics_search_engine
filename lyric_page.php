<?php

require_once "../init.php";

$id = $_GET['id'];




$params = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'id' => $id
];

$results = $client->get($params);



$song = $results['_source']['song'];
$artist = $results['_source']['artist'];
$year = $results['_source']['year'];
$genre = $results['_source']['genre'];
$lyrics = $results['_source']['lyrics'];

?>

<html>
<body>
<p>

</p>

<?php echo $song; ?>
<br>
By <?php echo $artist; ?>
<br>
Year: <?php echo $year; ?> <br>
Genre:  <?php echo $genre; ?>


<p>
 <?php echo $lyrics; ?>


</p>



</body>

</html>

