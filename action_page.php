<?php
echo "lets see";
echo "value :".$_SESSION['first_run'];
if(!isset($_SESSION['first_run'])){
	# This code will get executed everytime the website is opened in a new browser and not any other time
    $_SESSION['first_run'] = 1;
    echo "We only wanna see this once";
}
?>

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

$params = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'body' => [
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
if ($number_of_results > 10) {
    $x = 10;
} else {
    $x = $number_of_results;
}

if (isset($_GET['page_number'])) {
	print "The page number is: ".$_GET['page_number'];
	$page_number = $_GET['page_number'];
} else {
	print "Page number is: 0";
}

# echo $number_of_results;

# THE RESULTS IN FOR LOOP
?>
<div id="result-card-wrapper">
    <?php
    for ($i = 0; $i < $x; $i++) {
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
<?php

$params_2 = [
    'index' => 'lyrics',
    'type' => 'lyric',
    'body' => [
		'size' => 0,
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
        ],
		"aggs" => [
			"group_by_year" => [
				"terms" => [
					"field" => "year.keyword"
					]
				]
			]
    ]
];

$results_2 = $client->search($params_2);

for ($i = 0; $i < count($results_2['aggregations']['group_by_year']['buckets']); $i++) {
	echo $results_2['aggregations']['group_by_year']['buckets'][$i]['key'];
	echo "<br/> ";
	echo $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
	echo "<br/><br/>";
}




?>


<a href="index2.php?page_number=<?php echo $page_number + 10;?>"> Link next </a>
<input type="button" value="Next" onClick="NextPage()">

<script>

function NextPage() {
	<?php $page_number = $page_number + 10;?>
	window.location.reload()
}

</script>

</body>

</html>

