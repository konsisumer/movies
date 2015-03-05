<html>
<head>
<title>Film-Suche</title>
</head>
<body>
<form action="" method="POST">
<input name="suche" type="text" size="30">
<input type="submit" value="Suchen">
</form>
<?php
require('simple_html_dom.php');

//if (!isset($_POST["suche"])) die();

$file = getHTMLFreeTV('Star Wars');

//echo '<p>'.$file.'</p>';
getContentFreeTV($file);

function getContentFreeTV($file) 
{
	$html = new simple_html_dom();
	$html->load($file);

	foreach ($html->find('table table[style="margin-left:10px; margin-top:0px;"] a[!class]') as $name) 
	{
		$link = $name->outertext;
		$link = str_replace('<a href="', '<a href="http://www.free-tv-video-online.me', $link);
		$link = str_replace('<b>', '', $link);
		$link = str_replace('</b>', '', $link);
		?>
		<p>
		<?php
		echo trim($link);
		?>
		</p>
		<?php
	}  
}

function getHTMLFreeTV($searchString)
{
	$searchString=str_replace(' ', '+', $searchString);
	$url = 'http://www.free-tv-video-online.me/search/?md=movies&q='.$searchString;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}
?>
</body>
</html>