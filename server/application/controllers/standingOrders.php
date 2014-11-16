<?php defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

class StandingOrders extends REST_Controller {
	// Create IOrders object by connecting to Soap API
	public function standingOrdersService() {
		try {
			$clientApplication = @new SoapClient(AkiService."IStandingOrders",
								      array('trace' => 1,
									        'exceptions' => 1
								           )
							         );
		}
		catch (Exception $e) {
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		return $clientApplication;
	}

	/*
	| C - post
	| R - get
	| U - put
	| D - delete
	*/

	/**
	 * orders CRUD
	 * http://64.28.139.185/AkiAppsServices/wsdl/IStandingOrders
	 * GetStandingOrders(string licence, int CustID)
	 * URL: /standingOrders/orders/custid/<custid>
	 */
	function orders_post() {
		$this->response("Only GET method is valid", 405);
	}

	function orders_get() {
		if (!$this->get('custid')) {
			$this->response(NULL, 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$orders = $standingOrdersObject->GetStandingOrders(
							LICENCE,
							$this->get('custid')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (isset($orders)) {
			$this->response($orders, 200);
		}
		else{
       		$this->response(array('success' => false, 'error' => 'No data found!'), 404);
		}
	}

	function orders_put() {
		$this->response("Only GET method is valid", 405);
	}

	function orders_delete() {
		$this->response("Only GET method is valid", 405);
	}

	/**
	 * order CRUD
	 * http://64.28.139.185/AkiAppsServices/wsdl/IStandingOrders
	 *
	 * insertNewStandingOrder(string licence, int custno)
	 * URL: /standingOrders/order/custno/<custno>
	 *
	 * GetStandingOrderDetails(string licence, int CustID, int OrderID)
	 * URL: /standingOrders/order/custid/<custid>/orderid/<orderid>
	 *
	 * removeStandingOrder(string licence, int orderno)
	 * URL: /removeStandingOrder/order/orderno/<orderno>
	 */
	function order_post() {
		if (!$this->post('custno')) {
			$this->response("'custno' parameter missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$newInsertion = $standingOrdersObject->insertNewStandingOrder(
							LICENCE,
							$this->post('custno')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (!is_null($newInsertion)) {
			$this->response($newInsertion, 201);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	function order_get() {
		if (!$this->get('custid') || !$this->get('orderid')) {
			$this->response(NULL, 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$order = $standingOrdersObject->GetStandingOrderDetails(
							LICENCE,
							$this->get('custid'),
							$this->get('orderid')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if ($order) {
			$this->response($order, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	function order_put() {
		$this->response("Only POST, GET and DELETE methods are valid", 405);
	}

	function order_delete() {
		if (!$this->get('orderno')) {
			$this->response("'custno' parameter missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$newInsertion = $standingOrdersObject->removeStandingOrder(
							LICENCE,
							$this->get('orderno')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (!is_null($newInsertion)) {
			$this->response($newInsertion, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	/**
	 * item CRUD
	 * http://64.28.139.185/AkiAppsServices/wsdl/IStandingOrders
	 *
	 * insertItemInToStandingOrder(string licence, string partno, int orderno)
	 * URL: /standingOrders/item
	 * sample json: {"partno":"5","orderno":5}
	 *
	 * changeItemDetails(string licence, int orderID, int itemno, string partid, double packschanged)
	 * URL: /standingOrders/item/orderid/<orderid>/itemno/<itemno>/partid/<partid>/packschanged/<packschanged>
	 * sample json: {"orderid":5,"itemno":6,"partid":6,"packschanged":7}
	 *
	 * deleteItemsFromStandingOrder(string licence, string partno, int orderno)
	 * URL: /removeStandingOrder/item/partno/<partno>/orderno/<orderno>
	 */
	function item_post() {
		if (!$this->post('partno') || !$this->post('orderno')) {
			$this->response("parameters missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$insertItem = $standingOrdersObject->insertItemInToStandingOrder(
							LICENCE,
							$this->post('partno'),
							$this->post('orderno')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (!is_null($insertItem)) {
			$this->response($insertItem, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	function item_get() {
		$this->response("Only POST, PUT and DELETE methods are valid", 405);
	}

	function item_put() {
		if (!$this->put('orderid')
			|| !$this->put('itemno')
			|| !$this->put('partid')
			|| !$this->put('packschanged')) {
			$this->response("parameters missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$changeItem = $standingOrdersObject->changeItemDetails(
							LICENCE,
							$this->put('orderid'),
							$this->put('itemno'),
							$this->put('partid'),
							$this->put('packschanged')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (!is_null($changeItem)) {
			$this->response($changeItem, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	function item_delete() {
		if (!$this->get('partno') || !$this->get('orderno')) {
			$this->response("parameters missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$deleteItem = $standingOrdersObject->deleteItemsFromStandingOrder(
							LICENCE,
							$this->get('partno'),
							$this->get('orderno')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if (!is_null($deleteItem)) {
			$this->response($deleteItem, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	/**
	 * totals CRUD
	 * http://64.28.139.185/AkiAppsServices/wsdl/IStandingOrders
	 * calculateStandingOrderTotals(string licence, int orderno)
	 * URL: /standingOrders/totals/orderno/<orderno>
	 */
	function totals_post() {
		$this->response("Only GET method is valid", 405);
	}

	function totals_get() {
		if (!$this->get('orderno')) {
			$this->response("'orderno' parameter missing", 400);
		}

		$standingOrdersObject = StandingOrders::standingOrdersService();

		try {
			$totals = $standingOrdersObject->calculateStandingOrderTotals(
							LICENCE,
							$this->get('orderno')
						);
		} catch (SoapFault $soapFault) {
			var_dump($soapFault);
			echo "Request :<br>", htmlentities($standingOrdersObject->__getLastRequest()), "<br>";
			echo "Response :<br>", htmlentities($standingOrdersObject->__getLastResponse()), "<br>";
		}

		if ($totals) {
			$this->response($totals, 200);
		}
		else {
			$this->response(NULL, 500);
		}
	}

	function totals_put() {
		$this->response("Only GET method is valid", 405);
	}

	function totals_delete() {
		$this->response("Only GET method is valid", 405);
	}
}