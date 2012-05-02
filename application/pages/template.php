<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="utf-8">
	<title><?php echo isset($title) ? $title : DEFAULT_TITLE;?></title>	
	<link <?php $this->Link(IMG.'favicon.ico');?> rel="shortcut icon">

	<!-- links to external stylesheets -->
<?php if(isset($_SESSION['stylesheet'])): ?>
	<link rel="stylesheet" <?php $this->Link(CSS.$_SESSION['stylesheet']);?>>
<?php else: ?>
	<link rel="stylesheet" <?php $this->Link(CSS.'style.css');?> title="standard stylesheet">
	<link rel="alternate stylesheet" <?php $this->Link(CSS.'debug.css');?> title="debug stylesheet">
<?php endif; ?>
	<link rel="stylesheet/less" type="text/css" <?php $this->Link(CSS.'styles.less');?> >
	<link href='http://fonts.googleapis.com/css?family=Oleo+Script' rel='stylesheet' type='text/css'>
	<script <?php $this->Link('js/less.js', 'src');?> type="text/javascript"></script>

	<!-- $pageStyle for additional style -->
	<?php if(isset($pageStyle)) : ?>
	<style type="text/css">
	<?php echo $pageStyle; ?>
	</style>
	<?php endif; ?>
	

	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->
</head>

<!-- The body id helps with highlighting current menu choice -->
<body<?php if (isset($pageId)) echo " id='$pageId' "; ?>>

<!-- stickyfoot wrapper -->
<div class="stickfootwrap">

<!-- related links header -->
<!-- <header class="above">
</header>
 -->
<!-- navigation header -->
<header class="top">
	<nav class="admin">
	<a href="/admin">admin</a>
	</nav>

	<nav class="menu">
		<a <?php $this->Link('home');?> id="home-">Hem</a>
		<a <?php $this->Link('articles');?> id="articles-">Artiklar</a>
		<a <?php $this->Link('objects');?> id="objects-">Objekt</a>
		<a <?php $this->Link('gallery');?> id="gallery-">Galleri</a>
		<a <?php $this->Link('about');?> id="about-">Om BMO</a>		
	</nav>
	
</header>

<!-- primary content wrapper -->
<div class="mainwrapper">

<header class="logo">
	<h5>Begravningsmuseum Online</h5>
</header>

<?php 
$e = CoreError::Instance();
$errors = $e->GetErrors();
if ($errors!==null) {
	echo $errors;
}
else { require($view); }

?>

<!-- end content wrapper -->
</div>

<!-- end stickyfoot wrapper -->
</div>

<!-- footer -->
<div class="footer">
	<footer class="bottom">
	<div class="leftfoot">
	<p><a href="http://validator.w3.org/check/referer">HTML5</a> /
	<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> / 
	<a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a> / 
	<a href="http://validator.w3.org/i18n-checker/check?uri=<?php // echo getCurrentUrl(); ?>">i18n</a> /
	<a href="http://validator.w3.org/checklink?uri=<?php // echo  getCurrentUrl(); ?>">Links</a>
</p>
	</div>
	<div class="rightfoot">
	<p>Design &amp; Copyright<a href="http://www.jonnev.se">Jon Neverland</a>
	</div>

	</footer>
</div>

</body>
</html>
