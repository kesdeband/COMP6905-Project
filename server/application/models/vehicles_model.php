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
        $result = null;
    	try {
    		$result = $this->_tableRestProxy->getEntity("Vehicle", $country, $registrationNo);
		}
		catch(ServiceException $e){
    		// Handle exception based on error codes and messages.
    		// Error codes and messages are here: 
    		// http://msdn.microsoft.com/en-us/library/windowsazure/dd179438.aspx
    		$code = $e->getCode();
    		//$error_message = $e->getMessage();
    		$arr = $code; /*.": ".$error_message."<br />";*/
		}
		if($result) {
            $entity = $result->getEntity();
            if(strcmp($usertype, "Basic") === 0) {
                $arr = array('owner' => $entity->getProperty("Owner")->getValue(),
                             'age' => $entity->getProperty("Age")->getValue(),
                             'address' => $entity->getProperty("Address")->getValue(),
                             'permitno' => $entity->getProperty("DriverPermit")->getValue(),
                             'gender' => $entity->getProperty("Gender")->getValue(),
                             'ethnicity' => $entity->getProperty("Race")->getValue(),
                             'permitissuedate' => $entity->getProperty("DateIssued")->getValue(),
                             'dob' => $entity->getProperty("DateOfBirth")->getValue(),
                             'height' => $entity->getProperty("Height")->getValue(),
                             'occupation' => $entity->getProperty("Occupation")->getValue(),
                             'weight' => $entity->getProperty("Weightinllbs")->getValue(),
                             'id' => $entity->getProperty("idNumber")->getValue(),
                             'image' => $entity->getProperty("ImageFile")->getValue()
                             //Need to add permit expiry date and Image
                            );
            }

            if(strcmp($usertype, "Insurance") === 0) {
                $arr = array('owner' => $entity->getProperty("Owner")->getValue(),
                             'age' => $entity->getProperty("Age")->getValue(),
                             'address' => $entity->getProperty("Address")->getValue(),
                             'permitno' => $entity->getProperty("DriverPermit")->getValue(),
                             'gender' => $entity->getProperty("Gender")->getValue(),
                             'purchasedate' => $entity->getProperty("DateOFPurchase")->getValue(),
                             'insurancecertificate' => $entity->getProperty("InsuranceCertificateNumber")->getValue(),
                             'insurancename' => $entity->getProperty("InsuranceCompanyName")->getValue(),
                             'insurancetype' => $entity->getProperty("InsuranceType")->getValue(),
                             'ethnicity' => $entity->getProperty("Race")->getValue(),
                             'agent' => $entity->getProperty("Agent")->getValue(),
                             'permitissuedate' => $entity->getProperty("DateIssued")->getValue(),
                             'insuranceissuedate' => $entity->getProperty("InsuranceDateIssued")->getValue(),
                             'dob' => $entity->getProperty("DateOfBirth")->getValue(),
                             'insuranceexpdate' => $entity->getProperty("ExpiryDate")->getValue(),
                             'height' => $entity->getProperty("Height")->getValue(),
                             'mortgage' => $entity->getProperty("Mortgage")->getValue(),
                             'occupation' => $entity->getProperty("Occupation")->getValue(),
                             'weight' => $entity->getProperty("Weightinllbs")->getValue(),
                             'cchp' => $entity->getProperty("ccHP")->getValue(),
                             'id' => $entity->getProperty("idNumber")->getValue(),
                             'image' => $entity->getProperty("ImageFile")->getValue()
                            );
            }

            if(strcmp($usertype, "Dealer") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             'color' => $entity->getProperty("Color")->getValue(),
                             'make' => $entity->getProperty("Make")->getValue(),
                             'model' => $entity->getProperty("Model")->getValue(),
                             'owner' => $entity->getProperty("Owner")->getValue(),
                             'year' => $entity->getProperty("Year")->getValue(),
                             'certificateno' => $entity->getProperty("CertificateNumber")->getValue(),
                             'age' => $entity->getProperty("Age")->getValue(),
                             'address' => $entity->getProperty("Address")->getValue(),
                             'permitno' => $entity->getProperty("DriverPermit")->getValue(),
                             'gender' => $entity->getProperty("Gender")->getValue(),
                             'purchasedate' => $entity->getProperty("DateOFPurchase")->getValue(),
                             'ethnicity' => $entity->getProperty("Race")->getValue(),
                             'bodytype' => $entity->getProperty("BodyType")->getValue(),
                             'permitissuedate' => $entity->getProperty("DateIssued")->getValue(),
                             'dob' => $entity->getProperty("DateOfBirth")->getValue(),
                             'doors' => $entity->getProperty("DoorPlan")->getValue(),
                             'enginesize' => $entity->getProperty("Enginesize")->getValue(),
                             'fueltype' => $entity->getProperty("FuelType")->getValue(),
                             'height' => $entity->getProperty("Height")->getValue(),
                             'occupation' => $entity->getProperty("Occupation")->getValue(),
                             'passengercapacity' => $entity->getProperty("PassengerCapacity")->getValue(),
                             'transmission' => $entity->getProperty("Transmission")->getValue(),
                             'weight' => $entity->getProperty("Weightinllbs")->getValue(),
                             'cchp' => $entity->getProperty("ccHP")->getValue(),
                             'id' => $entity->getProperty("idNumber")->getValue(),
                             'image' => $entity->getProperty("ImageFile")->getValue()
                            );
            }

            if(strcmp($usertype, "Security") === 0) {
                $arr = array('chassisno' => $entity->getProperty("ChassisNumber")->getValue(),
                             'color' => $entity->getProperty("Color")->getValue(),
                             'make' => $entity->getProperty("Make")->getValue(),
                             'model' => $entity->getProperty("Model")->getValue(),
                             'owner' => $entity->getProperty("Owner")->getValue(),
                             'year' => $entity->getProperty("Year")->getValue(),
                             'certificateno' => $entity->getProperty("CertificateNumber")->getValue(),
                             'age' => $entity->getProperty("Age")->getValue(),
                             'address' => $entity->getProperty("Address")->getValue(),
                             'permitno' => $entity->getProperty("DriverPermit")->getValue(),
                             'gender' => $entity->getProperty("Gender")->getValue(),
                             'purchasedate' => $entity->getProperty("DateOFPurchase")->getValue(),
                             'insurancecertificate' => $entity->getProperty("InsuranceCertificateNumber")->getValue(),
                             'insurancename' => $entity->getProperty("InsuranceCompanyName")->getValue(),
                             'insurancetype' => $entity->getProperty("InsuranceType")->getValue(),
                             'ethnicity' => $entity->getProperty("Race")->getValue(),
                             'agent' => $entity->getProperty("Agent")->getValue(),
                             'bodytype' => $entity->getProperty("BodyType")->getValue(),
                             'permitissuedate' => $entity->getProperty("DateIssued")->getValue(),
                             'insuranceissuedate' => $entity->getProperty("InsuranceDateIssued")->getValue(),
                             'dob' => $entity->getProperty("DateOfBirth")->getValue(),
                             'doors' => $entity->getProperty("DoorPlan")->getValue(),
                             'enginesize' => $entity->getProperty("Enginesize")->getValue(),
                             'insuranceexpdate' => $entity->getProperty("ExpiryDate")->getValue(),
                             'fueltype' => $entity->getProperty("FuelType")->getValue(),
                             'height' => $entity->getProperty("Height")->getValue(),
                             'mortgage' => $entity->getProperty("Mortgage")->getValue(),
                             'occupation' => $entity->getProperty("Occupation")->getValue(),
                             'passengercapacity' => $entity->getProperty("PassengerCapacity")->getValue(),
                             'transmission' => $entity->getProperty("Transmission")->getValue(),
                             'weight' => $entity->getProperty("Weightinllbs")->getValue(),
                             'cchp' => $entity->getProperty("ccHP")->getValue(),
                             'id' => $entity->getProperty("idNumber")->getValue(),
                             'image' => $entity->getProperty("ImageFile")->getValue()
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