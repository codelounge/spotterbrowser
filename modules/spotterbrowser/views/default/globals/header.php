<?php 
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
?>
<!DOCTYPE html>
<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> -->
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo Kohana::$charset ?>" />
	<meta http-equiv="Content-Language" content="de-de" />
	<title>SpotterBrowser: <?php echo $title ?></title>

 <!--  	<meta name="keywords" content="<?php // echo $meta_keywords;?>" />
    <meta name="description" content="<?php //echo //$meta_description;?>" />
    <meta name="copyright" content="<?php //echo //$meta_copyright;?>" />
-->
	<?php foreach ($styles as $style => $media)
		echo HTML::style($style, array('media' => $media)), "\n" ?>
	
	<?php foreach ($scripts as $script)
		echo HTML::script($script), "\n" ?>

</head>
<body>
<div id="page">

	<div id="header">
		SpotterBrowser 
	</div>
	