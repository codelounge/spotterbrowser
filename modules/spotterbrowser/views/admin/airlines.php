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
<h2>Airlines</h2>
<hr />
<?php if (count($airlines) > 0 ) : ?>
<table width="100%" cellspacing="0" cellpadding="0" border="0">
	<tr>
		<th align="left" >Name</th>
		<th align="right" width="100">Optionen</th>
	</tr>
	<?php foreach ($airlines as $airline) : ?>
	<tr>
		<td><?php echo HTML::anchor('admin/fleet/'.$airline->id, $airline->name); ?></td>
		<td align="right"><?php echo HTML::anchor('admin/airlineedit/'.$airline->id, 'Edit', array('rel' => 'facebox')); ?></td>
	</tr>
	<?php endforeach;?>
</table>
<?php endif;?>