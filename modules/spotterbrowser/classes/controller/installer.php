<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Controller_Installer extends Controller_Template {

	public $template = 'site';
	
	public function before()
	{
		//parent::before();

		$this->template = CL_View::factory($this->template, array(), 'installer');
		
		$theme = 'installer';
		
		if ($this->auto_render) {
			
			$this->template->title            = '';
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copright    = '';
			
			$this->template->styles = array(
					'media/css/'.$theme.'/style.css' => 'screen',
					'media/css/cupertino/jquery-ui-1.8.7.custom.css' => 'screen'
				);

			$this->template->scripts = array(
				'media/js/jquery-1.5.min.js',
				'media/js/jquery-ui-1.8.7.custom.min.js'
			);
			

			if (Request::$is_ajax) {
				$this->template = 'ajax';
			}
			
		}
	}
	
	
} // End Welcome
