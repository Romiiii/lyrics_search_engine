<head>
    
   
	
</head>
<html>
<body>


<h1>My First Web Page</h1>
<p>My First Paragraph</p>


<div id="my_canvas">
Here we want our wordcloud.

</div>

<script src="wordcloud.js" type="text/javascript"></script>


<script>

document.getElementById("demo").innerHTML = "js is running";
	list = [['foo', 12], ['bar', 6]]
	WordCloud(document.getElementById('my_canvas'), { list: list } );
</script> 

</body>

</html>