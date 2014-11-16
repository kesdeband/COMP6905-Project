<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Authentication extends REST_Controller {

	public function getServiceAuthenticator() {
		// Create IAuthentication object by connecting to API
		try{
			$authentication = @new SoapClient(AKIservice."IAuthentication",
								              array('trace' => TRUE,
									                'exceptions' => 0
								                   )
							                 );
		}
		catch(Exception $e){
			echo $e->getMessage();
		}

		return $authentication;
	}

	/*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	 * authenticate CRUD
	 * http://64.28.139.185/AkiBakeryServices/wsdl/IAuthentication
	 * authenticateUser(string licence, string username, string password)
	 * URL: /authenticate/token/username/<username>/password/<password>
	 */

	function token_post() {
		$this->response(NULL, 405);
	}

	function token_get(){

		if($this->get('username') && $this->get('password')){
			$username = $this->get('username');
			$password = $this->get('password');
			$authen_object = Authentication::getServiceAuthenticator();

			try{
				$token = $authen_object->authenticateUser(LICENCE, $username, $password);
			}
			catch(Exception $e){
				echo $e->getMessage();
			}

			if($token == 1){
        		$this->response(array('token' => $token), 200);
       		}
       		else{
       			$this->response(array('token' => NULL), 200);
       		}
		}
		else
		{
            $this->response(array('success'=>false, 'error'=>'User username/password/licence is missing/invalid'), 400);
        }
	}

	function token_put() {
		$this->response(NULL, 405);
	}

	function token_delete() {
		$this->response(NULL, 405);
	}
}