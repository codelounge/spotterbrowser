<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class SB_Statistics {

	/**
	 * @since 4.0.0
	 * Enter description here ...
	 */
	static function getStatistics() {
		// Total number of pictures
		$query1 = DB::query(Database::SELECT, "SELECT count(id) as qty FROM pictures;");
		$result1 = $query1->execute();
		$qty_pictures = $result1[0]['qty'];
		
		// Number of different airports
		$query2 = DB::query(Database::SELECT, "SELECT count(airport_id) as qty FROM pictures GROUP BY airport_id;"); 
		$result2 = $query2->execute();
		$qty_airports = $result2[0]['qty'];
		
		// Number of different airlines
		$query3 = DB::query(Database::SELECT, "SELECT count(airline_id) as qty FROM pictures GROUP BY airline_id;");
		$result3 = $query3->execute();
		$qty_airlines = $result3[0]['qty'];
		
		// Number of different registrations
		$query4 = DB::query(Database::SELECT, "SELECT count(registration) as qty FROM pictures GROUP BY registration;");
		$result4 = $query4->execute();
		$qty_registrations = $result4[0]['qty'];
		
		// Create output array
		$statistics = array();
		$statistics['total_images'] = $qty_pictures;
		$statistics['airports'] 	= $qty_airports;
		$statistics['airlines'] 	= $qty_airlines;
		$statistics['registrations'] = $qty_registrations;
		
		return $statistics;
	}
}