<?php
// Start the session
session_start();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Lyrics Search Engine </title>

	<link rel="stylesheet" href="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.css">
    <script src="http://cdn.jsdelivr.net/chartist.js/latest/chartist.min.js"></script>
	
	<link rel="stylesheet" type="text/css" href="style2.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">

	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
	
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

	
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
	
/*	
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (isset($_SESSION['page'])) {
		echo "hey in session page";
		$_SESSION['page'] = -1;
	}
}
*/	
	$genres = ['rock', 'hiphop', 'country', 'pop', 'metal', 'other', 'jazz', 'electronic', 'indie', 'folk', 'rb'];	
	
	foreach($genres as $genre) {
		${$genre . "_params"} = [
								'index' => 'lyrics_new',
								'type' => 'lyric_new',
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

<form id="lyrics_form" method="post">
	<!-- HIDDEN FORM ELEMENT FOR PAGINATION -->
	<input type="hidden" name="send" value="hey" />

	<!-- HEADER WITH LYRICS SEARCH BAR -->
	<div id="header">
		<div id="lyric-search">
			<label for="lyrics">Lyrics Search Engine</label>
			<input type="text" id="lyrics" name="lyrics" value="<?php echo isset($_POST['lyrics']) ? $_POST['lyrics'] : '' ?>" autofocus>
			<div id="submit-button">
				<input type="submit" value="Search">
			</div>
			<div id="guess-genre-link">
				<a id="guess-genre-link" href="guess_genre.php"><br><u> >> Or, go to the lyric genre classifier!</u></a>
			</div>
		</div>
	</div>

		<!-- ADVANCED SEARCH WRAPPER -->
		<div id="advanced-search-wrapper">

			<div id="advanced-search-col-left">
				
				<!-- Genres checkboxes -->
				Genres<br>
				<div id="genres-wrapper">
					<div id="genre-col">
						<ul>
							<li>
								<input id="hiphop" type="checkbox" name="genres[]" value="hiphop"   <?php if(isset($_POST['genres'])) { if(in_array("hiphop", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="hiphop">HipHop (<?php echo $hiphop_total;?>) </label>
							</li>
							<li>
							 	<input id="country" type="checkbox" name="genres[]" value="country"  <?php if(isset($_POST['genres'])) { if(in_array("country", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="country">Country (<?php echo $country_total;?>) </label>
							</li>
							<li>
							 	<input id="rock" type="checkbox" name="genres[]" value="rock"  <?php if(isset($_POST['genres'])) { if(in_array("rock", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="rock">Rock (<?php echo $rock_total;?>) </label>
							</li>
							<li>
							 	<input id="pop" type="checkbox" name="genres[]" value="pop"  <?php if(isset($_POST['genres'])) { if(in_array("pop", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="pop">Pop (<?php echo $pop_total;?>) </label>
							</li>
							<li>
							 	<input id="rb" type="checkbox" name="genres[]" value="rb"  <?php if(isset($_POST['genres'])) { if(in_array("rb", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="rb">R&B (<?php echo $rb_total;?>) </label>
							</li>
						</ul>
					</div>
					<div id="genre-col">
						<ul>
							<li>
								<input id="folk" type="checkbox" name="genres[]" value="folk"  <?php if(isset($_POST['genres'])) { if(in_array("folk", $_POST['genres'])){ echo "checked='checked'";}}else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="folk">Folk (<?php echo $folk_total;?>) </label>
							</li>
							<li>
							 	<input id="indie" type="checkbox" name="genres[]" value="indie"  <?php if(isset($_POST['genres'])) { if(in_array("indie", $_POST['genres'])){ echo "checked='checked'";}} else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="indie">Indie (<?php echo $indie_total;?>) </label>
							</li>
							<li>
							 	<input id="electronic" type="checkbox" name="genres[]" value="electronic"  <?php if(isset($_POST['genres'])) { if(in_array("electronic", $_POST['genres'])){ echo "checked='checked'";}} else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="electronic">Electronic (<?php echo $electronic_total;?>) </label>
							</li>
							<li>
							 	<input id="jazz" type="checkbox" name="genres[]" value="jazz"  <?php if(isset($_POST['genres'])) { if(in_array("jazz", $_POST['genres'])){ echo "checked='checked'";}} else { echo "checked='checked'";} ?> />
								<label class='checkbox-label' for="jazz">Jazz (<?php echo $jazz_total;?>) </label>
							</li>
							<li>
							 	<input id="other" type="checkbox" name="genres[]" value="other"  <?php if(isset($_POST['genres'])) { if(in_array("other", $_POST['genres'])){ echo "checked='checked'";}} else { echo "checked='checked'";}  ?>/>
								<label class='checkbox-label' for="other">Other (<?php echo $other_total;?>) </label>
							</li>
						</ul>
					</div>
				</div>
				<!-- Time period range slider -->
	  			<input type="text" id="time_period" name="time_period">
	 			<div id="slider-range"></div>
			</div>

			<div id="advanced-search-col-right">
				<!-- Artist field -->
				<label for="artist">Artist</label>
				<input id ="artist_ac" type="text" name="artist" value="<?php echo isset($_POST['artist']) ? $_POST['artist'] : '' ?>">

				<!-- Year field -->
				<label for="year">Year</label>
				<input id="year_ac" type="text" name="year" value="<?php echo isset($_POST['year']) ? $_POST['year'] : '' ?>">

				<!-- Song field -->
				<label for="song">Song</label>
				<input id="song_ac" type="text" name="song_title" value="<?php echo isset($_POST['song_title']) ? $_POST['song_title'] : '' ?>">
			</div>
		</div>
	</form>

	<div class='toggler'>
		<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			echo '<u>Click here for a timeline of the hits your query produced!<br></u>';
		}
		?>
		<div id="timeline-wrapper">
			<?php
				if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
					require 'timeline.php';
				}
			?>
		</div>
	</div>

	<script>
	$(function() {
	  $('.toggler').click(function() {
	    $(this).find('div').slideToggle();
	  });
	});
	
	
	
	
	
	</script>

	<!-- RESULTS -->
	<div id="result-card-wrapper" height="1000px">
		<?php
		if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
			require 'action_page.php';
		}
		?>
	</div>
	<!--
	<div id="guess_genre">
	<a href="guess_genre.php">Guess Genre </a>-->
	
	</div>
	
	
 <script type="text/javascript">
 /*
 $("#hiphop").change(function () {
	console.log("checkbox change");
	if isset
	if (($key = array_search($del_val, $messages)) !== false) {
		unset($messages[$key]);
	}
	
 });
	
	
	var artist = $("#artist_ac").val();
	//ar email = $("#email").val();
	//var password = $("#password").val();
	//var contact = $("#contact").val();
	// Returns successful data submission message when the entered information is stored in database.
	// + '&email1='+ email + '&password1='+ password + '&contact1='+ contact
	var dataString = 'artist='+ artist ;
	if(artist=='')
	{
	alert("Please Fill All Fields");
	}
	else
	{
	// AJAX Code To Submit Form.
	$.ajax({
	type: "POST",
	url: "actionpage.php",
	data: dataString,
	cache: false,
	success: function(result){
	alert(result);
	}
	});
});
*/
 
	 
	 /*
$("#lyrics_form").ajaxForm({url: 'actionpage.php', type: 'post'});
	 window.location.reload();

	 
    var value = $(this).val();
    $.ajax({
        type: "POST",
        url: "set_home_vid.php",
        async: true,
        data: {
            action1: value // as you are getting in php $_POST['action1'] 
        },
        success: function (msg) {
            alert('Success');
            if (msg != 'success') {
                alert('Fail');
            }
        }
    });*/

 // Autocompletion for the input fields using the JQuery UI Autocomplete
 
$("#artist_ac").autocomplete({
	source: function(request, response) {
		var search = { "artist": request.term.toLowerCase() };
		// Form elasticsearch query
		var postData = {
			"from" : 0, "size" : 5,
			"query": { "match_phrase_prefix": search },
		};
		$.ajax({
			url: "http://localhost:9200/lyrics_new/lyric_new/_search",
			type: "POST",
			dataType: "JSON",
			data: JSON.stringify(postData),
			success: function(data) {
				var a = [];
				response($.map(data.hits.hits, function(item) {
					// Don't return duplicate results
					if (!(a.includes(item._source.artist))) {
						a.push(item._source.artist);
						return {
						label: item._source.artist,
						id: item._id
						}
					}
				}));
			},
		});
	},
	minLength: 1
});


$("#song_ac").autocomplete({
	source: function(request, response) {
		var search = { "song": request.term.toLowerCase() };
		// Form elasticsearch query
		var postData = {
			"from" : 0, "size" : 5,
			"query": { "match_phrase_prefix": search },
		};
		$.ajax({
			url: "http://localhost:9200/lyrics_new/lyric_new/_search",
			type: "POST",
			dataType: "JSON",
			data: JSON.stringify(postData),
			success: function(data) {
				var a = [];
				response($.map(data.hits.hits, function(item) {
					// Don't return duplicate results
					if (!(a.includes(item._source.song))) {
						a.push(item._source.song);
						return {
						label: item._source.song,
						id: item._id
						}
					}
				}));
			},
		});
	},
	minLength: 1
});


$("#lyrics").autocomplete({
	source: function(request, response) {
		var search = { "lyrics": request.term.toLowerCase() };
		// Form elasticsearch query
		var postData = {
			"from" : 0, "size" : 5,
			"query": { "match_phrase_prefix": search },
		};
		$.ajax({
			url: "http://localhost:9200/lyrics_new/lyric_new/_search",
			type: "POST",
			dataType: "JSON",
			data: JSON.stringify(postData),
			success: function(data) {
				var a = [];
				response($.map(data.hits.hits, function(item) {
					// Don't return duplicate results
					if (!(a.includes(item._source.lyrics))) {
						a.push(item._source.lyrics);
						return {
						label: item._source.lyrics,
						id: item._id
						}
					}
				}));
			},
		});
	},
	minLength: 1
});

	
</script>


</body>
</html>