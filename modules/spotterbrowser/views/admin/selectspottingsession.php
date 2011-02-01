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
<h2>Spottingdetails ausw&auml;hlen</h2>
<hr />
<br />
<div id="contentform">
<?php echo Form::open(); ?>
<div class="column alignright" style="min-width: 300px;">
<h3>Datum w&auml;hlen</h3>
<?php echo Form::input('datum', $selected_day,  array('id' => 'datepicker')); ?>
</div>

<div class="column alignleft" style="min-width: 300px;">
<h3>Flughafen w&auml;hlen</h3>
<?php echo Form::select('airport', $airports, $selected_airport, array('id' => 'select_airport')); ?>
</div>

<div class="clear"></div>
<br />

<div style="text-align: center; padding: 5px;">
	<?php echo Form::submit('submit', 'Auswählen'); ?>
</div>
<?php echo Form::close(); ?>
</div>