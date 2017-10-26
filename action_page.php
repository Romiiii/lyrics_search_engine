<html>
<body>

<script src="wordcloud.js" type="text/javascript"></script>

<?php



require_once "../init.php";



if(!empty($_POST['genres'])) {

    $genres = $_POST['genres'];

} else {

    $genres = ['rock', 'hiphop', 'country', 'pop', 'metal', 'other', 'jazz', 'electronic', 'indie', 'folk', 'rb'];

}



$start_time = substr($_POST['time_period'], 13, 4);

$end_time = substr($_POST['time_period'], 20, 4);

$limit = 10;
$offset = 0;
if (isset($_SESSION['direction'])) {
	if ($_SESSION['direction'] == 1) {
		if (isset($_SESSION['page'])) {
			$_SESSION['page'] = $_SESSION['page'] + 1;
			$page = $_SESSION['page'];
			$offset = $limit * $page;
			echo "page session is: ".$page;
			echo "limit is ".$limit; 
		} 
	} else if ($_SESSION['direction'] == 0){
		if (isset($_SESSION['page'])) {
			if ($_SESSION['page'] > 0) {
				$_SESSION['page'] = $_SESSION['page'] - 1;
				$page = $_SESSION['page'];
				$offset = $limit * $page;
				echo "page session is: ".$page;
				echo "limit is ".$limit; 
			}
		} 
	}	
}




# from offset to offset + limit

$params = [

    'index' => 'lyrics',

    'type' => 'lyric',

    'body' => [
	
		'from' => $offset, 'size' => $limit,

        'query' => [

            'bool' => [

                'filter' => [ 

                    ['terms' => [ 'genre' => $genres ]],

					['range' => [

						'year' => [

							'gte' => $start_time,

							'lte' => $end_time,

						]

					]]

                ],

                'should' => [

                    [ 'match' => [ 'artist' => $_POST["artist"] ] ],

                    [ 'match' => [ 'year' => $_POST["year"] ] ],

                    [ 'match' => [ 'song' => $_POST["song_title"] ] ],

                    [ 'match_phrase' => ['lyrics' => $_POST['lyrics'] ] ],

                ]

            ]

        ]

    ]

];



$results = $client->search($params);



$number_of_results = $results['hits']['total'];




# SERP with 10 best results

if ($number_of_results > $limit) {

    $x = $limit;

} else {

    $x = $number_of_results;

}



# echo $number_of_results;



# THE RESULTS IN FOR LOOP

?>



    <?php
	
	
    for ($i = 0; $i < $limit; $i++) {
    	$song = $results['hits']['hits'][$i]['_source']['song'];

    	$artist = $results['hits']['hits'][$i]['_source']['artist'];

    	$year = $results['hits']['hits'][$i]['_source']['year'];

    	$lyrics = $results['hits']['hits'][$i]['_source']['lyrics'];

    	$id = $results['hits']['hits'][$i]['_id'];

    	$lyrics = trim(preg_replace('/[\r\n]+/', '\n', $lyrics));

        ?>
		
			
		
		<a href="lyric_page.php?id=<?php echo $id; ?>">
        <div id="result-card">
		
				
			<div id="<?php echo "wordcloud_".$i ;?>" class="wordclouds">
			placeholder
			</div>

            <div id='song'>

                 <?php echo $song; ?>

            </div>
		

            <p>

            <?php echo $artist, ', ', $year; ?>
			
            </p>
			
			
			
        </div>
		</a>

        <?php
		
		if ($i == 0) { 
			$python = `python text_wordcloud.py $lyrics`;
			?>
			<script>
			list = <?php echo $python;?>
			WordCloud(document.getElementById("<?php echo "wordcloud_".$i ;?>"), { list: list } );
			</script> 
			<?php
			
		} 

    }

    ?>

</div>

<a OnClick=PrevPage()> Previous </a>


<a OnClick=NextPage()> Next  </a>

<script>

function NextPage() {
	window.location.reload();
	<?php
	$_SESSION['direction'] = 1;
	?>
}

function PrevPage() {
	window.location.reload();
	<?php
	$_SESSION['direction'] = 0;
	?>
}

</script>
</body>
</html>



