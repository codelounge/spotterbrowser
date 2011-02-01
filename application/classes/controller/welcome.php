<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Controller_Welcome extends Controller {

	public function action_index()
	{
		$this->request->response = CL_View::factory('welcome');
	}

} // End Welcome
