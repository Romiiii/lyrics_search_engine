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
<head>
	<link rel="stylesheet" type="text/css" href="style2.css">
</head>

<body>
<div id="songtext-wrapper">
	<a href="index2.php"> << back to result page</a>

	<p>
	<br><?php echo $song; ?><br>
	By: <?php echo $artist; ?><br>
	Year: <?php echo $year; ?> <br>
	Genre:  <?php echo $genre; ?><br><br>

	Songtext: <br><br>
	<?php echo nl2br($lyrics); ?>
	</p>
</div>



</body>

</html>

