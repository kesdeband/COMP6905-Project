<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Billing extends REST_Controller {

	//Load models and helper classes in contructor to be used in Vehicles class
	function __construct() {
        parent::__construct();
        $this->load->model('Billing_model', '', TRUE);
        //$this->load->helper('cookie');
    }

    /*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	* CRUD: transaction
	* HTTP METHOD: POST
	* MODEL FUNCTION: tenant_tranasaction($tenantid, $orgid, $email, $date)
	* URL: localhost/cloud/server/index.php/api/billing/transaction/
	* SAMPLE DATA: {"tenantid":57733494,"orgid":3547574,"email":"bugs_626@hotmail.com"}
	*/
	function transaction_post() 
	{
		if(!$this->post('tenantid') || !$this->post('orgid') || !$this->post('email')) {
			$this->response(array('success' => false, 'error' => 'Invalid Credentails!'), 400);
		}

		$date = date("Y-m-d");

		try {
			$transaction = $this->Billing_model->tenant_tranasaction($this->post('tenantid'), $this->post('orgid'), $this->post('email'),
				$date);
		}
		catch(Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		if($transaction) {
			$this->response($transaction, 200);
		}
		else {
			$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
		} 
	}

	/**
	* CRUD: transaction
	* HTTP METHOD: GET
	* MODEL FUNCTION: tenant_monthly_bill($tenantid, $email, $start_date, $end_date)
	* URL: localhost/cloud/server/index.php/api/billing/transaction/tenantid/<tenantid>/email/<email>
	* SAMPLE DATA: N/A
	*/
	function transaction_get() 
	{
		if(!$this->get('tenantid') || !$this->get('email')) {
			$this->response(array('success' => false, 'error' => 'Invalid Credentails!'), 400);
		}

		$start_date = date("Y-m-01");
		$end_date = date("Y-m-d");

		try {
			$transactions = $this->Billing_model->tenant_monthly_bill($this->get('tenantid'), $this->get('email'),
				$start_date, $end_date);
		}
		catch(Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		if($transactions) {
			$total = 0;
			$size = count($transactions);
			for ($i=0; $i < $size; $i++) { 
				$total += $transactions[$i]->NoTransactions;
			}
			//$this->response(array('total' => $total), 200);
			$this->response(array('bill' => $transactions, 'total' => $total, 'size' => $size), 200);
		}
		else {
			$this->response(array('success' => false, 'error' => 'Internal Server Error'), 500);
		} 
	}

}