<?php defined('SYSPATH') or die('No direct script access.');
/**
 * This file is part of the Spotterbrowser package.
 *
 * (c) 2011 Thomas Stein <thomas@spotterbrowser.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

class SB_Update_400a1 extends SB_Update_Base {
	
	private $isLast = false;
	
	private static $instance;
	
	protected $progress = 0;
	
	protected $current_step;
	
	protected $current_step_status;
	
	protected $targetVersion = false;
	
	
	static final function instance($targetVersion) {
		if (!isset(self::$instance)) {
			self::$instance = new self($targetVersion);
		}
		return self::$instance;
	}
	
	public function __construct($targetVersion = false) {
		$this->targetVersion = $targetVersion;
		$this->steps = array(
			'1' => array(
					'name' 		 => 'Migration Airlines',
					'cycle_size' => 5,
					
				),
			'2' => array(
					'name' 		 => 'Migration Airports',
				),
			'3' => array(
					'name' 		 => 'Migration Aircrafts',
					'cycle_size' => 10,
				),
			'4' => array(
					'name'		 => 'Migration Bilder',
					'cycle_size' => 20,
				),
			'5' => array(
					'name'		 => 'Admin-Benutzer anlegen'
				),
			'6' => array(
					'name' 		 => 'Finalisieren',
					'isLast' 	 => true,
				),
		);
		$this->current_step = $this->getStepsStatus();
		
		
	}
	
	/**
	 * STEP 1:
	 * Migration Airlines
	 */
	protected function step1() {
		
		$count_query = DB::query(Database::SELECT, 'SELECT count( tmp.Airline ) AS Airlines
													FROM (
														SELECT DISTINCT Airline
														FROM spot
													) AS tmp');
		$count_result = $count_query->execute();
		$qty_airlines = $count_result[0]['Airlines'];
		//echo "QTY Airlines: ".$qty_airlines."<br >";
		
		$qstr = "SELECT DISTINCT Airline FROM spot ";
		if (isset($this->steps[$this->current_step]['cycle_size'])) {
			$qstr .= " LIMIT ".$this->offset.",".$this->steps[$this->current_step]['cycle_size'].";";
		}
		
		$query = DB::query(Database::SELECT, $qstr);
		$result = $query->execute();
		
		
		foreach ($result as $entry) {
			$entry_query = DB::query(Database::INSERT, 'INSERT INTO airline (name) VALUES (:name)')
    		->bind(':name', $entry['Airline']);
 
			$entry_result = $entry_query->execute();
			if ($entry_result[1] != true) {
				$this->tx_errors = true;
				return false;
			}
		}
		//print_r($this->current_step_status);
		
		
		$_cycle = $this->current_step_status['cycle'] + 1;
		$_offset = $this->current_step_status['offset'] +  $this->steps[$this->current_step]['cycle_size'];
		
		$this->current_step_status['cycle'] = $_cycle;
		$this->current_step_status['offset'] = $_offset;

		// Recalculate progress
		$_function_progress = $_offset / $qty_airlines;
		$_function_progress_global = $this->percentage_per_step * $_function_progress;
		$this->current_step_status['progress'] = (int) ($this->progress + $_function_progress_global);
	
		
		
		if ($_offset < $qty_airlines) {
			$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET cycle = :cycle, offset = :offset where id= :status_id')
				->bind(':cycle', $_cycle)
				->bind(':offset', $_offset)
				->bind(':status_id', $this->current_step_status['id']);
			} else {
				$_status = 'Finished';
				$this->current_step_status['status'] = $_status;
				
				$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status, cycle = :cycle, offset = :offset where id = :status_id')
				->bind(':status', $_status)
				->bind(':cycle', $_cycle)
				->bind(':offset', $qty_airlines)
				->bind(':status_id', $this->current_step_status['id']);
			}
		$status_result = $status_query->execute();
		
		
		echo json_encode($this->current_step_status);		
	}

	/**
	 * STEP 2:
	 * Migration Airports
	 */
	protected function step2() {
		$qstr = "SELECT DISTINCT Ort FROM spot";
		$query = DB::query(Database::SELECT, $qstr);
		$result = $query->execute();
		
		foreach ($result as $entry) {
			$_ort = strtoupper($entry['Ort']);
			$entry_query = DB::query(Database::INSERT, 'INSERT INTO airports (iata) VALUES (:iata)')
	    		->bind(':iata', $_ort);
 
			$entry_result = $entry_query->execute();
			if ($entry_result[1] != true) {
				$this->tx_errors = true;
				return false;
			}
		}
		
		$_function_progress_global = $this->percentage_per_step;
		$this->current_step_status['progress'] = (int) ($this->progress + $_function_progress_global);
				
		$_status = 'Finished';
		$this->current_step_status['status'] = $_status;
				
		$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status where id = :status_id')
			->bind(':status', $_status)
			->bind(':status_id', $this->current_step_status['id']);
			
		$status_result = $status_query->execute();
		
		
		echo json_encode($this->current_step_status);	
	}	
	
	/**
	 * STEP 3:
	 * Migration Aircrafts
	 */
	public function step3() {
		$count_query = DB::query(Database::SELECT, 'SELECT count( tmp.Typ ) AS Types
													FROM (
													SELECT DISTINCT Typ
													FROM spot
													) AS tmp');
		$count_result = $count_query->execute();
		$qty_types = $count_result[0]['Types'];
		
		$manufacturer_query = DB::query(Database::SELECT, 'SELECT * FROM manufacturer');
		$manufacturer_list = $manufacturer_query->execute();
		
		$qstr = "SELECT DISTINCT Typ FROM spot ";
		if (isset($this->steps[$this->current_step]['cycle_size'])) {
			$qstr .= " LIMIT ".$this->offset.",".$this->steps[$this->current_step]['cycle_size'].";";
		}
		$query = DB::query(Database::SELECT, $qstr);
		$result = $query->execute();
		
		foreach ($result as $entry) {
			$_manufacturer_id = false;
			
			foreach ($manufacturer_list as $manufacturer) {
				$pos = false;
				$pos = strpos ( $entry['Typ'], $manufacturer['name'], 0);;
				if ( $pos === false || $pos > 0) {
				} else {
					$_manufacturer_id = $manufacturer['id'];
					
					$type = substr($entry['Typ'], ( strlen($manufacturer['name']) + 1 ) );
					
					$entry_query = DB::query(Database::INSERT, 'INSERT INTO aircrafts (manufacturer_id, type) VALUES (:manufacturer, :type)')
    					->bind(':manufacturer', $_manufacturer_id)
    					->bind(':type', $type);

					$entry_result = $entry_query->execute();
					if ($entry_result[1] != true) {
						$this->tx_errors = true;
						return false;
					}
					
					break;
				} 
			}
			
		}
		
		$_cycle = $this->current_step_status['cycle'] + 1;
		$_offset = $this->current_step_status['offset'] +  $this->steps[$this->current_step]['cycle_size'];
		
		$this->current_step_status['cycle'] = $_cycle;
		$this->current_step_status['offset'] = $_offset;

		// Recalculate progress
		$_function_progress = $_offset / $qty_types;
		$_function_progress_global = $this->percentage_per_step * $_function_progress;
		$this->current_step_status['progress'] = (int) ($this->progress + $_function_progress_global);
	

		if ($_offset < $qty_types) {
			$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET cycle = :cycle, offset = :offset where id= :status_id')
				->bind(':cycle', $_cycle)
				->bind(':offset', $_offset)
				->bind(':status_id', $this->current_step_status['id']);
			} else {
				$_status = 'Finished';
				$this->current_step_status['status'] = $_status;
				
				$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status, cycle = :cycle, offset = :offset where id = :status_id')
				->bind(':status', $_status)
				->bind(':cycle', $_cycle)
				->bind(':offset', $qty_types)
				->bind(':status_id', $this->current_step_status['id']);
			}
		$status_result = $status_query->execute();
		
		echo json_encode($this->current_step_status);
	}
	
	public function step4() {
		$count_query = DB::query(Database::SELECT, 'SELECT count( id ) AS Images FROM spot;');
		$count_result = $count_query->execute();
		$qty_images = $count_result[0]['Images'];
		
		$aircrafts_qstr = "SELECT m.id as m_id, m.name as m_name, a.id as a_id, a.type as a_type FROM aircrafts a
   						   INNER JOIN manufacturer m on a.manufacturer_id = m.id;";
		$aircrafts_query = DB::query(Database::SELECT, $aircrafts_qstr);
		$aircrafts_list = $aircrafts_query->execute();
		
		$airports_query = DB::query(Database::SELECT, 'SELECT * FROM airports');
		$airports_list = $airports_query->execute();
		
		$airlines_query = DB::query(Database::SELECT, 'SELECT * FROM airline');
		$airlines_list = $airlines_query->execute();
		
		$qstr = "SELECT * FROM spot ";
		if (isset($this->steps[$this->current_step]['cycle_size'])) {
			$qstr .= " LIMIT ".$this->offset.",".$this->steps[$this->current_step]['cycle_size'].";";
		}
		$query = DB::query(Database::SELECT, $qstr);
		$result = $query->execute();
		
		foreach ($result as $entry) {
			
			$_manufacturer_id = false;
			$_aircraft_id = false;
			$_airprot_id = false;
			$_airline_id = false;
			
			foreach ($airports_list as $airport) {
				if (strtolower($airport['iata']) == $entry['Ort']) {
					$_airport_id = $airport['id'];
					break;
				}
			}
			
			foreach ($airlines_list as $airline) {
				if ($airline['name'] == $entry['Airline']) {
					$_airline_id = $airline['id'];
					break;
				}
			}
			
			foreach ($aircrafts_list as $aircraft) {
				if ($aircraft['m_name'] . ' ' . $aircraft['a_type'] == $entry['Typ']) {
					$_manufacturer_id = $aircraft['m_id'];
					$_aircraft_id = $aircraft['a_id'];
					break;
				}
			}
		
			$_user_id = 1;
			$query = DB::query(Database::INSERT, 'INSERT INTO pictures
				(airport_id, imagedate, imagenumber, registration, airline_id, manufacturer_id, type_id, comment, views, specials, user_id)
				values
				(:airport_id, :imagedate, :imagenumber, :registration, :airline_id, :manufacturer_id, :type_id, :comment, :views, :specials, :user);')
				->bind(':airport_id', $_airport_id)
				->bind(':imagedate', $entry['Datum'])
				->bind(':imagenumber', $entry['Nummer'])
				->bind(':registration', $entry['Registration'])
				->bind(':airline_id', $_airline_id)
				->bind(':manufacturer_id', $_manufacturer_id)
				->bind(':type_id', $_aircraft_id)
				->bind(':comment', $entry['Kommentar'])
				->bind(':views', $entry['views'])
				->bind(':specials', $entry['Besonderheiten'])
				->bind(':user', $_user_id)
				;
			$result = $query->execute();
			if ($result[1] != true) {
				$this->tx_errors = true;
				return false;
			}
			
			
			
			
		}
		
		
		$_cycle = $this->current_step_status['cycle'] + 1;
		$_offset = $this->current_step_status['offset'] +  $this->steps[$this->current_step]['cycle_size'];
		
		$this->current_step_status['cycle'] = $_cycle;
		$this->current_step_status['offset'] = $_offset;

		// Recalculate progress
		$_function_progress = $_offset / $qty_images;
		$_function_progress_global = $this->percentage_per_step * $_function_progress;
		$this->current_step_status['progress'] = (int) ($this->progress + $_function_progress_global);
	

		if ($_offset < $qty_images) {
			$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET cycle = :cycle, offset = :offset where id= :status_id')
				->bind(':cycle', $_cycle)
				->bind(':offset', $_offset)
				->bind(':status_id', $this->current_step_status['id']);
			} else {
				$_status = 'Finished';
				$this->current_step_status['status'] = $_status;
				
				$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status, cycle = :cycle, offset = :offset where id = :status_id')
				->bind(':status', $_status)
				->bind(':cycle', $_cycle)
				->bind(':offset', $qty_images)
				->bind(':status_id', $this->current_step_status['id']);
			}
		$status_result = $status_query->execute();
		
		echo json_encode($this->current_step_status);
		
	}
	
	public function step5() {
		if (isset($_GET['username']) && isset($_GET['password']) && isset($_GET['email'])) {
			$this->current_step_status['progress'] = (int) $this->progress + ($this->percentage_per_step * 0.5);
			$this->current_step_status['cycle'] += 1;
			unset($this->current_step_status['hold']);
			
			$post = array();
			$post['username'] = CL_Security::xss_clean($_GET['username']);
			$post['password'] = CL_Security::xss_clean($_GET['password']);
			$post['email'] = CL_Security::xss_clean($_GET['email']);
			
			#Instantiate a new user
			$user = ORM::factory('user');	
 
			#Affects the sanitized vars to the user object
			$user->values($post);
 
			#create the account
			$user->save();
 
			#Add the login role to the user
			$login_role = new Model_Role(array('name' =>'admin'));
			$user->add('roles',$login_role);
 
			#sign the user in
			Auth::instance()->login($post['username'], $post['password']);
 
			$this->current_step_status['additional_html'] = '
				<table width="100%" border="0" cellspacing="0" cellpadding="10">
					<tr>
						<td width="200" class="row1">Admin-Benutzer:</td>
						<td class="row2">Angelegt.</td>
					</tr>
				</table>';
			
			
			$_status = 'Finished';	

			$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status where id = :status_id')
				->bind(':status', $_status)
				->bind(':status_id', $this->current_step_status['id']);
			
			$status_result = $status_query->execute();
			
			
		} else {
			$this->current_step_status['progress'] = (int) $this->progress;
			$this->current_step_status['hold'] = true;
			
			$this->current_step_status['additional_html'] = '
			<form method="post" action="">
			<table width="100%" border="0" cellspacing="0" cellpadding="10">
				<tr>
					<td width="200" class="row1">Admin-Benutzername:</td>
					<td class="row2"><input type="text" id="username" name="username" /></td>
				</tr>
				<tr>
					<td class="row1">E-Mail Adresse:</td>
					<td class="row2"><input type="text" id="email" name="email" /></td>
				</tr>
				<tr>
					<td class="row1">Passwort:</td>
					<td class="row2"><input type="password" id="password" name="password" /></td>
				</tr>
			</table>
			<input type="submit" name="submit" id="submit" value="Benutzer eintragen" />
			</form>';
		}
		echo json_encode($this->current_step_status);
	}
	
	public function step6() {
		$this->current_step_status['progress'] = 100;
		$this->current_step_status['status'] = 'Finished';
		$this->current_step_status['complete'] = true;
		
		$this->current_step_status['additional_html'] = '
		<table width="100%" border="0" cellspacing="0" cellpadding="10">
			<tr>
				<td width="200" class="row1">Migration</td>
				<td class="row2">Abgeschlossen.</td>
			</tr>
		</table>
		';
		
		$_status = "Finished";
		$status_query = DB::query(Database::UPDATE, 'UPDATE updatelog SET status = :status where id = :status_id')
			->bind(':status', $_status)
			->bind(':status_id', $this->current_step_status['id']);
		
		$status_result = $status_query->execute();
		echo json_encode($this->current_step_status);
	}
	
	
	public function getCurrentStep() {
		return $this->current_step;
	}
	

}