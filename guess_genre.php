
<html>
<head>

	<link rel="stylesheet" type="text/css" href="style2.css">

</head>

<body>

<div id="header2">
	<div id="lyric-search">
		<h2> Type in your lyrics <br>and your computer will guess the genre!<br><br></h2>
		<form method="post">
		<textarea rows="8" cols="80" name="lyrics" value="<?php echo isset($_POST['lyrics']) ? $_POST['lyrics'] : '' ?>" autofocus> </textarea>

		<br><br>
		<input type="submit" value="Guess genre" id="genre_submit">
		</form>
	</div>
</div>

</body>


</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'result_genre.php';
}
?>