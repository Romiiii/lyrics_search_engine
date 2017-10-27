<?php

$lyrics = $_POST['lyrics'];
#echo $lyrics;



$python = `python apply_nb.py $lyrics`;
?>
<div id="genre-result">
<?php
echo "<br/><br/>The class is: ".$python;
?>
</div>			
<?php

?>