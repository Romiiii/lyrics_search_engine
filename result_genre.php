<?php

$lyrics = $_POST['lyrics'];
echo $lyrics;





$python = `python apply_nb.py $lyrics`;


echo "<br/><br/>The class is: ".$python;
			
	

?>