
<html>
<head>

	<link rel="stylesheet" type="text/css" href="style2.css">

</head>

<body>
<div>
Type in your lyrics and your computer will guess the genre!

</div>
<form method="post">
<textarea rows="4" cols="50" name="lyrics"> </textarea>

<br><br>
<input type="submit" value="Guess genre" id="genre_submit">
</form>

</body>


</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'result_genre.php';
}
?>