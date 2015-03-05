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
$serie = true;
$file = getHTMLKKiste('Star Wars');

$linklist=getContentKKiste($file, $serie);

if ($linklist!='') echo '<h1>Kinox</h1>'.$linklist;

function makeHuebsch($list)
{
	sort($list);

	foreach ($list as $key) $linklistout=$linklistout.$key;

	$linklistout = str_replace('<a ', '<p><a ', $linklistout);
	$linklistout = str_replace('</a>', '</a></p>', $linklistout);

	return $linklistout;
}

function getContentKKiste($file, $serie) 
{
	$html = new simple_html_dom();
	$html->load($file);
	foreach ($html->find('table[id=RsltTableStatic] tr') as $name) {
		if ($serie) {
			$links = $name->find('td img[title=series]');
		}
		else {
			$links = $name->find('td img[title=movie]');
		}
		if ($links[0]!='') {
			$link = $name->find('td',2)->innertext;
			$link = str_replace('<a href="', '<a href="http://kinox.to', $link);
			$link = str_replace(' onclick="return false;"', '', $link);
			$link = substr($link, 0, strpos($link, ' <spa'));
			$linklist[] = trim($link);
		}
	}
	return makeHuebsch($linklist);
}

function getHTMLKKiste($searchString)
{
	$searchString=str_replace(' ', '+', $searchString);
	$url = 'http://kkiste.to/search/?q='.$searchString;
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