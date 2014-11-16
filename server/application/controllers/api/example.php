<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Example
 *
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array.
 *
 * @package		CodeIgniter
 * @subpackage	Rest Server
 * @category	Controller
 * @author		Phil Sturgeon
 * @link		http://philsturgeon.co.uk/code/
*/

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH.'/libraries/REST_Controller.php';
require APPPATH.'/libraries/vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

class Example extends REST_Controller
{
	private $users;
	
	function __construct() {
        parent::__construct();
		
		// Array containing data for rest service execution
        $this->users = array(
			1 => array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com', 'fact' => 'Loves swimming'),
			2 => array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com', 'fact' => 'Has a huge face'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => 'Is a Scott!', array('hobbies' => array('fartings', 'bikes'))),
			4 => array('id' => 4, 'name' => 'Kes Bugs', 'email' => 'bugs@hotmail.com', 'fact' => 'Loves Programming'),
		);
    }

	function user_get()
    {

    	// Create table REST proxy.
	$connectionString = "DefaultEndpointsProtocol=https;AccountName=bitnamieastus5213449027;AccountKey=6B6j0Nw7g/cMNNWhjwUrVNVJU3jwzI2t9twlrMtArNBstn9ofpzGVq+hKLn0jE7T6Ntq+kPwaOVqpkPD9aLuOQ==";
	$tableRestProxy = ServicesBuilder::getInstance()->createTableService($connectionString);

	try {
		// Create table.
		$tableRestProxy->createTable("test");
	}
	catch(ServiceException $e){
		$code = $e->getCode();
		$error_message = $e->getMessage();
		// Handle exception based on error codes and messages.
		// Error codes and messages can be found here: 
		// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
	}
    	
        /*if(!$this->get('id'))
        {
        	$this->response(array('success' => false, 'error' => 'User Id Invalid or missing!'), 400);
        }

        // $user = $this->some_model->getSomething( $this->get('id') );
    	
    	$user = @$this->users[$this->get('id')];
    	
        if($user)
        {
            $this->response($user, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'User could not be found'), 404);
        }*/
    }
    
    function user_post()
    {
		if(!$this->post('id') || !$this->post('name') || !$this->post('email'))
        {
        	$this->response(NULL, 400);
        }
		
        //$this->some_model->updateUser( $this->get('id') );
        $message = array('id' => $this->post('id'), 'name' => $this->post('name'), 'email' => $this->post('email'), 'message' => 'ADDED!');
        if(isset($message)) {
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response("error", 500); // 200 being the HTTP response code
		}
    }
    
    function user_delete($id = null)
    {
    	//$this->some_model->deletesomething( $this->get('id') );
		if(isset($id)) {
			$message = array('id' => $id, 'message' => 'DELETED!');
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response(array('success' => false, 'error' => 'Id missing or invalid'), 400);
		}
    }
    
    function users_get()
    {
        //$users = $this->some_model->getSomething( $this->get('limit') );
        /*$users = array(
			array('id' => 1, 'name' => 'Some Guy', 'email' => 'example1@example.com'),
			array('id' => 2, 'name' => 'Person Face', 'email' => 'example2@example.com'),
			3 => array('id' => 3, 'name' => 'Scotty', 'email' => 'example3@example.com', 'fact' => array('hobbies' => array('fartings', 'bikes'))),
		);*/
        
        if($this->users)
        {
            $this->response($this->users, 200); // 200 being the HTTP response code
        }
        else
        {
            $this->response(array('error' => 'Couldn\'t find any users!'), 404);
        }
    }
	
	function user_put()
	{
		if(!$this->put('id') || !$this->put('name') || !$this->put('email'))
        {
        	$this->response(NULL, 400);
        }
		
		$message = array('id' => $this->put('id'), 'name' => $this->put('name'), 'email' => $this->put('email'), 'message' => 'USER UPDATED!');
		if(isset($message)) {
			$this->response($message, 200); // 200 being the HTTP response code
		}
		else {
			$this->response("error", 500); // 200 being the HTTP response code
		}
	}


	public function send_post()
	{
		var_dump($this->request->body);
	}


	public function send_put()
	{
		var_dump($this->put('foo'));
	}
}