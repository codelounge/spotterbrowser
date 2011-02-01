<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

//-- Environment setup --------------------------------------------------------

/**
 * Set the default time zone.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/timezones
 */
date_default_timezone_set('Europe/Berlin');

/**
 * Set the default locale.
 *
 * @see  http://kohanaframework.org/guide/using.configuration
 * @see  http://php.net/setlocale
 */
setlocale(LC_ALL, 'de_DE.utf-8');

/**
 * Enable the Kohana auto-loader.
 *
 * @see  http://kohanaframework.org/guide/using.autoloading
 * @see  http://php.net/spl_autoload_register
 */
spl_autoload_register(array('Kohana', 'auto_load'));

/**
 * Enable the Kohana auto-loader for unserialization.
 *
 * @see  http://php.net/spl_autoload_call
 * @see  http://php.net/manual/var.configuration.php#unserialize-callback-func
 */
ini_set('unserialize_callback_func', 'spl_autoload_call');

//-- Configuration and initialization -----------------------------------------

/**
 * Set Kohana::$environment if a 'KOHANA_ENV' environment variable has been supplied.
 */
if (getenv('KOHANA_ENV') !== FALSE)
{
	Kohana::$environment = getenv('KOHANA_ENV');
}

/**
 * Initialize Kohana, setting the default options.
 *
 * The following options are available:
 *
 * - string   base_url    path, and optionally domain, of your application   NULL
 * - string   index_file  name of your index file, usually "index.php"       index.php
 * - string   charset     internal character set used for input and output   utf-8
 * - string   cache_dir   set the internal cache directory                   APPPATH/cache
 * - boolean  errors      enable or disable error handling                   TRUE
 * - boolean  profile     enable or disable internal profiling               TRUE
 * - boolean  caching     enable or disable internal caching                 FALSE
 */
Kohana::init(array(
	'base_url'   => '/spotterbrowser',
));

/**
 * Attach the file write to logging. Multiple writers are supported.
 */
Kohana::$log->attach(new Kohana_Log_File(APPPATH.'logs'));

/**
 * Attach a file reader to config. Multiple readers are supported.
 */
Kohana::$config->attach(new Kohana_Config_File);

/**
 * Enable modules. Modules are referenced by a relative or absolute path.
 */
Kohana::modules(array(
	'auth'          => MODPATH.'auth',       	  // Basic authentication
	// 'cache'      => MODPATH.'cache',      	  // Caching with multiple backends
	'codebench'     => MODPATH.'codebench',  	  // Benchmarking tool
	'database'      => MODPATH.'database',   	  // Database access
	'image'         => MODPATH.'image',      	  // Image manipulation
	'orm'           => MODPATH.'orm',        	  // Object Relationship Mapping
	// 'oauth'      => MODPATH.'oauth',      	  // OAuth authentication
	'pagination'    => MODPATH.'pagination', 	  // Paging of results
	// 'unittest'   => MODPATH.'unittest',   	  // Unit testing
	'spotterbrowser'=> MODPATH.'spotterbrowser', 
	'userguide'     => MODPATH.'userguide',       // User guide and API documentation
));


/**
 * Authentication shortcuts
 */
Route::set('auth', '<action>', array('action' => '(login|logout|register)'))
	->defaults(array(
  		'controller' => 'auth'
	));	

/**
 * Set the routes. Each route must have a minimum of a name, a URI and a set of
 * defaults for the URI.
 */
Route::set('default', '(<controller>(/<action>(/<id>)))')
	->defaults(array(
		'controller' => 'browser',
		'action'     => 'index',
	));

if ( ! defined('SUPPRESS_REQUEST'))
{
	/**
	 * Execute the main request. A source of the URI can be passed, eg: $_SERVER['PATH_INFO'].
	 * If no source is specified, the URI will be automatically detected.
	 */
	echo Request::instance()
		->execute()
		->send_headers()
		->response;
}

/**
 * Show's a formated version of thr print_r() function
 *
 * @param mixed $mVar Variable to be displayed
 */
function printR($mVar, $sOutput_file=null)
{
    // Array of variables
    $aVars = array($mVar);
    if(func_num_args() > 2) {
    	for($i = 2; $i < func_num_args(); $i++) {
        	$aVars[] = func_get_arg($i);
        }
    }

    // output
    foreach($aVars as $mVar) {
        if(is_null($sOutput_file)) {
            // output as html
            echo "<pre style='text-align: left;font-size: larger; border: 2px dashed #FF0000;background-color: #FFF; color: #000;'>";
            $mVar = print_r($mVar, true);
            $mVar = preg_replace("!(.*)\[(.*)\]( => .*)!"                           , "\\1<span style='color: #f00;'>[\\2]</span>\\3", $mVar);
            $mVar = preg_replace("!(.*) => ([a-zA-Z_0-9\-]+ Object\s+)!iU"          , "\\1 => <span style='color: #8232BF; font-weight: bold;'>\\2</span>", $mVar);
            $mVar = preg_replace("!([a-zA-Z_0-9\-]+ Object\s)!"                     , "<span style='color: #8232BF; font-weight: bold;'>\\1</span>", $mVar);
            $mVar = preg_replace("!(.*) => ([0-9\.]+\s)!"                           , "\\1 => <span style='color: #DC4FD7;'>\\2</span>", $mVar);
            $mVar = preg_replace("!(.*) => (\d{4}-\d{2}-\d{2} \d{2}:\d{2}:\d{2}\s)!", "\\1 => <span style='color: #0056E4;'>\\2</span>", $mVar);
            $mVar = preg_replace("!(.*) => (\d{4}-\d{2}-\d{2}\s)!"                  , "\\1 => <span style='color: #0056E4;'>\\2</span>", $mVar);
            $mVar = preg_replace("!(.*) => (\d{2}:\d{2}:\d{2}\s)!"                  , "\\1 => <span style='color: #0056E4;'>\\2</span>", $mVar);
            $mVar = preg_replace("!(.*) => (\s{2,})!"                               , "\\1 => <span style='color: #FFA810;'>NULL OR \"\"</span>\\2", $mVar);
            $mVar = preg_replace("!(.*) => ([a-fA-F0-9]{32})(\s+)!"                 , "\\1 => <span style='color: #119E2B;'>\\2</span>\\3", $mVar);
            echo $mVar;
            echo "</pre>";
        } else {
            // output to file
            if($sOutput_file === true) {
            	$sOutput_file = 'debug.txt';
            }

        	$rFp = fopen($sOutput_file, 'a');
            fwrite($rFp, print_r($mVar, true));
            fwrite($rFp, "\n");
            fclose($rFp);
        }
    }
}