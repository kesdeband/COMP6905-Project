<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Vehicles extends REST_Controller {

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
	* MODEL FUNCTION: retrieve_vehicle_info($registrationNo)
	* URL: localhost/cloud/server/index.php/api/vehicles/detail/regno/<regno>
	* SAMPLE DATA: N/A
	*/
	function detail_get() 
	{
		if(!$this->get('regno')) {
			$this->response(array('success' => false, 'error' => 'Invalid Vehicle Registration No.'), 400);
		}

		try {
			$vehicle = $this->Vehicles_model->retrieve_vehicle_info($this->get('regno'));
		}
		catch(Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		if($vehicle) {
			$this->response($vehicle, 200);
		}
		else {
			$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
		} 
	}
}