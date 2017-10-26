<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Lyrics Search Engine </title>

	<link rel="stylesheet" href="/resources/demos/style.css">
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<link rel="stylesheet" href="/resources/demos/style.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
  	<!-- SLIDER PHP + SCRIPT -->
  	<?php
	if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
		$min_time_period = substr($_POST['time_period'], 13, 4);
		$max_time_period = substr($_POST['time_period'], 20, 4);
		
	} else {
		$min_time_period = 1968;
		$max_time_period = 2017;
	}
	?>
	<script>
	var min_time_period = "<?php echo $min_time_period ?>";
	var max_time_period = "<?php echo $max_time_period ?>";
	  $( function() {
	    $( "#slider-range" ).slider({
	      range: true,
	      min: 1968,
	      max: 2017,
	      values: [min_time_period, max_time_period],
	      slide: function( event, ui ) {
	        $( "#time_period" ).val( "Time period: " + ui.values[ 0 ] + " - " + ui.values[ 1 ] );
	      }
	    });
	    $( "#time_period" ).val( "Time period: " + $( "#slider-range" ).slider( "values", 0 ) +
	      " - " + $( "#slider-range" ).slider( "values", 1 ) );
	  } );
	</script>

	<!-- REQUIRE + GENRE PROCESSING PREP. -->
	<?php
	require_once '../init.php';
	
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
</head>
<body>

<form method="post">
	<!-- HEADER WITH LYRICS SEARCH BAR -->
	<div id="header">
		<div id="lyric-search">
			<label for="lyrics">Lyrics Search Engine</label>
			<input type="text" id="lyrics" name="lyrics" value="<?php echo isset($_POST['lyrics']) ? $_POST['lyrics'] : '' ?>" autofocus>
			<div id="submit-button">
				<input type="submit" value="Search">
			</div>
		</div>
	</div>

	<!-- ADVANCED SEARCH WRAPPER -->
	<div id="advanced-search-wrapper">
		<div id="advanced-search-col">
			
			<!-- Genres checkboxes -->
			Genres<br>
			<div id="genres-wrapper">
				<div id="genre-col">
					<ul>
						<li>
							<input id="hiphop" type="checkbox" name="genres[]" value="hiphop"  checked />
							<label class='checkbox-label' for="hiphop">HipHop (<?php echo $hiphop_total;?>) </label>
						</li>
						<li>
						 	<input id="country" type="checkbox" name="genres[]" value="country"  checked />
							<label class='checkbox-label' for="hiphop">Country (<?php echo $hiphop_total;?>) </label>
						</li>
						<li>
						 	<input id="rock" type="checkbox" name="genres[]" value="rock"  checked />
							<label class='checkbox-label' for="rock">Rock (<?php echo $rock_total;?>) </label>
						</li>
						<li>
						 	<input id="pop" type="checkbox" name="genres[]" value="pop"  checked />
							<label class='checkbox-label' for="pop">Pop (<?php echo $pop_total;?>) </label>
						</li>
						<li>
						 	<input id="rb" type="checkbox" name="genres[]" value="rb"  checked />
							<label class='checkbox-label' for="rb">R&B (<?php echo $rb_total;?>) </label>
						</li>
					</ul>
				</div>
				<div id="genre-col">
					<ul>
						<li>
							<input id="folk" type="checkbox" name="genres[]" value="folk"  checked />
							<label class='checkbox-label' for="folk">Folk (<?php echo $folk_total;?>) </label>
						</li>
						<li>
						 	<input id="indie" type="checkbox" name="genres[]" value="indie"  checked />
							<label class='checkbox-label' for="indie">Country (<?php echo $indie_total;?>) </label>
						</li>
						<li>
						 	<input id="electronic" type="checkbox" name="genres[]" value="electronic"  checked />
							<label class='checkbox-label' for="electronic">Electronic (<?php echo $electronic_total;?>) </label>
						</li>
						<li>
						 	<input id="jazz" type="checkbox" name="genres[]" value="jazz"  checked />
							<label class='checkbox-label' for="jazz">Pop (<?php echo $jazz_total;?>) </label>
						</li>
						<li>
						 	<input id="other" type="checkbox" name="genres[]" value="other"  checked />
							<label class='checkbox-label' for="other">Other (<?php echo $other_total;?>) </label>
						</li>
					</ul>
				</div>
			</div>
			<!-- Time period range slider -->
  			<input type="text" id="time_period" name="time_period">
 			<div id="slider-range"></div>
		</div>

		<div id="advanced-search-col">
			<!-- Artist field -->
			<label for="artist">Artist</label>
			<input type="text" name="artist" value="<?php echo isset($_POST['artist']) ? $_POST['artist'] : '' ?>">

			<!-- Year field -->
			<label for="year">Year</label>
			<input type="text" name="year" value="<?php echo isset($_POST['year']) ? $_POST['year'] : '' ?>">

			<!-- Song field -->
			<label for="song">Song</label>
			<input type="text" name="song_title" value="<?php echo isset($_POST['song_title']) ? $_POST['song_title'] : '' ?>">
		</div>
	</div>

</form>

<!-- RESULTS -->
<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'action_page.php';
}
?>

</body>
</html>