<!DOCTYPE html>
<html lang="sv">
<head>
	<meta charset="utf-8">
	<title><?php echo isset($title) ? $title : DEFAULT_TITLE; ?></title>	
	<link <?php $this->helper->Link(IMG.'favicon.ico');?> rel="shortcut icon">

	<!-- links to external stylesheets -->
	<link rel="stylesheet" <?php $this->helper->Link(CSS.'ui-lightness/jquery-ui-1.8.20.custom.css');?> title="standard stylesheet" type='text/css'>
	<link rel="stylesheet" <?php $this->helper->Link(CSS.'qtip.css');?> title="standard stylesheet" type='text/css'>
  <link href='http://fonts.googleapis.com/css?family=Bilbo+Swash+Caps|Trocchi|Karla|Nothing+You+Could+Do' rel='stylesheet' type='text/css'>
  <link rel='stylesheet' <?php $this->helper->Link(CSS.'style.php');?> type='text/css' media='all'>

	<!-- $pageStyle for additional style -->
<?php echo (isset($pageStyle)) ? "<style type='text/css'>{$pageStyle}</style>" : ""; ?>	

	<!--[if lt IE 9]><script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	<!--[if !IE 7]>
	<style type="text/css">
		#wrap {display:table;height:100%}
	</style>
<![endif]-->
</head>

<body <?php echo (isset($pageId)) ? "id='{$pageId}'" : ""; ?>>

<?php 
echo Debug::Instance()->output();
?>

<!-- stickyfoot wrapper -->
<div class="stickfootwrap">

<!-- navigation header -->
<header class="top">
	<nav class="menu">
		<a <?php $this->helper->Link('home');?> id="home-">Hem</a>
		<a <?php $this->helper->Link('articles');?> id="articles-">Artiklar</a>
		<a <?php $this->helper->Link('objects');?> id="objects-">Objekt</a>
		<a <?php $this->helper->Link('gallery');?> id="gallery-">Galleri</a>
		<a <?php $this->helper->Link('about');?> id="about-">Om BMO</a>
		<a <?php $this->helper->Link('admin');?> id="admin-">Admin</a>				
	</nav>	
</header>

<!-- primary content wrapper -->
<div class="mainwrapper">

<header class="logo">
	<h5>Begravningsmuseum Online</h5>
</header>

<?php 

require( $this->view ); 

?>

<!-- end content wrapper -->
</div>

<!-- end stickyfoot wrapper -->
</div>

<!-- footer -->
<div class="footer">
	<footer class="bottom">
	<div class="leftfoot">
	<p>
		<a href="http://validator.w3.org/check/referer">HTML5</a> /
		<a href="http://jigsaw.w3.org/css-validator/check/referer">CSS</a> / 
		<a href="http://validator.w3.org/unicorn/check?ucn_uri=referer&amp;ucn_task=conformance">Unicorn</a> / 
		<a href="http://validator.w3.org/i18n-checker/check?uri=<?php echo $this->helper->getCurrentUrl(); ?>">i18n</a> /
		<a href="http://validator.w3.org/checklink?uri=<?php echo 	$this->helper->getCurrentUrl(); ?>">Links</a>
	</p>
	</div>
	<div class="rightfoot">
	<a rel="license" href="http://creativecommons.org/licenses/by-sa/3.0/"><img alt="Creative Commons License" style="border-width:0" <?php $this->helper->Link('img/html5/cc-by-sa.png', 'src');?> /></a> 
	<a href="http://validator.w3.org/check/referer"><img alt="Valid HTML5" <?php $this->helper->Link('img/html5/HTML5_Logo_32.png', 'src'); ?>></a>
	<a href="http://jigsaw.w3.org/css-validator/check/referer"><img height='19' <?php $this->helper->Link('img/html5/vcss-blue.gif', 'src'); ?> alt="Valid CSS!" /></a>
	Design &copy; Jon Neverland - Version <?php echo exec('git tag'); ?>
	</div>

	</footer>
</div>

<script <?php $this->helper->Link('js/jquery-1.7.2.min.js', 'src');?> type="text/javascript"></script>
<script <?php $this->helper->Link('js/jquery.qtip.js', 'src');?> type="text/javascript"></script>	
<script <?php $this->helper->Link('js/jquery-ui-1.8.20.custom.min.js', 'src');?> type="text/javascript"></script>
<script <?php $this->helper->Link('js/admin.js', 'src');?> type="text/javascript"></script>

<?php echo $this->helper->getJsFunctions(); ?>

</body>
</html>
