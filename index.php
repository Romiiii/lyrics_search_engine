<!DOCTYPE html>
<html>
<head>
	<?php
	require '../init.php'
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
	<input type="text" name="lyrics">
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

		hip-hop: <input type="checkbox" name="genres[]" value="hiphop"  /><br />

		country: <input type="checkbox" name="genres[]" value="country"  /><br /> 

		rock: <input type="checkbox" name="genres[]" value="rock"  /><br /> 

		pop: <input type="checkbox" name="genres[]" value="pop"  /><br />

		r&b: <input type="checkbox" name="genres[]" value="rb"  /><br />

		folk: <input type="checkbox" name="genres[]" value="folk"  /><br />

		indie: <input type="checkbox" name="genres[]" value="indie"  /><br />

		electronic: <input type="checkbox" name="genres[]" value="electronic"  /><br />

		jazz: <input type="checkbox" name="genres[]" value="jazz"  /><br />

		other: <input type="checkbox" name="genres[]" value="other"  /><br />

	<br><br>
	<p>
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