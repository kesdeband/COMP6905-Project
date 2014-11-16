<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Customers extends REST_Controller {
//class Customers extends CI_Controller {

   /* public function index() {
        $this->load->model('Customers_model', '', TRUE);

        $data['query'] = $this->Customers_model->get_all_rows();

        $this->load->view('test', $data);
    }*/

	/*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	 * account CRUD
	 * URL: /customers/account/username/<username>/password/<password>
	 */
	function account_post() {
		
        $this->load->model('Customers_model', '', TRUE);

		if(!$this->post('username') || !$this->post('password')) {
			$this->response("Username or password missing", 400);
		}

		$exists = $this->Customers_model->customer_exists($this->post('username'));

		if($exists) {
			$this->response("Customer already exists", 400);
		}
		else {
			$created = $this->Customers_model->create_customer(
					$this->post('username'),
					$this->post('password'));
			if (isset($created)) {
				$this->response($created, 201);
			}
			else {
				$this->response(NULL, 500);
			}
		}
	}

	/**
	 * createToken(username, password)
	 * URL: /customers/account/username/<username>/password/<password>
	 */

	function account_get() {

		$this->load->model('Customers_model', '', TRUE);
		
		if($this->get('username') && $this->get('password')) {
			$username = $this->get('username');
			$password = $this->get('password');

			try {
				$token = $this->Customers_model->login_customer($username, $password);
			}
			catch(Exception $e) {
				echo "Caught exception: ",  $e->getMessage(), "<br>";
			}

			if(isset($token)) {
				$this->response($token, 200);
			}
			else {
				$this->response(array('success' => false, 'error' => 'No data found!'), 404);
			}
		}
		else {
			$this->response(array('success'=>false, 'error'=>'Invalid username/password!'), 400);
		} 
	}

	function account_put() {
		$this->response("Only POST method is valid", 405);
	}

	function account_delete() {
		$this->response("Only POST method is valid", 405);
	}
}
