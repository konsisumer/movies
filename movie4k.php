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

if (!isset($_POST["suche"])) die();

$file = getHTMLMovie4k($_POST["suche"]);
$linklist = getContentMovie4k($file);

echo $linklist;

function getContentMovie4k($file) 
{
	$html = new simple_html_dom();
	$html->load($file);

	foreach ($html->find('table[id=tablemoviesindex]') as $table) 
	{
		foreach ($table->find('td[width=550]') as $td)
		{
			foreach ($td->find('a') as $name)
			{
				$link = $name->outertext;
				$link = str_replace('<a href="', '<a href="http://movie4k.to/', $link);
				$link = trim($link);
				$linklist = $linklist.$link;
			}
		}
	}

	$linklist = str_replace('<a ', '<p><a ', $linklist);
	$linklist = str_replace('</a>', '</a></p>', $linklist);

	return $linklist; 
}

function getHTMLMovie4k($searchString)
{
	$url = 'http://www.movie4k.to/movies.php?list=search';
	$data = array
	(
		'search' => $searchString
	);
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_POST, true);
	curl_setopt($ch,CURLOPT_POSTFIELDS, $data);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);

	return $result;
}
?>
</body>
</html>