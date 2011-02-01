<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Purifier {
	// Purifier instances
	protected static $_instance;

    // HTML Purifier instance
    protected $purifier;


	/**
	 * Singleton pattern
	 *
	 * @return Auth
	 */
	public static function instance()
	{
       // Purifier::$_instance =false;
        if ( ! isset(Purifier::$_instance))
		{

			// Set the session class name
			$class = 'Purifier';

			// Create a new session instance
            Purifier::$_instance = new $class();
		}
		return Purifier::$_instance;
	}

    //start it
    public function __construct() {
        
        // Load HTMLPurifier
       	require_once(DOCROOT . '/libs/HTMLPurifier/HTMLPurifier.auto.php');
        //$k = Kohana::config('html_purifier');
        //$config = HTMLPurifier_Config::createDefault();
        //$config->set('HTML.Doctype', $k['HTML.Doctype']);
        $this->purifier = new  HTMLPurifier();
    }

    public function clean($dirty_html) {
        $clean_html = $this->purifier->purify( $dirty_html );
        return $clean_html;
    }

}

?>
