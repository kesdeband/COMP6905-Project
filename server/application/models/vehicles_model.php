<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/vendor/autoload.php';

use WindowsAzure\Common\ServicesBuilder;
use WindowsAzure\Common\ServiceException;

class Vehicles_model extends CI_Model {

	private $_connStringTable;
	private $_tableRestProxy;

    function __construct() {
        parent::__construct();
        $this->_connStringTable = connectionTable;
        //Create table REST proxy.
		$this->_tableRestProxy = ServicesBuilder::getInstance()->createTableService($this->_connStringTable);
    }

    function retrieve_vehicle_info($registrationNo, $country, $usertype) {
        $arr = null;
    	try {
    		$result = $this->_tableRestProxy->getEntity("Vehicle", $country, $registrationNo);
		}
		catch(ServiceException $e){
    		// Handle exception based on error codes and messages.
    		// Error codes and messages are here: 
    		// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
    		$code = $e->getCode();
    		$error_message = $e->getMessage();
    		echo $code.": ".$error_message."<br />";
		}
		if($result) {
            $entity = $result->getEntity();
            if(strcmp($usertype, "Basic") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             'color' => $entity->getProperty("Color")->getValue(),
                             'make' => $entity->getProperty("Make")->getValue(),
                             'model' => $entity->getProperty("Model")->getValue()/*,
                             'owner' => $entity->getProperty("Owner")->getValue(),
                             'year' => $entity->getProperty("Year")->getValue()*/
                            );
            }

            if(strcmp($usertype, "Insurance") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             /*'color' => $entity->getProperty("Color")->getValue(),
                             'make' => $entity->getProperty("Make")->getValue(),
                             'model' => $entity->getProperty("Model")->getValue(),
                             'owner' => $entity->getProperty("Owner")->getValue(),*/
                             'year' => $entity->getProperty("Year")->getValue()
                            );
            }

            if(strcmp($usertype, "Security") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             'color' => $entity->getProperty("Color")->getValue(),
                             'make' => $entity->getProperty("Make")->getValue(),
                             'model' => $entity->getProperty("Model")->getValue(),
                             'owner' => $entity->getProperty("Owner")->getValue(),
                             'year' => $entity->getProperty("Year")->getValue()
                            );
            }

            if(strcmp($usertype, "Dealer") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             'color' => $entity->getProperty("Color")->getValue(),
                             /*'make' => $entity->getProperty("Make")->getValue(),*/
                             'model' => $entity->getProperty("Model")->getValue(),
                             'owner' => $entity->getProperty("Owner")->getValue(),
                             'year' => $entity->getProperty("Year")->getValue()
                            );
            }
            
        //return $result->getEntity()->getProperty("Color")->getValue();
		//return $entity->getPartitionKey();
		//return $result->getEntity()->getPartitionKey();
		//return $result->getEntity()->getPropertyValues();
        }
        return $arr;
    }

}