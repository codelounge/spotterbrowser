<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class SB_Upgrader {
	
	private $actual_version;
	private $previous_version;
	private $versions;
	private $isLast = false;
	private $upgrader;
	
	public function __construct() {

		$this->versions = Kohana::config('versions')->as_array();
		
		$this->getPreviousVersion();
		$this->getCurrentVersion();
	
		$upgrade_class = "SB_Update_".$this->actual_version;
		$this->updater = SB_Update_400a1::instance($this->actual_version); //)$upgrade_class->instance();
		
	}	
	
	/** 
	 * Determines the current version where to update to
	 * 
	 * @return void
	 */
	private function getCurrentVersion() {
		
		// Migration from SB3 to SB4
		if ($this->previous_version = false && $this->actual_version == key($this->versions)) {
			return;
		}
	}
	
	/**
	 * Determines the previous version from which the upgrader has to start
	 * 
	 * @return void
	 */
	private function getPreviousVersion() {
		$query = DB::select()->from('settings')->where('key', '=', 'version');
		$result = $query->execute();

		if ($result->count() == 0 || (isset($result[0]) && $result[0]['value'] == false)) {
			$this->previous_version = false;
			// reset($this->versions);
			// current($this->versions);
			$this->actual_version = key($this->versions);
		} else {
			$this->acutal_version = $result[0]['value'];
		}
	}
	
	public function getTargetVersionName() {
		return $this->versions[$this->actual_version];
	}
	
	public function getUpdateSteps() {
		return $this->updater->getSteps();
	}
	
	public function getCurrentStep() {
		return $this->updater->getCurrentStep();
	}
	
	public function getProgressValue() {
		return $this->updater->getProgressValue();
	}
	
	public function getSteps() {
		return $this->updater->getSteps();
	}
	
	public function getCurrentStepStatus() {
		return $this->updater->getCurrentStepStatus();
	}
	
	public function run() {
		return $this->updater->run();
	}
	
}