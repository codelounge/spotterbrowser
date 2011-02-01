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
 * Administration Controller
 * 
 * @author Thomas Stein
 * @since 4.0.0
 */
class Controller_Admin extends Controller_Admincp {

	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_index()
	{
		$this->template->title = 'Dashboard';
		$this->template->navigation = $this->getNavigation('bilder');
		
		
		$data = array();

		$this->template->content = CL_View::factory('index', $data, 'admin');
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_airports() {
		
		$this->template->title = "Airports";
		$this->template->navigation = $this->getNavigation('stammdaten');
		
		$data= array();
		
		$data['airports'] = ORM::factory('airport')->find_all();
		$this->template->content = CL_View::factory('airports', $data, 'admin');
		
	}
	

	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_airportedit() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$data = array();
		$airport_id = (int) $this->request->param('id');
		
		$airport = ORM::factory('airport')->find($airport_id);
		$data['airport'] = $airport;
		echo CL_View::factory('airportedit', $data, 'ajax');
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_airportupdate() {
		$airport = ORM::factory('airport')->find( (int) CL_Security::xss_clean($_POST['id']));
		$airport->iata = strtoupper(CL_Security::xss_clean($_POST['iata']));
		$airport->icao = strtoupper(CL_Security::xss_clean($_POST['icao']));
		$airport->name = CL_Security::xss_clean($_POST['name']);
		$airport->save();
		
		$this->request->redirect('admin/airports');
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_airlines() {
		
		$this->template->title = "Airlines";
		$this->template->navigation = $this->getNavigation('stammdaten');
		
		$data= array();
		
		$data['airlines'] = ORM::factory('airline')->order_by('name', 'asc')->find_all();
		$this->template->content = CL_View::factory('airlines', $data, 'admin');
		
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_fleet() {
		
		$this->template->title = "Flotte";
		$this->template->navigation = $this->getNavigation('stammdaten');
		
		$airline_id = (int) $this->request->param('id');
		
		$data= array();
		
		$data['airline'] = ORM::factory('airline')->find($airline_id);
		$data['fleet'] = $data['airline']->getFleetByAirlineId($airline_id);
		
		$this->template->title = "Flotte von ".$data['airline']->name;
		
		
		$this->template->content = CL_View::factory('fleet', $data, 'admin');
	}
	
	/**
	 *
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_selectspottingsession() {
		
		$this->template->title = "Flugzeugbild hinzuf&uuml;gen";
		$this->template->navigation = $this->getNavigation('bilder');
		
		$data = array();

		$session = Session::instance();
		
		// Airports
		$airports_query = DB::query(Database::SELECT, 'SELECT * FROM airports ORDER BY name ASC');
		$airports_list = $airports_query->execute();
		$data['airports'][0] = "Flughafen auswählen...";
		foreach ($airports_list as $airport) {
			$data['airports'][$airport['id']] = $airport['name'] . " (".$airport['icao']."/".$airport['iata'].")";
		}

		if ($_POST) {
			$purifier = new Purifier();
			$session->set('spottingplace', (int) $_POST['airport']);
			$session->set('spottingday', date('Y-m-d', strtotime($purifier->clean($_POST['datum']))));
			$this->request->redirect('admin/addpicture');
		}
	
		$data['selected_airport'] = $session->get('spottingplace', 0); 
		$data['selected_day']     = $session->get('spottingday', date('Y-m-d'));
		
		$this->template->content = CL_View::factory('selectspottingsession', $data, 'admin');
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_addpicture() {
		$session = Session::instance();
		
		$this->template->title = "Flugzeugbild hinzuf&uuml;gen";
		$this->template->navigation = $this->getNavigation('bilder');
		
		$data = array();

	
	
		// Check if a spotting session is selected
		if ( !$session->get('spottingplace') || !$session->get('spottingday') ) {
            $this->request->redirect('admin/selectspottingsession');
		}
		
		$data['airport'] = ORM::factory('airport')->find($session->get('spottingplace'));
		$data['spottingday'] = $session->get('spottingday', date('Y-m-d'));
		
		if ($_POST && isset($_FILES['photo']) && $_FILES['photo']['error'] < 1) {
        	if ($_POST['token'] == Security::token()) {
        		
        		
        		$imagenumber = $this->getLatestImageNumber($session->get('spottingday'), $session->get('spottingplace'));
        		
        		
        		
        		// Photparameter bestimmen
                $timestamp = strtotime($session->get('spottingday', date('Y-m-d')));
                $_year = date('Y', $timestamp);
                $_month = date('m', $timestamp);
                $_day = date('d', $timestamp);
                $path = DOCROOT . "images/$_year/".strtolower($data['airport']->iata).$_month.$_day."/";
                $original_image = Image::factory($_FILES['photo']['tmp_name']);

                // Check directories exist
                //printr(DOCROOT . "images/" . $_year);
                if (!file_exists(DOCROOT . "images/" . $_year)) {
                	@mkdir (DOCROOT . 'images/' . $_year, 0777);
                }
                if (!file_exists(DOCROOT . "images/$_year/".strtolower($data['airport']->iata).$_month.$_day)) {
                	@mkdir (DOCROOT . "images/$_year/".strtolower($data['airport']->iata).$_month.$_day, 0777);
                }
                
                // Groesse fuer Fullresolution ermitteln
                $original_size = ($original_image->width > $original_image->height) ? $original_image->width : $original_image->height;
                $fullresolution = ($original_size < 800) ? $original_size : 800;
                
                // Thumbnail 800 erstellen
                $thumbnail = $original_image;
                $thumbnail->resize($fullresolution, $fullresolution, Image::AUTO);
                $filename = $imagenumber.'.jpg';
                $thumbnail->save($path . $filename, 80);

                // Thumbnail 160 erstellen
                $thumbnail = $original_image;
                $thumbnail->resize(160, 160, Image::AUTO);
                $filename = $imagenumber.'_s.jpg';
                $thumbnail->save($path . $filename, 80);	
                
                $picture = ORM::factory('picture');
                $picture->airport_id = $session->get('spottingplace');
                $picture->imagedate = $session->get('spottingday');
                $picture->imagenumber = $imagenumber;
                $picture->user_id = $this->_user_id;
                $picture->save();
                
                $session->set('actualimage', $picture->id);
                
                $this->request->redirect('admin/addpicturedetails');
        	}
		}
		
		$this->template->content = CL_View::factory('addpicture', $data, 'admin');
		
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_addpicturedetails() {
		$purifier = new Purifier();
		$session = Session::instance();
		$this->template->title = "Flugzeugbild hinzuf&uuml;gen";
		$this->template->navigation = $this->getNavigation('bilder');
		
		$data = array();
	
		$data['selected_day']     = $session->get('spottingday', date('Y-m-d'));
		
		//---------------------------------------------------------------------
		// Database queries to fill the select elements
		//---------------------------------------------------------------------
		
		// Airports
		$data['airport'] = ORM::factory('airport')->find($session->get('spottingplace'));
			
		$data['registration'] = isset($_POST['registration'])      ? $purifier->clean($_POST['registration']) : '';
		$data['airline_name'] = isset($_POST['airline'])           ? $purifier->clean($_POST['airline'])      : '';
		$data['manufacturer_name'] = isset($_POST['manufacturer']) ? $purifier->clean($_POST['manufacturer']) : '';
		$data['aircraft_name'] = isset($_POST['aircraft'])         ? $purifier->clean($_POST['aircraft'])     : '';
		
		// Photparameter bestimmen
        $timestamp = strtotime($session->get('spottingday', date('Y-m-d')));
        $_year = date('Y', $timestamp);
        $_month = date('m', $timestamp);
        $_day = date('d', $timestamp);
    
 		$picture = ORM::factory('picture')->find((int) $session->get('actualimage'));

	    $path = ROOT_URL . "/images/$_year/".strtolower($data['airport']->iata).$_month.$_day."/";
 		$data['image'] = $path . $picture->imagenumber .'.jpg';
		
 		$post = Validate::factory($_POST)
	 		->filter(TRUE, 'trim')
	 		->rule('registration', 'not_empty')
	 		->rule('aircraft', 'not_empty')
	 		->rule('manufacturer', 'not_empty')
	 		->rule('airline', 'not_empty');

 		
 		// Form processing
 		if ($post->check()) {
 			// Get Airline
        	$airline = ORM::factory('airline');
 	       	$airline->where('name', '=', $data['airline_name'])->find();
 	       	if ($airline->id === false) {
 	       		$airline->name = $data['airline_name'];
 	       		$airline->save();
 	       	}
 	       	
 	       	// Get Manufacturer
 	       	$manufacturer = ORM::factory('manufacturer');
 	       	$manufacturer->where('name', '=', $data['manufacturer_name'])->find();
 	       	if ($manufacturer->id === false) {
 	       		$manufacturer->name = $data['manufacturer_name'];
 	       		$manufacturer->save();
 	       	}
 	       	
 	       	// Get Aircraft
 	       	$aircraft = ORM::factory('aircraft');
 	       	$aircraft->where('type', '=', $data['aircraft_name'])->find();
 	       	if ($aircraft->id === false) {
 	       		$aircraft->type = $data['aircraft_name'];
 	       		$aircraft->manufacturer_id = $manufacturer->id;
 	       		$aircraft->save();
 	       	}
 	    
 	       	// Complete picture data
 	       	$picture->airline_id = $airline->id;
 	       	$picture->manufacturer_id = $manufacturer->id;
 	       	$picture->type_id = $aircraft->id;
 	       	$picture->registration = $data['registration'];
 	       	$picture->save();
 	       	
 	       	$this->request->redirect('admin/addpicture');
 		}
 		
		$this->template->content = CL_View::factory('addpicturedetails', $data, 'admin');
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 * @param date 	$spottingday
	 * @param int 	$spottingplace
	 */
	private function getLatestImageNumber($spottingday, $spottingplace) {
		
		$query = DB::query(Database::SELECT, "SELECT count(id) as anzahl 
											  FROM pictures p	
										      WHERE p.airport_id = :airport_id
											  AND p.imagedate = :spotting_day");
		$query->bind(':airport_id', $spottingplace);
		$query->bind(':spotting_day', $spottingday);
		$result = $query->execute();
		
		
		return $result[0]['anzahl'] + 1;
		
	}
	
	/**
	 * @deprecated
	 * @author Thomas Stein
	 * @since 4.0.0
	 * @return HTML Form Select Element
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
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_autocompleteairline() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$purifier = new Purifier();
		$airline = $purifier->clean($_GET['term']);
		
		$query = DB::query(Database::SELECT, "SELECT name FROM airline WHERE name like '%".$airline."%';");
		$result = $query->execute();
		$data = array();
		
		if (count($result) > 0) {
			foreach($result as $airline) {
				$data[] = $airline['name'];
			}
		}
		echo json_encode($data);
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_autocompletemanufacturer() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$purifier = new Purifier();
		$airline = $purifier->clean($_GET['term']);
		
		$query = DB::query(Database::SELECT, "SELECT name FROM manufacturer WHERE name like '%".$airline."%';");
		$result = $query->execute();
		$data = array();
		
		if (count($result) > 0) {
			foreach($result as $manufacturer) {
				$data[] = $manufacturer['name'];
			}
		}
		echo json_encode($data);
		
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_autocompleteaircraft() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$purifier = new Purifier();
		$aircraft = $purifier->clean($_GET['term']);
		$manufacturer = $purifier->clean($_GET['manufacturer']);
		
		$query = DB::query(Database::SELECT, "SELECT a.type FROM aircrafts a
											  INNER JOIN manufacturer m ON a.manufacturer_id = m.id
											  WHERE a.type LIKE '%".$aircraft."%'
											  AND m.name LIKE '%".$manufacturer."%'
											  ORDER BY type asc;");
		$result = $query->execute();
		
		$data = array();
		
		if (count($result) > 0) {
			foreach($result as $aircraft) {
				$data[] = $aircraft['type'];
			}
		}
		echo json_encode($data);
		
	}
	
	/**
	 * 
	 * @author Thomas Stein
	 * @since 4.0.0
	 */
	public function action_lookuplocaldatabase() {
		if (Request::$is_ajax) {
			$this->auto_render = false;
			$this->profiler = null;
		}
		$purifier = new Purifier();
		$registration = $purifier->clean($_GET['registration']);
		
		$picture = ORM::factory('picture');
		$picture->where('registration', '=', $registration);
		$picture->order_by('imagedate', 'desc');
		$picture->find();
		
		$data = array();
		$data['found'] = false;
		
		if (false != $picture->id) {
			
			$airline = ORM::factory('airline')->find($picture->airline_id);
			$manufacturer = ORM::factory('manufacturer')->find($picture->manufacturer_id);
			$aircraft = ORM::factory('aircraft')->find($picture->type_id);
			
			$data['airline'] = $airline->name;
			$data['manufacturer'] = $manufacturer->name;
			$data['aircraft'] = $aircraft->type;
			$data['found'] = true;
		}
		echo json_encode($data);
		
	}

}