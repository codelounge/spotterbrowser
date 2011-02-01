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
	<title>SpotterBrowser-Adminbereich: <?php echo $title ?></title>

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
	<div id="main_wrapper">
		<div id="header">
			<div id="header_version" class="alignright"><strong>Version:</strong> <?php echo $version; ?></div>
			<div id="header_text" class="alignleft">SpotterBrowser - Administration</div>
			<div class="clear"></div>
		</div>
		<div id="navspacer"></div>
		<div id="content_wrapper">
			<div id="sidebar">
				<?php foreach ($navigation as $section) : ?>
					<div class="<?php echo isset($section['status']) ? $section['status'] : 'section'; ?>">
						<div class="sidebarsectionheadline"><?php echo $section['name']; ?></div>
						<ul class="sidebarlist">
						<?php foreach ($section['elements'] as $element) : ?>
							<li><?php echo HTML::anchor($element['url'], $element['name']); ?></a>
						<?php endforeach; ?>
						</ul>
					</div>
				<?php endforeach; ?>
			</div>
			<div id="content">
