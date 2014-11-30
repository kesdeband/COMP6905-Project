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
	* CRUD: company
	* HTTP METHOD: POST
	* MODEL FUNCTION: create_org_tenant($orgname, $email, $industry, $numusers)
	* URL: localhost/cloud/server/index.php/api/tenants/company
	* SAMPLE DATA: {"orgname":"Petrotrin","email":"oil@petrotrin.com","industry":"Vehicle Dealer","numusers":5}
	*/
	function company_post() 
	{
		if(!$this->post('orgname') || !$this->post('email') || !$this->post('industry') || !$this->post('numusers')) {
			$this->response("Username or password missing", 400);
		}

		$exists = $this->Tenants_model->company_exists($this->post('email'));

		if($exists) {
			$this->response("Company already exists", 400);
		}
		else {
			$tenantid = strtotime("now");
			$dor = date("Y-m-d");
			$created = $this->Tenants_model->create_org_tenant(
					$tenantid,
					$this->post('orgname'),
					$this->post('email'),
					$this->post('industry'),
					$this->post('numusers'),
					$dor);

			if ($created) //Registration successful, user created
			{
				$this->response(array('created' => $created, 'key' => $tenantid), 201); 
			}
			else //An error occured on the server end
			{	
				$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
			}
		}
	}


	/**
	* CRUD: account
	* HTTP METHOD: POST
	* MODEL FUNCTION: create_tenant($tenantid, $fname, $lname, $company, $username, $password)
	* URL: localhost/cloud/server/index.php/api/tenants/account
	* SAMPLE DATA: {"fname":"Keston","lname":"Joseph","orgid":8753759,"username":"Kes","password":"Kes","country":"Aruba"}
	*/
	function account_post() 
	{
		if(!$this->post('fname') || !$this->post('lname') || !$this->post('username') || !$this->post('password') || !$this->post('country')
			|| !$this->post('orgid')) {
			$this->response("Username or password missing", 400);
		}

		$exists = $this->Tenants_model->tenant_exists($this->post('username'));

		if($exists) {
			$this->response("Tenant already exists", 400);
		}
		else {
			$tenantid = strtotime("now");
			$dor = date("Y-m-d");
			$created = $this->Tenants_model->create_tenant(
					$tenantid,
					$this->post('fname'),
					$this->post('lname'),
					$this->post('orgid'),
					$this->post('username'),
					$this->post('password'),
					$dor,
					$this->post('country'));

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


	/**
	* CRUD: account
	* HTTP METHOD: PUT
	* MODEL FUNCTION: logout_tenant($token)
	* URL: localhost/cloud/server/index.php/api/tenants/account
	* SAMPLE DATA: {"token":"e898e568c22fcddaffa5bfb81f186086af053d7"}
	*/
	function account_put()
	{
		if($this->put('token')) {

			try {
				$logout = $this->Tenants_model->logout_tenant($this->put('token'));
			}
			catch(Exception $e) {
				echo "Caught exception: ",  $e->getMessage(), "<br>";
			}

			if($logout) {
				$this->response(array('logout' => $logout), 200);
			}
			else {
				$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
			}
		}
		else {
			$this->response(array('success'=>false, 'error' => 'User not logged-in!'), 400);
		}
	}
}
