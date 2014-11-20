<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Tenants extends REST_Controller {

	//Load models and helper classes in contructor to be used in Tenants class
	function __construct() {
        parent::__construct();
        $this->load->model('Tenants_model', '', TRUE);
        //$this->load->helper('cookie');
    }

	/*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	* CRUD: account
	* HTTP METHOD: POST
	* MODEL FUNCTION: create_tenant($tenantid, $fname, $lname, $company, $username, $password)
	* URL: localhost/cloud/server/index.php/api/tenants/account
	* SAMPLE DATA: {"fname":"Keston","lname":"Joseph","company":"Petrotrin","username":"Kes","password":"Kes"}
	*/
	function account_post() 
	{
		if(!$this->post('fname') || !$this->post('lname') || !$this->post('company') || !$this->post('username') || !$this->post('password')) {
			$this->response("Username or password missing", 400);
		}

		$exists = $this->Tenants_model->tenant_exists($this->post('username'));

		if($exists) {
			$this->response("Tenant already exists", 400);
		}
		else {
			$tenantid = strtotime("now");
			$created = $this->Tenants_model->create_tenant(
					$tenantid,
					$this->post('fname'),
					$this->post('lname'),
					$this->post('company'),
					$this->post('username'),
					$this->post('password'));

			if ($created) //Registration successful, user created
			{
				$this->response(array('created' => $created), 201); 
			}
			else //An error occured on the server end
			{	
				$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
			}
		}
	}

	/**
	* CRUD: account
	* HTTP METHOD: GET
	* MODEL FUNCTION: login_tenant($username, $password)
	* URL: localhost/cloud/server/index.php/api/tenants/account/username/<username>/password/<password>
	* SAMPLE DATA: N/A
	*/
	function account_get()
	{
		if(!$this->get('username') || !$this->get('password')) {
			$this->response(array('success' => false, 'error' => 'Invalid username/password!'), 400);
		}
		
		$username = $this->get('username');
		$password = $this->get('password');

		try {
			$token = $this->Tenants_model->login_tenant($username, $password);
		}
		catch(Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		if($token) {
			$this->response($token, 200);
		}
		else {
			$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
		} 
	}
}
