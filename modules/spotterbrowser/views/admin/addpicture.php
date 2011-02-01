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
<h2>Spotting am <?php echo $spottingday; ?> in <?php echo $airport->name; ?> (<?php echo $airport->iata; ?>/<?php echo $airport->icao; ?>)</h2>
<hr />
<div class="small alignright"><strong><?php echo HTML::anchor('admin/selectspottingsession', '&Auml;ndern'); ?></strong></div>
<br />
<br />
<div id="contentform">
	<h3>Foto hochladen</h3>
	<?php echo Form::open(NULL, array('enctype' => 'multipart/form-data')); ?>
    <?php echo form::hidden('token', Security::token(true)); ?>
	<?php echo Form::file('photo'); ?>
	<br />
	<br />
	<?php echo Form::submit('submit','Foto hochladen', array('class' => 'button')); ?>
	<?php echo Form::close(); ?>
</div>