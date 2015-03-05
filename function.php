<?php
function makeHuebsch($list) {
	sort($list);
	foreach ($list as $key) $linklistout=$linklistout.$key;
	$linklistout = str_replace('<a ', '<p><a ', $linklistout);
	$linklistout = str_replace('</a>', '</a></p>', $linklistout);
	return $linklistout;
}

function getContentMovie4k($file) {
	$html = new simple_html_dom();
	$html->load($file);
	foreach ($html->find('table[id=tablemoviesindex] td[width=550] a') as $name) {
		$link = $name->outertext;
		//Funktion wirft bei leerer Suche Link zurück
		//<a href="http://movie4k.to/movie-5890324804-Download-Cinema-movies-film.html" target="_blank">Vfdwe</a>
		if (strpos($link, 'target="_blank"') === false) {
			$link = str_replace('<a href="', '<a href="http://movie4k.to/', $link);
			$linklist[] = trim($link);
		}
	}
	return makeHuebsch($linklist);
}

function getHTMLMovie4k($searchString) {
	$url = 'http://www.movie4k.to/movies.php?list=search';
	$data = array (
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

function getContentKinox($file, $serie) {
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

function getHTMLKinox($searchString) {
	$searchString=str_replace(' ', '+', $searchString);
	$url = 'http://kinox.to/Search.html?q='.$searchString;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}

function getContentFreeTV($file) {
	$html = new simple_html_dom();
	$html->load($file);
	foreach ($html->find('table table[style="margin-left:10px; margin-top:0px;"] a[!class]') as $name) {
		$link = $name->outertext;
		$link = str_replace('<a href="', '<a href="http://www.free-tv-video-online.me', $link);
		$link = str_replace('<b>', '', $link);
		$link = str_replace('</b>', '', $link);
		$linklist[] = trim($link);
	}
	return makeHuebsch($linklist);
}

function getHTMLFreeTV($searchString, $serie) {
	$searchString=str_replace(' ', '+', $searchString);
	if ($serie) $url = 'http://www.free-tv-video-online.me/search/?md=shows&q='.$searchString;
	else $url = 'http://www.free-tv-video-online.me/search/?md=movies&q='.$searchString;
	$ch = curl_init();
	curl_setopt($ch,CURLOPT_URL, $url);
	curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
	$result = curl_exec($ch);
	curl_close($ch);
	return $result;
}
?>