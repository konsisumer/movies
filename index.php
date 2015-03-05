<html>
<head>
<title>Film-Suche</title>
<!--<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');
  ga('create', 'UA-44920501-1', 'konsi.org');
  ga('send', 'pageview');
</script>-->
<script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-44920501-1']);
  _gaq.push(['_gat._anonymizeIp']);
  _gaq.push(['_trackPageview']);
  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'stats.g.doubleclick.net/dc.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>
<script type="text/javascript">
  var _paq = _paq || [];
  _paq.push(["trackPageView"]);
  _paq.push(["enableLinkTracking"]);
  (function() {
    var u=(("https:" == document.location.protocol) ? "https" : "http") + "://piwik.konsi.org/";
    _paq.push(["setTrackerUrl", u+"piwik.php"]);
    _paq.push(["setSiteId", "2"]);
    var d=document, g=d.createElement("script"), s=d.getElementsByTagName("script")[0]; g.type="text/javascript";
    g.defer=true; g.async=true; g.src=u+"piwik.js"; s.parentNode.insertBefore(g,s);
  })();
</script>
</head>
<body>
<form action="" method="POST">
<input name="suche" type="text" size="30">
<input name="serie" type="checkbox">
<input type="submit" value="Search">
</form>
<?php
require('simple_html_dom.php');
require('function.php');
if ($_POST['serie']) $serie=true;
if (!isset($_POST["suche"])) die();
if (!$_POST['serie']) {
	$file = getHTMLMovie4k($_POST["suche"]);
	$linklist = getContentMovie4k($file);
	if ($linklist!='') echo '<h1>Movie4k</h1>'.$linklist;
}
$file = getHTMLKinox($_POST["suche"]);
$linklist = getContentKinox($file, $serie);
if ($linklist!='') echo '<h1>Kinox</h1>'.$linklist;
$file = getHTMLFreeTV($_POST["suche"], $serie);
$linklist = getContentFreeTV($file);
if ($linklist!='') echo '<h1>Free TV</h1>'.$linklist;
?>
</body>
</html>