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

<div id="searchpanel">
	<?php echo Form::open('browser/result', array('method' => 'get')); ?>
	<div class="alignright" style="width: 297px">
		<dl>
			<dt class="col3">Datum:</dt>
			<dd class="col4"><?php echo Form::input('datum', '', array('id' => 'datepicker')); ?></dd>
			
			<dt class="col3">Registration:</dt>
			<dd class="col4"><?php echo Form::input('registration'); ?></dd>
			
			<dt class="col3">Volltext:</dt>
			<dd class="col4"><?php echo Form::input('fulltext'); ?></dd>
			
			<dt class="col3">Fotos/Seite:</dt>
			<dd class="col4"><?php echo Form::select('perpage', array('10' => 10, '20' => '20'), 20); ?></dd>
			
		</dl>
	</div>
	<div class="alignleft">
	
		<dl style="width: 497px;">
		    <dt class="col1">Flughafen:</dt>
		    <dd class="col2" id="search_airport"><?php echo Form::select('airport', $airports, NULL, array('id' => 'select_airport')); ?></dd>
		 
		    <dt class="col1">Fluggesellschaft:</dt>
		    <dd class="col2" id="search_airline"><?php echo Form::select('airline', $airlines, NULL, array('id' => 'select_airline')); ?></dd>
		 
		    <dt class="col1">Hersteller:</dt>
		    <dd class="col2" id="search_manufacturer"><?php echo Form::select('manufacturer', $manufacturer, NULL, array('id' => 'select_manufacturer')); ?></dd>
		 
		    <dt class="col1">Flugzeugtyp:</dt>
		    <dd class="col2" id="search_aircraft"><?php echo Form::select('aircraft', $aircrafts, NULL, array('id' => 'select_aircraft')); ?></dd>
	
		</dl>
	</div>
	<div class="clear"></div>
	<div style="text-align: center; padding: 5px;">
		<?php echo Form::submit('submit', 'Suchen'); ?>
		<?php echo Form::close(); ?>
	</div>
</div>