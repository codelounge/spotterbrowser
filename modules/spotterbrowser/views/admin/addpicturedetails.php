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

<h2>Fotodetails bearbeiten</h2>
<hr />
<div style="text-align: center; padding: 10px 10px 20px 10px;">
<img src="<?php echo $image;?>" />
</div>
<div id="contentform">
	<?php echo Form::open(); ?>
	<table>
		<tr>
			<td width="120">Flughafen:</td>
			<td colspan="3"><?php echo $airport->name; ?> (<?php echo $airport->iata; ?>/<?php echo $airport->icao; ?>)</td>
		</tr>
		<tr>
			<td>Datum:</td>
			<td colspan="3"><?php echo $selected_day;?></td>
		</tr>
		<tr>
			<td valign="top">Registration:</td>
			<td valign="top"><?php echo Form::input('registration', $registration, array('id' => 'registration')); ?></td>
			<td valign="top" width="100"><strong>Nachschlagen:</strong></td>
			<td valign="top">
				<ul>
					<li><a href="#" id="lookuplocal">Lokale Datenbank</a></li>
					<li><a href="#" id="lookupairliners">Airliners.net</a></li>
					<li>Spotterbrowser-Datenbank <i>(not available)</i></li>
				</ul>
			</td>
		</tr>
		<tr>
			<td>Airline:</td>
			<td colspan="3" id="search_airline"><?php echo Form::input('airline', $airline_name, array('id' => 'select_airline')); ?></td>
		</tr>
		<tr>
			<td>Flugzeughersteller:</td>
			<td colspan="3" id="search_manufacturer"><?php echo Form::input('manufacturer', $manufacturer_name, array('id' => 'select_manufacturer')); ?></td>
		</tr>		
		<tr>
			<td>Flugzeugtyp:</td>
			<td colspan="3" id="search_aircraft"><?php echo Form::input('aircraft', $aircraft_name, array('id' => 'select_aircraft')); ?></td>
		</tr>		
		<tr>
			<td>Kommentar:</td>
			<td colspan="3"><i>not implemented yet</i></td>
		</tr>
		<tr>
			<td>Specials:</td>
			<td colspan="3"><i>not implemented yet</i></td>
		</tr>	
		<tr>
			<td>&nbsp;</td>
			<td colspan="3"><?php echo Form::submit('submit', 'Bearbeiten', array('class' => 'button')); ?>
		</tr>
	</table>
	<?php echo Form::close(); ?>
</div>


<div id="lokal-dialog-message" title="Lokale Datenbank">
	<p>
		<span class="ui-icon ui-icon-circle-check" style="float:left; margin:0 7px 50px 0;"></span>
		Es gab keinen Treffer bei der Abfrage der Registration in der lokalen Datenbank.
	</p>
</div>
