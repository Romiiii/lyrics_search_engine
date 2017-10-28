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

# Set the amount of results per page
$limit = 10;

# The page cookie keeps track of the page number
$cookie_name = "page";
if(!isset($_COOKIE[$cookie_name])) {
	$page = 0;
	$offset = 0;
} else {
	$page = $_COOKIE[$cookie_name];
	# Set offset so the right results for the page number are fetched 
	$offset = $page * $limit;
}

# Get results from offset to offset + limit

$params = [
    'index' => 'lyrics_new',
    'type' => 'lyric_new',

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

					[ 'match' => [ 'artist' => [
						'query' => $_POST["artist"],
						'boost' => 3 ] ] ],

                    [ 'match' => [ 'year' => [
						'query' => $_POST["year"],
						'boost' => 3 ] ] ],

                    [ 'match' => [ 'song' => [
						'query' => $_POST["song_title"],
						'boost' => 3 ] ] ],

                    [ 'match_phrase' => ['lyrics' => [
						'query' => $_POST['lyrics'],
						'boost' => 2 ] ] ],
					
					[ 'match' => ['lyrics' => $_POST['lyrics'] ] ],
					
					

                ]

            ]

        ],
		
		'highlight' => [
            'fields' => [
                'lyrics' => new \stdClass()
            ],
            'require_field_match' => false
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



# THE RESULTS IN FOR LOOP

?>



    <?php
	
	
    for ($i = 0; $i < $limit; $i++) {
    	$song = $results['hits']['hits'][$i]['_source']['song'];

    	$artist = $results['hits']['hits'][$i]['_source']['artist'];

    	$year = $results['hits']['hits'][$i]['_source']['year'];

    	$lyrics = $results['hits']['hits'][$i]['_source']['lyrics'];
	
    	$id = $results['hits']['hits'][$i]['_id'];

        $n_lyrics = $results['hits']['hits'][$i]['_source']['n_lyrics'];

    	$n_lyrics = trim(preg_replace('/[\r\n]+/', '\n', $n_lyrics));

        $lyrics = trim(preg_replace('/[\r\n]+/', '\n', $lyrics));
        ?>
		
			
		
        <div id="result-card">
		
				
			<div id="<?php echo "wordcloud_".$i ;?>" class="wordclouds">
			placeholder
			</div>

            <div id='song'>

                 <a href="lyric_page.php?id=<?php echo $id; ?>"><?php echo $song; ?></a>

            </div>
		

            <div id="result-snippet">
            <?php echo $artist, ', ', $year; ?>
			<?php echo "<br/><br/>"; 
			
			# Check if there are any matches in the lyrics that are highlighted
			if (sizeof($results['hits']['hits'][$i]) > 5 ) {
				$high_lyrics = $results['hits']['hits'][$i]['highlight']['lyrics'];
				echo "\"".$high_lyrics[0]."\"";
			}
			
			 ?>
            </div>
			
			
			
        </div>
		</a>

        <?php
		
		# Create the wordcloud
		$python = `python text_wordcloud.py $n_lyrics`;
		?>
		<script>
		list = <?php echo $python;?>
		WordCloud(document.getElementById("<?php echo "wordcloud_".$i ;?>"), { list: list } );
		</script> 
		<?php
			
	

    }

    ?>

</div>




<script>

checkCookie("page");
	

function setCookie(cname, cvalue, exdays) {
    var d = new Date();
    d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
    var expires = "expires="+d.toUTCString();
    document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

// Functions from: https://www.w3schools.com/js/js_cookies.asp

// Get the value of a cookie
function getCookie(cname) {
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i = 0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0) == ' ') {
            c = c.substring(1);
        }
        if (c.indexOf(name) == 0) {
            return c.substring(name.length, c.length);
        }
    }
    return "";
}

// Set the cookie if it has not been set yet
function checkCookie() {
	console.log(document.cookie);
    var user = getCookie("page");
    if (!(user != "")) {
        setCookie("page", 0, 5);
    }
}

// Increment page cookie if next page is pressed
function NextPage() {
	var page;
	page = getCookie("page");
	document.cookie = "page=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
	page++;
	setCookie("page", page, 5);
	window.location.reload();
}

// Decrement page cookie if previous page is pressed and we aren't on the first page
function PrevPage() {
	var page;
	page = getCookie("page");
	if (page > 0) {
		document.cookie = "hey=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
		page--;
		setCookie("page", page, 5);
	}
	window.location.reload();
}

</script>

<div>
<div id="prev">
<a OnClick='PrevPage();'> Previous </a>
</div>


<div id="page_num">
<?php
echo "Page: ".($_COOKIE['page']+1);
?>
</div>

<div id="next">
<a OnClick='NextPage();'> Next  </a>
</div>

</div>

</body>
</html>



