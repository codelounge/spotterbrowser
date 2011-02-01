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

<script type="text/javascript">
	$(document).ready(function() {

		
		$(function() {
			
			updateProgressbar(<?php echo $progress_value; ?>);
			startUpdateStep();
			runUpdateStep();
		});


	});
    
	function updateProgressbar(progress_value) {
		$(function() {
			$( "#progressbar" ).progressbar({
				value: progress_value
			});
			$( "#summary_progress").html(progress_value + '%');
		});
		
	};

	function startUpdateStep() {
		$.getJSON('upgrade/start', {}, function(data) {	
			$('#summary_status').html(data.status.status);
		});		
	};

	function runUpdateStep() {
		$.getJSON('upgrade/run', <?php echo isset($post) && $post != false ?  json_encode($post) : '{}'; ?>, function(data) {
			$('#summary_status').html(data.status);
			$('#summary_cycle').html(data.cycle);
			$('#summary_offset').html(data.offset);
			if (data.additional_html != null) {
				$('#summary_additional_html').html(data.additional_html);	
			}
			updateProgressbar(data.progress);
			
			if (data.complete === undefined && data.hold === undefined) {
					window.location.href = location.href;
			} 
		});
	}; 
	
</script>

<div id="sidebar">
	<?php  //printr($steps); die();?>
	<div class="sidebar_head">Updateschritte</div>
	<div id="sidebar_list">	
		<ol>
		<?php foreach ($steps as $key => $step) : ?>
			<li class="<?php echo isset($step['status']) ? $step['status'] : ''; ?>"><?php echo $step['name']; ?></li>
		<?php endforeach; ?>
		</ol>
	</div>
</div>

<div id="content">
	<div class="sidebar_head">Schritt <?php echo $current_step; ?>: <?php echo $steps[$current_step]['name']; ?></div>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
		<tr>
			<td width="200" class="row1">Status</td>
			<td class="row2" id="summary_status">Starting</td>
		</tr>
		<tr>
			<td class="row1">Durchlauf</td>
			<td class="row2" id="summary_cycle">1</td>
		</tr>
		<tr>
			<td class="row1">Offset</td>
			<td class="row2" id="summary_offset">n/a</td>
		</tr>
	</table>
	<div id="summary_additional_html"></div>
	<br /><br />
	<div class="sidebar_head">Status</div>
	
	<table width="100%" border="0" cellspacing="0" cellpadding="10">
		<tr>
			<td class="row1" width="200">Fortschritt</td>
			<td class="row2" id="summary_progress"><?php echo $progress_value; ?> %</td>
		</tr>
	</table>
	
	<div id="progressbar"></div>
</div>

<div class="clear"></div>