<!DOCTYPE html>
<html>
<head>
	<?php
	require '../init.php';
	
$genres = ['rock', 'hiphop', 'country', 'pop', 'metal', 'other', 'jazz', 'electronic', 'indie', 'folk', 'rb'];	
foreach($genres as $genre) {
	${$genre . "_params"} = [
							'index' => 'lyrics',
							'type' => 'lyric',
							'body' => [
								'query' => [
									'match' => [
										'genre' => $genre
									]
								]
							]
						];
	
	${$genre. "_query"} = $client->search(${$genre . "_params"});
	${$genre. "_total"} = ${$genre. "_query"}['hits']['total'];

}
	
	
	?>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title> Lyrics Search Engine </title>

	<link rel="stylesheet" href="/resources/demos/style.css">
	<link rel="stylesheet" type="text/css" href="style.css">

	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
	<!-- Script for slider -->
	<script>
	$( function() {
	    $( "#slider-range" ).slider({
	      range: true,
	      min: 1900,
	      max: 2017,
	      values: [ 1900, 2017 ],
	      slide: function( event, ui ) {
	        $( "#amount" ).val(ui.values[ 0 ] + " - " + ui.values[ 1 ]);
	      }
	    });
	    $( "#amount" ).val($( "#slider-range" ).slider( "values", 0 ) +
	      " - " + $( "#slider-range" ).slider( "values", 1 ) );
	  } );
	</script>

</head>

<body>

<form method="post">
	Lyrics:<br>
	<input type="text" name="lyrics" autofocus>
	<br>

	Artist:<br>
	<input type="text" name="artist">
	<br>

	Year:<br>
	<input type="text" name="year">
	<br>

	Song title:<br>
	<input type="text" name="song_title">
	<br>
	<br>
	<input type="submit"><br><br>
	</p> Advanced search:</p>

		Hip-Hop: <input type="checkbox" name="genres[]" value="hiphop"  checked /> (<?php echo $hiphop_total;?>)<br />

		Country: <input type="checkbox" name="genres[]" value="country" checked  />(<?php echo $country_total;?>)<br /> 

		Rock: <input type="checkbox" name="genres[]" value="rock" checked  /> (<?php echo $rock_total;?>)<br />

		Pop: <input type="checkbox" name="genres[]" value="pop" checked  />(<?php echo $pop_total;?>)<br />

		R&B: <input type="checkbox" name="genres[]" value="rb" checked  />(<?php echo $rb_total;?>)<br />

		Folk: <input type="checkbox" name="genres[]" value="folk" checked  />(<?php echo $folk_total;?>)<br />

		Indie: <input type="checkbox" name="genres[]" value="indie" checked  />(<?php echo $indie_total;?>)<br />

		Electronic: <input type="checkbox" name="genres[]" value="electronic" checked  />(<?php echo $electronic_total;?>)<br />

		Jazz: <input type="checkbox" name="genres[]" value="jazz" checked  />(<?php echo $jazz_total;?>)<br />

		Other: <input type="checkbox" name="genres[]" value="other" checked  />(<?php echo $other_total;?>)<br />

	<br><br>
	<p>
		<!-- Our oldest song is from 1968, so maybe start the slider from there -->
		<label for="amount">Time range</label>
		<input type="text" id="amount" name="time_period" readonly style="border:0;">
	</p>
</form>

<div id="slider-range">
</div>


<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'action_page.php';
}
?>

</body>
</html>