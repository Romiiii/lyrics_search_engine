<?php



$start_time = substr($_POST['time_period'], 13, 4);

$end_time = substr($_POST['time_period'], 20, 4);


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

# TIMELINE
$results_2 = $client->search($params_2);

$v_6570 = 0;
$v_7075 = 0;
$v_7580 = 0;
$v_8085 = 0;
$v_8590 = 0;
$v_9095 = 0;
$v_9500 = 0;
$v_0005 = 0;
$v_0510 = 0;
$v_1015 = 0;
$v_1520 = 0;

for ($i = 0; $i < count($results_2['aggregations']['group_by_year']['buckets']); $i++) {
    $year = $results_2['aggregations']['group_by_year']['buckets'][$i]['key'];
    if ($year > 1965 and $year < 1970) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_6570 = $v_6570 + $doc_count;
        #echo '1965-1970 now at:';
        #echo $v_6570;
    }
    if ($year > 1970 and $year < 1975) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_7075 = $v_7075 + $doc_count;
        #echo '1970-1975 now at:';
        #echo $v_7075;
    }
    if ($year > 1975 and $year < 1980) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_7580 = $v_7580 + $doc_count;
        #echo '1975-1980 now at:';
        #echo $v_7580;
    }
    if ($year > 1980 and $year < 1985) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_8085 = $v_8085 + $doc_count;
        #echo '1980-1985 now at:';
        #echo $v_8085;
    }
    if ($year > 1985 and $year < 1990) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_8590 = $v_8590 + $doc_count;
        #echo '1985-1990 now at:';
        #echo $v_8590;
    }
    if ($year > 1990 and $year < 1995) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_9095 = $v_9095 + $doc_count;
        #echo '1990-1995 now at:';
        #echo $v_9095;
    }
    if ($year > 1995 and $year < 2000) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_9500 = $v_9500 + $doc_count;
        #echo '1995-2000 now at:';
        #echo $v_9500;
    }    
    if ($year > 2000 and $year < 2005) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_0005 = $v_0005 + $doc_count;
        #echo $doc_count;
        #echo '    |    ';
        #echo '2000-2005 now at:';
        #echo $v_0005;
    } 
    if ($year > 2005 and $year < 2010) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_0510 = $v_0510 + $doc_count;
        #echo $doc_count;
        #echo '    |    ';
        #echo '2005-2010 now at:';
        #echo $v_0510;
        #echo "<br/> ";
    } 
    if ($year > 2010 and $year < 2015) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_1015 = $v_1015 + $doc_count;
        #echo '2010-2015 now at:';
        #echo $v_1015;
    } 
    if ($year > 2015 and $year < 2020) {
        #echo $year;
        #echo 'doc_count = ';
        $doc_count = $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
        $v_1520 = $v_1520 + $doc_count;
        #echo '2015-2020 now at:';
        #echo $v_1520;
    } 
    #echo $results_2['aggregations']['group_by_year']['buckets'][$i]['key'];
	#echo "<br/> ";
	#echo $results_2['aggregations']['group_by_year']['buckets'][$i]['doc_count'];
	#echo "<br/><br/>";
}
?>
    
    
    <div class="ct-chart ct-perfect-fourth"></div>
   

    <script>
        var v_6570 = "<?php echo $v_6570; ?>" / 10000;
        var v_7075 = "<?php echo $v_7075; ?>" / 10000;
        var v_7580 = "<?php echo $v_7580; ?>" / 10000;
        var v_8085 = "<?php echo $v_8085; ?>" / 10000;
        var v_8590 = "<?php echo $v_8590; ?>" / 10000;
        var v_9095 = "<?php echo $v_9095; ?>" / 10000;
        var v_9500 = "<?php echo $v_9500; ?>" / 10000;
        var v_0005 = "<?php echo $v_0005; ?>" / 10000;
        var v_0510 = "<?php echo $v_0510; ?>" / 10000;
        var v_1015 = "<?php echo $v_1015; ?>" / 10000;
        var v_1520 = "<?php echo $v_1520; ?>" / 10000;

        // Create a simple bi-polar bar chart
        var chart = new Chartist.Bar('.ct-chart', {
          labels: ['1965-1970', '1970-1975', '1975-1980', '1980-1985', '1985-1990', '1990-1995', '1995-2000', '2000-2005', '2005-2010', '2010-2015', '2015-2020'],
          series: [
            [v_6570, v_7075, v_7580, v_8085, v_8590, v_9095, v_9500, v_0005, v_0510, v_1015, v_1520]
          ]
        }, {
          width: '900px',
          height: '600px',
          high: 20,
          low: 0,
          axisX: {
            labelInterpolationFnc: function(value, index) {
              return index % 1 === 0 ? value : null;
            }
          },
          axisY: {
            labelInterpolationFnc: function(value, index) {
              return index % 2 === 0 ? value : null;
            }
          }
        });

        // Listen for draw events on the bar chart
        chart.on('draw', function(data) {
          // If this draw event is of type bar we can use the data to create additional content
          if(data.type === 'bar') {
            // We use the group element of the current series to append a simple circle with the bar peek coordinates and a circle radius that is depending on the value
            data.group.append(new Chartist.Svg('circle', {
              r: Math.abs(Chartist.getMultiValue(data.value)) + 5,
              cx: data.x2,
              cy: data.y2 - Math.abs(Chartist.getMultiValue(data.value)) - 4
            }, 'ct-slice-pie'));



          }
        });
    </script>