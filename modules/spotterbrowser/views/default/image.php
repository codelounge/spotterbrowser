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
<?php $filepath = ROOT_URL . '/images/'.date('Y', strtotime($picture['imagedate'])) .'/' .strtolower($picture['iata']) . date('m', strtotime($picture['imagedate']))  . date('d', strtotime($picture['imagedate'])) ;?>
<?php $filename = '/'.$picture['imagenumber'] . '.jpg'; ?>
<img src="<?php echo $filepath.$filename; ?>">


<div class="resultlistitem" style="background: #444444;">
	<div class="alignleft" id="resultdata" style="text-align: left; width: 780px; padding: 10px 10px 10px 10px;">
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
	<div class="clear"></div>
</div>

<div style="text-align: center;" id="buttonnavigation">
	<?php echo HTML::anchor('browser/result', 'Zur&uuml;ck', array('class' => 'button')); ?>
</div>