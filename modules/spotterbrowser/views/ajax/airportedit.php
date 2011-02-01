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
<div class="ajaxheader"><span class="ajaxheadertext">SpotterBrowser</span></div>
<form method="post" action="airportupdate" id="airportedit_form">
	<table>
		<tr>
			<td>IATA</td>
			<td><?php echo Form::input('iata', $airport->iata); ?></td>
		</tr>
		<tr>
			<td>ICAO</td>
			<td><?php echo Form::input('icao', $airport->icao); ?></td>
		</tr>
		<tr>
			<td>Name</td>
			<td><?php echo Form::input('name', $airport->name); ?>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td><?php echo Form::submit('submit', 'Bearbeiten'); ?>
		</tr>
	
	</table>
	<?php echo Form::hidden('id', $airport->id); ?>
</form>