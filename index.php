<!DOCTYPE html>
<html>
<body>
<?php
require '../init.php'
?>

<form  method="post">
Artist:<br>
<input type="text" name="artist">
<br>
Last name:<br>
<input type="text" name="lastname">
<br><br>
<input type="submit">
</form>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
	require 'action_page.php';
}
?>

</body>
</html>

