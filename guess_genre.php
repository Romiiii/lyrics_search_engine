<html>

<body>

<form method="post">
<textarea rows="4" cols="50" name="lyrics"> </textarea>


<input type="submit" value="Guess genre">
</form>

</body>


</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'result_genre.php';
}
?>