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
<h2>Vorhandene Flugzeuge der Flotte der <?php echo $airline->name; ?></h2>
<hr />
<br />
Es wurden <strong><?php echo count($fleet); ?></strong> Registrationen gefunden.
<br />
<?php if (count($fleet) > 0 ) : ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<th align="left" >Registration</th>
		<th align="left" >Hersteller</th>
		<th align="left" >Flugzeugtyp</th>
		<th align="right" width="100">Anzahl Bilder</th>
	</tr>
	<?php foreach ($fleet as $aircraft) : ?>
	<tr>
		<td><?php echo $aircraft['registration']; ?></td>
		<td><?php echo $aircraft['manufacturer_name']; ?></td>
		<td><?php echo $aircraft['aircraft_type']; ?></td>
		<td align="right"><?php echo $aircraft['anzahl']; ?></td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>