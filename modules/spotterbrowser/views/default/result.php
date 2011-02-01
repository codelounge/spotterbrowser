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
<?php // printr($pictures); ?>
<?php if (count($pictures) > 0 ) : ?>
	<?php echo $pagination; ?>
<?php foreach ($pictures as $picture) : ?>
	<?php $filepath = ROOT_URL . '/images/'.date('Y', strtotime($picture['imagedate'])) .'/' .strtolower($picture['iata']) . date('m', strtotime($picture['imagedate']))  . date('d', strtotime($picture['imagedate'])) ;?>
	<?php $filename = '/'.$picture['imagenumber'] . '.jpg'; ?>
	<?php $thumbnail = '/'.$picture['imagenumber']. '_s.jpg'; ?>
	<div class="resultlistitem">
		<div class="alignright" id="resultdata" style="text-align: left; width: 600px; padding: 0 10px 10px 10px;">
			<dl>
				<dt class="name">Index:</dt>
				<dd class="data"><?php echo $picture['id']; ?></dd>
				
				<dt class="name">Aufgenommen: </dt>
				<dd class="data">In <?php echo $picture['flughafen_name']; ?> (<?php echo $picture['iata'];?>/<?php echo $picture['icao'];?>) am <?php echo $picture['imagedate']; ?></dd>
			
				<dt class="name">Registration:</dt>
				<dd class="data"><?php echo $picture['registration']; ?></dd>
				
				<dt class="name">Airline:</dt>
				<dd class="data"><?php echo $picture['airline_name']; ?></dd>
				
				<dt class="name">Flugzeugtyp:</dt>
				<dd class="data"><?php echo $picture['hersteller']; ?> <?php echo $picture['flugzeugtyp']; ?></dd>

				<dt class="name">Kommentar:</dt>
				<dd class="data"><?php echo $picture['comment']; ?></dd>
			</dl>
			<div class="alignright">&copy; <?php echo $picture['firstname']; ?> <?php echo $picture['lastname']; ?></div>
		</div>
		
		<div class="alignleft" id="resultimage">
			<?php echo HTML::anchor('browser/image/'.$picture['id'], '<img src="'.$filepath.$thumbnail.'">');?>
		</div>
		<div class="clear"></div>
	</div>
	<?php endforeach; ?>
	<?php echo $pagination; ?>
	<div style="text-align: center;" id="buttonnavigation">
		<?php echo HTML::anchor('browser/search', 'Neue Suche', array('class' => 'button')); ?>
	</div>
<?php endif; ?>