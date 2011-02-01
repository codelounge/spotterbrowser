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
 * Spotterbrowser Controller
 * 
 * @since 4.0.0
 */
class Controller_Browser extends Controller_Website {

//---------------------------------------------------------------------
// Regular actions
//---------------------------------------------------------------------	
	
	/**
	 * Index
	 * Redirect to the search page
	 * 
	 * @since 4.0.0
	 */
	public function action_index()
	{
		$this->request->redirect('browser/search');
	}

	/**
	 * Search page
	 * 
	 * @since 4.0.0
	 */
	public function action_search() {
		// Init values
		$this->template->title = 'Bildersuche';
		$data= array();
		
		// Unset previous search values in session if a new search is called
		$session = Session::instance();
		if (false != $session->get('airline') )      { $session->set('airline', false); } 
		if (false != $session->get('airport') )      { $session->set('airport', false); }
		if (false != $session->get('manufacturer') ) { $seesion->set('manufacturer', false); }
		if (false != $session->get('aircraft'))      { $session->set('aircraft', false); }
		
		//---------------------------------------------------------------------
		// Database queries to fill the select elements
		//---------------------------------------------------------------------
		
		// Airports
		$airports_query = DB::query(Database::SELECT, 'SELECT * FROM airports ORDER BY name ASC');
		$airports_list = $airports_query->execute();
		$data['airports'][0] = "Flughafen auswählen...";
		foreach ($airports_list as $airport) {
			$data['airports'][$airport['id']] = $airport['name'] . " (".$airport['icao']."/".$airport['iata'].")";
		}
		
		// Airlines
		$airlines_query = DB::query(Database::SELECT, 'SELECT * FROM airline ORDER BY name ASC');
		$airlines_list = $airlines_query->execute();
		$data['airlines'][0] = "Fluglinie auswählen...";
		foreach ($airlines_list as $airline) {
			$data['airlines'][$airline['id']] = $airline['name'];
		}
		
		// Manufacturer
		$manufacturer_query = DB::query(Database::SELECT, 'SELECT * FROM manufacturer order BY name ASC');
		$manufacturer_result = $manufacturer_query->execute();
		$data['manufacturer'][0] = "Hersteller auswählen...";
		foreach ($manufacturer_result as $manufacturer) {
			$data['manufacturer'][$manufacturer['id']] = $manufacturer['name'];
		}
		
		// Aircrafts
		$aircrafts_query = DB::query(Database::SELECT, 'SELECT a.*, m.name as manufacturer_name FROM aircrafts a INNER JOIN manufacturer m ON m.id = a.manufacturer_id ORDER BY m.name ASC, a.type ASC');
		$aircrafts_list = $aircrafts_query->execute();
		$data['aircrafts'][0] = "Flugzeugtyp wählen...";
		foreach ($aircrafts_list as $aircraft) {
			$data['aircrafts'][$aircraft['id']] = $aircraft['manufacturer_name'].' '.$aircraft['type'];
		}
		
		// Read statistics
		$this->template->statistics = SB_Statistics::getStatistics();
		
		// Output template
		$this->template->content = CL_View::factory('search', $data);
	}


	/**
	 * @since 4.0.0
	 * Enter description here ...
	 */
	public function action_result() {
		
		// Init values
		$data = array();
		$session = Session::instance();

		//---------------------------------------------------------------------
		// Read Parameter
		//---------------------------------------------------------------------
		
		// Manufacturer Parameter
		if (false == $session->get('manufacturer')) {
			$manufacturer_id = (isset($_GET['manufacturer']) && $_GET['manufacturer'] != 0) 	? (int) $_GET['manufacturer'] 	: false;
			$session->set('manufacturer', $manufacturer_id);
		} else {
			$manufacturer_id = $session->get('manufacturer');
		}
		
		// Airport Parameter
		if (false == $session->get('airport')) {
			$airport_id 	 = (isset($_GET['airport']) && $_GET['airport'] != 0) 			? (int) $_GET['airport'] 		: false;
			$session->set('airport',  $airport_id);
		} else {
			$airport_id = $session->get('airport');
		}
		
		// Airline Parameter
		if (false == $session->get('airline')) {
			$airline_id 	 = (isset($_GET['airline']) && $_GET['airline'] != 0) 			? (int) $_GET['airline'] 		: false;
			$session->set('airline',  $airline_id);
		} else {
			$airline_id = $session->get('airline');
		}
		
		// Aircraft Parameter
		if (false == $session->get('aircraft_id')) {
			$aircraft_id 	 = (isset($_GET['aircraft']) && $_GET['aircraft'] != 0) 			? (int) $_GET['aircraft'] 		: false;
			$session->set('aircraft', $aircraft_id);
		}
		else {
			$aircraft_id->get('aircraft');
		}
		
		$perpage 		 = (isset($_GET['perpage'])) && is_numeric($_GET['perpage'])    ? (int) $_GET['perpage'] : 20;
		
		//---------------------------------------------------------------------
		// Generate Query Strings
		//---------------------------------------------------------------------
		
		// Prepare query conditions
		$conditions = array();
		if ($manufacturer_id) 	{ $conditions['m.id'] = $manufacturer_id; } 
		if ($airport_id) 		{ $conditions['f.id'] = $airport_id; }
		if ($airline_id) 		{ $conditions['l.id'] = $airline_id; }
		if ($aircraft_id) 		{ $conditions['a.id'] = $aircraft_id; }
		
		if (!isset($_GET['page']) || !is_numeric($_GET['page'])) {
			$page = 1;
		} else {
			$page = (int) $_GET['page'];
		}
		
		// Calculate total items
		$qty_qry = "SELECT count(p.id) as quantity
				FROM pictures p
				INNER JOIN airports f ON f.id = p.airport_id
				INNER JOIN airline l ON l.id = p.airline_id
				INNER JOIN aircrafts a ON a.id = p.type_id
				INNER JOIN manufacturer m ON m.id = a.manufacturer_id 
				INNER JOIN users u ON u.id = p.user_id ";
		$qty_qry .= $this->addConditions($conditions);
		$qty_query = DB::query(Database::SELECT, $qty_qry);
		$qty_result = $qty_query->execute();
		$quantity = $qty_result[0]['quantity'];	
		
		// Run database query
		$qstr = "SELECT p.*, f.name as flughafen_name, l.name as airline_name, a.type as flugzeugtyp , m.name as hersteller, f.iata, f.icao, u.firstname, u.lastname
				FROM pictures p
				INNER JOIN airports f ON f.id = p.airport_id
				INNER JOIN airline l ON l.id = p.airline_id
				INNER JOIN aircrafts a ON a.id = p.type_id
				INNER JOIN manufacturer m ON m.id = a.manufacturer_id 
				INNER JOIN users u ON u.id = p.user_id ";
		$qstr .= $this->addConditions($conditions);
		$qstr .= $this->addPagination($page, $perpage);
		$qstr .= ';';
		// printr($qstr);
		$query = DB::query(Database::SELECT, $qstr);
		$result = $query->execute();
		$data['pictures'] = $result->as_array();

		// Paginate the result
		$pagination = new Pagination(array(
        	'current_page'   => array('source' => 'query_string', 'key' => 'page'),
			'total_items'    => $quantity,
			'items_per_page' => $perpage,
			'view'           => 'pagination/zz_floating',
			'auto_hide'         => TRUE,
        	'first_page_in_url' => FALSE,
        ));
        $data['pagination'] = $pagination->render();
        
        // Read statistics
        $this->template->statistics = SB_Statistics::getStatistics();
        
        // Output template
		$this->template->content = CL_View::factory('result', $data);
	}	
	
	
	/**
	 * @since 4.0.0
	 * Enter description here ...
	 */
	public function action_image() {
		// Init values
		$data = array();
		$image_id = (int) $this->request->param('id', 1);
		
		// Query single image data
		$qstr = "SELECT p.*, f.name as flughafen_name, l.name as airline_name, a.type as flugzeugtyp , m.name as hersteller, f.iata, f.icao, u.firstname, u.lastname
				FROM pictures p
				INNER JOIN airports f ON f.id = p.airport_id
				INNER JOIN airline l ON l.id = p.airline_id
				INNER JOIN aircrafts a ON a.id = p.type_id
				INNER JOIN manufacturer m ON m.id = a.manufacturer_id 
				INNER JOIN users u ON u.id = p.user_id 
				WHERE p.id = :id;";
		$query = DB::query(Database::SELECT, $qstr);
		$query->bind(':id', $image_id);
		$result = $query->execute()->as_array();
		$data['picture'] = $result[0];
	 	
		// Read statistics
		$this->template->statistics = SB_Statistics::getStatistics();
		
		// Output template
		$this->template->content = CL_View::factory('image', $data);
	}	

//---------------------------------------------------------------------
// AJAX Calls
//---------------------------------------------------------------------		
	
	/**
	 * 
	 * @since 4.0.0
	 * @return JSON
	 */
	public function action_getCurrentMonth() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}

		if (isset($_GET['currentdate'])) {
			$date = date('Y-m', strtotime( (string) $_GET['currentdate'])).'-%';
		} elseif (isset($_GET['year']) && isset($_GET['month'])) {
			$_year = (int) $_GET['year'];
			$_month = (int) $_GET['month'] < 10 ? '0'.(int) $_GET['month'] : $_GET['month'];
			$date = $_year . '-' . $_month . '-%';
		} else {
			$date = date('Y-m')."-%";
		}
		$data = array();
	
		$datelist_query = DB::query(Database::SELECT, "SELECT DISTINCT * FROM pictures where imagedate like :date;" )
			->bind(':date',$date);
		$datelist_result = $datelist_query->execute();	
		
		if ($datelist_result->count() > 0 ) {
			$data['month'] = date('n', strtotime($datelist_result[0]['imagedate']));
			foreach($datelist_result as $entry) {
				$data['days'][] = (int) date('j', strtotime($entry['imagedate']));
			}
		}
		
		// Output JSON Object
		echo json_encode($data);
	}
	
	/**
	 * 
	 * @since 4.0.0
	 * @return HTML Form Select Element
	 * Enter description here ...
	 */
	public function action_changeaircraft() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		if (!isset($_GET['type'])) {
			return;
		}
		$type = (int) $_GET['type'];
		
		$aircraft = ORM::factory('aircraft')->find($type);
		$manufacturer_query = DB::query(Database::SELECT, 'SELECT * FROM manufacturer order BY name ASC');
		$manufacturer_result = $manufacturer_query->execute();
		$data['manufacturer'][0] = "Hersteller auswählen...";
		foreach ($manufacturer_result as $manufacturer) {
			$data['manufacturer'][$manufacturer['id']] = $manufacturer['name'];
		}
		echo Form::select('manufacturer', $data['manufacturer'], $aircraft->manufacturer_id,  array('id' => 'select_manufacturer'));
	}
	
//---------------------------------------------------------------------
// Helper methods
//---------------------------------------------------------------------	
	
	/**
	 * Add SQL-Query conditions to the main result
	 * 
	 * @since 4.0.0
	 * @param 	array 	$conditions Query conditions
	 * @return	string 	MySQL query partial
	 */
	private function addConditions($conditions) {
		$_isFirst = true;
		$output = false;
		if (count($conditions) > 0) {
			foreach ($conditions as $key => $value) {
				if ($_isFirst) {
					$output .= ' WHERE '.$key.' = \''.CL_Security::xss_clean($value). '\' ';
					$_isFirst = false;
				} else {
					$output .= ' AND '.$key.' = \''.CL_Security::xss_clean($value). '\' ';
				}
			}
			return $output;
		} else {
			return '';
		}
	}
	
	/**
	 * @since 4.0.0
	 * Enter description here ...
	 * @param unknown_type $page
	 * @param unknown_type $perpage
	 */
	private function addPagination($page = 1, $perpage = 20) {
		if (!$page) {
			return '';
		}
		
		$output = '';
		$offset = ($page - 1) * $perpage;
		$output = ' LIMIT '.$offset.','.$perpage.' ';
		return $output;
		
	}
	

	
	
	
} // End Controller