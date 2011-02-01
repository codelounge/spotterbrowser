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
<div id="footer" style="bottom: 0px;">
	<div class="alignleft footercolumn">
		&copy; 2010-<?php echo date('Y');?> SpotterBrowser.de
	</div>
	<div class="alignleft footercolumn">
		<div>
			Powered by SpotterBrowser V4.0
		</div>
		<p>&nbsp;</p>
		<div>
			<a href="http://www.spotterbrowser" target="blank">Spotterbrowser Website</a><br />
			<a href="http://www.codelounge.de/forum/index.php?showforum=70" target="blank">Support-Forum</a><br />
			<a href="http://www.codelounge.de/forum/index.php?app=tracker&showproject=9" target="blank">Bugtracker</a>
		</div>
	</div>
	<div class="alignleft footercolumn">
		<h4>Statistik:</h4>
		<div>Anzahl Bilder: <?php echo $statistics['total_images']; ?></div>
		<div>Anzahl verschiedener Flughäfen: <?php echo $statistics['airports']; ?></div>
		<div>Anzahl verschiedener Airlines: <?php echo $statistics['airlines']; ?></div>
		<div>Anzahl verschiedener Registrationen: <?php echo $statistics['registrations']; ?></div>
	</div>
	<div class="clear"></div>
</div>

<div id="footermeta">
	<div class="alignright" id="facebook">
	</div>
	<div class="alignleft" id="poweredby">
		<span class="label">powered by</span>
		<a class="php" target="_blank" href="http://php.net"> </a>
		<a class="mysql" target="_blank" href="http://www.mysql.org"> </a>
		<a class="jquery" target="_blank" href="http://www.jquery.com"> </a>
	</div>
	<div class="clear"></div>
</div>

</div> <!-- End Page Wrapper -->
<?php if (Kohana::$environment == 'development') : ?>
	<div id="kohana-profiler">
		<?php echo View::factory('profiler/stats') ?>
	</div>
<?php endif;?>
</body>
</html>