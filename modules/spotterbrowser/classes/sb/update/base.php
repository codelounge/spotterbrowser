<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

abstract class SB_Update_Base {
	
	protected $tx_errors = false;
	protected $percentage_per_step = false;
	
	public function getSteps() {
		return $this->steps;
	}
	
	public function getStepsStatus() {
		$this->percentage_per_step = 100 / count($this->steps);
		
		$query = DB::select()
				 ->from('updatelog')
				 ->where('version', '=', $this->targetVersion)
				 ->where('status', '=', 'finished');
		$result = $query->execute();
		
		if ($result->count() > 0) {
			foreach ($result as $entry) {
				$this->steps[$entry['step']]['status'] = strtolower($entry['status']);
			}
			$_progress = (int) $result->count() / count($this->steps) * 100;
			$this->progress = $_progress;
			$this->steps[$result->count() + 1]['status'] = 'current';
			return $result->count() + 1;
			
		} else {
			$this->steps[1]['status'] = 'current';	
			$this->progress = 0;
			return 1;
		}
	}
	
	public function getProgressValue() {
		return (int) $this->progress;
	}
	
	public function getCurrentStepStatus() {
		$query = DB::select()
				 ->from('updatelog')
				 ->where('version', '=', $this->targetVersion)
				 ->where('step', '=', $this->current_step)
				 ->where ('status', '!=', 'Finished');
		$result = $query->execute();
		
		if ($result->count() > 0 ) {
			return $result[0];
		} else {
			$updatelog = ORM::factory('updatelog');
			$updatelog->version = $this->targetVersion;
			$updatelog->step = $this->current_step;
			$updatelog->updatetime = date('U');
			$updatelog->status = 'Running';
			$updatelog->save();
			
			return $updatelog->as_array();
		}
	}
	
	public function run() {
		$this->initStep();
		
		$function_name = 'step'.$this->current_step;
		//if (function_exists($function_name)) {
			$this->$function_name();
		/*} else {
			$status = array();
			$status['cycle'] = 'n/a';
			$status['offset'] = 'n/a';
			$status['status'] = 'ERROR - Updatefunktion fuer diesen Schritt existiert nicht';
			$status['progress'] = (int) $this->progress;
			echo json_encode($status);
		}*/
		
		$return = $this->finalizeStep();
		return $return;
	}
	
	public function initStep() {
		$this->current_step_status = $this->getCurrentStepStatus();
		$query = DB::query(NULL, 'START TRANSACTION;');
		$query->execute();
		if (isset($this->steps[$this->current_step]['cycle_size'])) {
			$this->offset = $this->current_step_status['offset'];
		} else { 
			$this->offset = false;
		}
		// print_r($this->offset);
		
	}
	
	public function finalizeStep() {
		if ($this->tx_errors === false) {
			$query = DB::query(NULL, 'COMMIT;');
		} else {
			$query = DB::query(NULL, 'ROLLBACK;');
		}
		$result = $query->execute();
	}
	
}