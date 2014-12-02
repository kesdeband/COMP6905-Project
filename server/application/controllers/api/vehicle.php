<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Vehicle extends REST_Controller {

	//Load models and helper classes in contructor to be used in Vehicles class
	function __construct() {
        parent::__construct();
        $this->load->model('Vehicles_model', '', TRUE);
        //$this->load->helper('cookie');
    }

    /*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	* CRUD: detail
	* HTTP METHOD: GET
	* MODEL FUNCTION: retrieve_vehicle_info($registrationNo, $country)
	* URL: localhost/cloud/server/index.php/api/vehicle/details/regno/<regno>/country/<country>/usertype/<usertype>
	* SAMPLE DATA: N/A
	*/
	function details_get() 
	{
		if(!$this->get('regno') || !$this->get('country') || !$this->get('usertype')) {
			$this->response(array('success' => false, 'error' => 'Invalid Vehicle Registration No./Country'), 400);
		}

		$arr = explode(" ", $this->get('regno'));
		$regno = "";
		foreach ($arr as $value) {
			$regno = $regno.trim($value);
		}

		$regno = strtoupper($regno);

		try {
			$vehicle = $this->Vehicles_model->retrieve_vehicle_info($regno, $this->get('country'), $this->get('usertype'));
		}
		catch(Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		if($vehicle) {
			if($vehicle === 404)
				$this->response(false, 200);
			else
				$this->response($vehicle, 200);
		}
		else {
			$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
		} 
	}
}