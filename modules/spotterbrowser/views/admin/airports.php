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
<h2>Flughäfen</h2>
<hr />
<?php if (count($airports) > 0 ) : ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<th align="left" width="100">IATA</th>
		<th align="left" width="100">ICAO</th>
		<th align="left" >Name</th>
		<th align="right" width="100">Optionen</th>
	</tr>
	<?php foreach ($airports as $airport) : ?>
	<tr>
		<td><?php echo $airport->iata; ?></td>
		<td><?php echo $airport->icao; ?></td>
		<td><?php echo $airport->name; ?></td>
		<td align="right"><?php echo HTML::anchor('admin/airportedit/'.$airport->id, 'Edit', array('rel' => 'facebox')); ?></td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>