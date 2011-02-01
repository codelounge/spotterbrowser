<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class Model_Airline extends ORM
{
	protected $_table_name = 'airline';
	protected $_primary_key = 'id';
	
	public function getFleetByAirlineId($airline_id) {
		$query = DB::query(Database::SELECT, 'SELECT p.registration, count(p.id) as anzahl, m.name as manufacturer_name, f.type as aircraft_type 
													FROM pictures p
													INNER JOIN aircrafts f ON p.type_id = f.id
													INNER JOIN manufacturer m ON f.manufacturer_id = m.id
													WHERE p.airline_id = :airline_id
													GROUP BY p.registration
													ORDER BY p.registration asc');
		$query->bind(':airline_id', $airline_id);
		$result = $query->execute();
		
		if(count($result) > 0) {
			return $result;
		} else {
			return false;
		}
	}
}