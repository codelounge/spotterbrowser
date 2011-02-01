<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Controller_Upgrade extends Controller_Installer {

	public function action_index()
	{
		$data = array();
		$updater = new SB_Upgrader();
		$this->template->title = "Update";
		$this->template->target_version = $updater->getTargetVersionName();
		
		$data['steps'] = $updater->getUpdateSteps();
		$data['current_step'] = $updater->getCurrentStep();
		$data['progress_value'] = $updater->getProgressValue();

		if (count($_POST) > 0) {
			foreach ($_POST as $key => $value) {
				$data['post'][CL_Security::xss_clean($key)] = CL_Security::xss_clean($value);
			}
		}
		
		$this->template->content = CL_View::factory('update', $data, 'installer');
	}
	
	public function action_start() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$updater = new SB_Upgrader();
		$data['target_version'] = $updater->getTargetVersionName();
		$data['current'] = $updater->getCurrentStep();
		$data['status'] = $updater->getCurrentStepStatus();
		$data['steps'] = $updater->getSteps();
		
		echo json_encode($data);
		
	}
	
	public function action_run() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$updater = new SB_Upgrader();
		$updater->run();
		return true;
	}

} // End Welcome
