<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * Extension to the default Kohana_View to match themes
 * Themes are configured in /application/config/spotterbrowser
 *
 * @package    Spotterbrowser
 * @category   System
 * @author     Thomas Stein
 * @copyright  (c) 2011 Thomas Stein
 * @license    http://www.spotterbrowser.de/license
 */
class CL_View extends View {
	
	protected static $theme;
	/**
	 * Overrides the default factory method to the themeable CL_View class
	 * 
	 * @param   string  view filename
	 * @param   array   array of values
	 * @return  View
	 */
	public static function factory($file = NULL, array $data = NULL, $theme = 'default')
	{
		self::$theme = $theme;
		
		return new CL_View($file, $data, self::$theme);
	}
	
	/**
	 * Sets the view filename with theme extension.
	 *
	 *     $view->set_filename($file);
	 *
	 * @param   string  view filename
	 * @return  View
	 * @throws  Kohana_View_Exception
	 */
	public function set_filename($file)
	{
		$theme = $this->getTheme(); 
		if (($path = Kohana::find_file('views/'.$theme, $file)) === FALSE)
		{
			throw new Kohana_View_Exception('The requested view :file could not be found', array(
				':file' => $file,
			));
		}

		// Store the file path locally
		$this->_file = $path;

		return $this;
	}
	
	/**
	 * Theme name setter
	 * 
	 * @param string view	theme name
	 */
	private function getTheme() {
		
		return self::$theme;
	}
	
}