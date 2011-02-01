<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Controller_Admincp extends Controller_Template {

	public $template = 'site';
	
	public function before()
	{
		if (!Kohana_Auth::instance()->logged_in()) {
            $this->request->redirect('/login');
        }
        
    	if (false != Kohana_Auth::instance()->get_user()) {	
			$this->_user = Kohana_Auth::instance()->get_user();
			$this->_user_id = $this->_user->id;

			// Check if logged in user has admin rights
			if (!Kohana_Auth::instance()->logged_in('admin')) {
				$this->request->redirect('/browser');
			}
    	} else {
			$this->_user_id = false;
			$this->_user = false;
		}

        //parent::before();

		$this->template = CL_View::factory($this->template, array(), 'admin');
		
		$theme = 'admin';
		
		if ($this->auto_render) {
			
			$this->template->title            = '';
            $this->template->meta_keywords    = '';
            $this->template->meta_description = '';
            $this->template->meta_copright    = '';
            $this->template->version = Kohana::config('versionnumber.version_name');
			
			$this->template->styles = array(
					'media/css/'.$theme.'/style.css' => 'screen',
					'media/css/cupertino/jquery-ui-1.8.7.custom.css' => 'screen',
					'media/css/facebox.css' => 'screen'
				);

			$this->template->scripts = array(
				'media/js/jquery-1.5.min.js',
				'media/js/jquery-ui-1.8.7.custom.min.js',
				'media/js/facebox/facebox.js',
				'media/js/'.$theme.'.js'
			);
			

			if (Request::$is_ajax) {
				$this->template = 'ajax';
			}
			
		}
		
		
	}
	
	public function getNavigation($current) {
		
		$navigation['bilder']['name'] = 'Flugzeugbilder';
		$navigation['bilder']['elements'][] = array('name' => 'Bilder hinzuf&uuml;gen', 'url' => 'admin/addpicture');
				
		$navigation['stammdaten']['name'] = 'Stammdaten';
		$navigation['stammdaten']['elements'][] = array('name' => 'Flughäfen', 'url' => 'admin/airports');
		$navigation['stammdaten']['elements'][] = array('name' => 'Airlines',  'url' => 'admin/airlines');
		
		$navigation[$current]['status'] = 'currentsection';
		
		return $navigation;
		
	}
	
} // End Welcome
