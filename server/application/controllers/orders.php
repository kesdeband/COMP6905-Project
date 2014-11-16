<?php defined('BASEPATH') OR exit('No direct script access allowed');

require APPPATH.'/libraries/REST_Controller.php';

class Orders extends REST_Controller {

	public function ordersService() {
		// Create IOrders object by connecting to Soap API
		try{
			$orders = @new SoapClient(AkiService."IOrders",
								      array('trace' => 1,
									        'exceptions' => 1
								           )
							         );
		}
		catch(Exception $e){
			echo "Caught exception: ",  $e->getMessage(), "<br>";
		}

		return $orders;
	}

	/*
	| C - post
	| R - get
	| U - put
	| D - delete
	| 
	| http://64.28.139.185/AkiBakeryServices/wsdl/IOrders
	*/

	/** Start of ordersdetail **/

	/**
	* PostOrders(string licence, string standingOrder_day)
	* URL: /orders/ordersdetail/standingorderday/<day>
	**/

	function ordersdetail_post() {

		if($this->post('standingorderday')){

			$standingorderday = $this->post('standingorderday');
			$orders_object = Orders::ordersService();

			try{
				$ordersdetail = $orders_object->PostOrders(LICENCE, $standingorderday);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}
			
			if(isset($ordersdetail)){
				$this->response($ordersdetail, 200);
			}
			else{
				$this->response(array('success' => false, 'error' => 'No data found!'), 404);
			}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Oders standingorderday is missing/invalid'), 400);
		}
	}

	/**
	* GetOrders(string licence, int CustID)
	* URL: /orders/ordersdetail/custid/<custid>
	**/

	function ordersdetail_get() {

		if($this->get('custid')){

			$custid = $this->get('custid');
			$orders_object = Orders::ordersService();

			try{
				$ordersdetail = $orders_object->GetOrders(LICENCE, $custid);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($ordersdetail)){
        		$this->response($ordersdetail, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
            $this->response(array('success'=>false, 'error'=>'Oders custid is missing/invalid'), 400);
        }
	}

	/**
	* changeDateforOrders(string licence, string standingOrder_day, string production_date)
	* URL: /orders/ordersdetail/standingorderday/<day>/productiondate/<date>
	**/

	function ordersdetail_put() {
		
		if($this->put('standingorderday') && $this->put('productiondate')){

			$standingorderday = $this->put('standingorderday');
			$productiondate = $this->put('productiondate');
			$orders_object = Orders::ordersService();

			try{
				$ordersdetail = $orders_object->changeDateforOrders(LICENCE, $standingorderday, $productiondate);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($ordersdetail)){
        		$this->response($ordersdetail, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order standingorderday/productiondate is missing/invalid'), 400);
		}
	}

	/**
	* deleteAllOrdersForDay(string licence, string production_day)
	* URL: /orders/ordersdetail/productionday/<productionday>
	**/

	function ordersdetail_delete() {
		
		if($this->get('productionday')){

			$productionday = $this->get('productionday');
			$orders_object = Orders::ordersService();

			try{
				$ordersdetail = $orders_object->deleteAllOrdersForDay(LICENCE, $productionday);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($ordersdetail)){
        		$this->response($ordersdetail, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order productionday is missing/invalid'), 400);
		}
	}

	/** End of ordersdetail **/

	/** Start of orderdetail **/

	/**
	* insertNewOrder(string licence, int custno)
	* URL: /orders/orderdetail/custno/<custno>
	**/

	function orderdetail_post() {
		
		if($this->post('custno')){

			$custno = $this->post('custno');
			$orders_object = Orders::ordersService();

			try{
				$orderdetail = $orders_object->insertNewOrder(LICENCE, $custno);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($orderdetail)){
        		$this->response($orderdetail, 201);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order custno is missing/invalid'), 400);
		}
	}

	/**
	 * SearchOrder(string licence, int OrderID)
	 * URL: /orders/orderdetail/orderid/<orderid>
	 **/

	function orderdetail_get() {

		if($this->get('orderid')){

			$orderid = $this->get('orderid');
			$orders_object = Orders::ordersService();

			try{
				$orderdetail = $orders_object->SearchOrder(LICENCE, $orderid);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($orderdetail)){
        		$this->response($orderdetail, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order orderid is missing/invalid'), 400);
		}
	}

	function orderdetail_put() {
		$this->response(array('information' => 'Only POST, GET and DELETE methods available on resource!'), 405);
	}

	/**
	* removeOrder(string licence, int orderno)
	* URL: /orders/orderdetail/orderno/<orderno>
	**/

	function orderdetail_delete() {
		
		if($this->get('orderno')){

			$orderno = $this->get('orderno');
			$orders_object = Orders::ordersService();

			try{
				$orderdetail = $orders_object->removeOrder(LICENCE, $orderno);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($orderdetail)){
        		$this->response($orderdetail, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order orderno is missing/invalid'), 400);
		}
	}

	/** End of orderdetail **/


	/** Start of details **/

	/**
	* adddetails(string licence, int orderID, string productid, double packs)
	* URL: /orders/details/orderid/<orderid>/productid/<productid>/packs/<packs>
	**/

	function details_post() {
		
		if($this->post('orderid') && $this->post('productid') && $this->post('packs')){

			$orderid = $this->post('orderid');
			$productid = $this->post('productid');
			$packs = $this->post('packs');
			$orders_object = Orders::ordersService();

			try{
				$details = $orders_object->adddetails(LICENCE, $orderid, $productid, $packs);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($details)){
        		$this->response($details, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order orderid/productid/packs is missing/invalid'), 400);
		}
	}

	/**
	 * GetOrderDetails(string licence, int CustID, int OrderID)
	 * URL: /orders/details/custid/<custid>/orderid/<orderid>
	 **/
	function details_get() {

		if($this->get('custid') && $this->get('orderid')){

			$custid = $this->get('custid');
			$orderid = $this->get('orderid');
			$orders_object = Orders::ordersService();

			try{
				$details = $orders_object->GetOrderDetails(LICENCE, $custid, $orderid);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($details)){
        		$this->response($details, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order custid/orderid is missing/invalid'), 400);
		}
	}

	/**
	* changedetails(string licence, int orderID, int itemno, string productid, string status, double packschanged)
	* URL: /orders/details/orderid/<orderid>/itemno/<itemno>/productid/<productid>/status/<status>/packschanged/<packschanged>
	**/

	function details_put() {
		
		if($this->put('orderid') && $this->put('itemno') && $this->put('productid') && $this->put('status') && $this->put('packschanged')){

			$orderid = $this->put('orderid');
			$itemno = $this->put('itemno');
			$productid = $this->put('productid');
			$status = $this->put('status');
			$packschanged = $this->put('packschanged');
			$orders_object = Orders::ordersService();

			try{
				$details = $orders_object->changedetails(LICENCE, $orderid, $itemno, $productid, $status, $packschanged);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($details)){
        		$this->response($details, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order orderid/itemno/productid/status is missing/invalid'), 400);
		}
	}

	function details_delete() {
		$this->response(array('information' => 'Only POST, GET and DELETE methods available on resource!'), 405);
	}

	/** End of details **/


	/** Start of production **/

	/**
	* produceOrders(string licence, string standingOrder_day, string production_date)
	* URL: /orders/production/standingorderday/<standingorderday>/productiondate/<productiondate>
	**/

	function production_post() {
		
		if($this->post('standingorderday') && $this->post('productiondate')){

			$standingorderday = $this->post('standingorderday');
			$productiondate = $this->post('productiondate');
			$orders_object = Orders::ordersService();

			try{
				$production = $orders_object->produceOrders(LICENCE, $standingorderday, $productiondate);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($production)){
        		$this->response($production, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order standingorderday/productiondate is missing/invalid'), 400);
		}
	}

	function production_get() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function production_put() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function production_delete() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	/** End of production **/


	/** Start of productionselection **/

	/**
	* produceSelectedOrder(string licence, string production_date, int orderid)
	* URL: /orders/productionselection/productiondate/<productiondate>/orderid/<orderid>
	**/

	function productionselection_post() {
		
		if($this->post('productiondate') && $this->post('orderid')){

			$productiondate = $this->post('productiondate');
			$orderid = $this->post('orderid');
			$orders_object = Orders::ordersService();

			try{
				$productionselection = $orders_object->produceSelectedOrder(LICENCE, $productiondate, $orderid);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($productionselection)){
        		$this->response($productionselection, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order productiondate/orderid is missing/invalid'), 400);
		}
	}

	function productionselection_get() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionselection_put() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionselection_delete() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	/** End of productionselection **/


	/** Start of deletionitemsstandingorders **/

	function deletionitemsstandingorders_post() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsstandingorders_get() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsstandingorders_put() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	/**
	 * deleteItemsFromStandingOrders(string licence, string partno)
	 * URL: /orders/deletionitemsstandingorders/partno/<partno>
	 **/

	function deletionitemsstandingorders_delete() {
		
		if($this->get('partno')){

			$partno = $this->get('partno');
			$orders_object = Orders::ordersService();

			try{
				$deletionitemsstandingorders = $orders_object->deleteItemsFromStandingOrders(LICENCE, $partno);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($deletionitemsstandingorders)){
        		$this->response($deletionitemsstandingorders, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order partno is missing/invalid'), 400);
		}
	}

	/** End of deletionitemsstandingorders **/


	/** Start of deletionitemsorders **/

	function deletionitemsorders_post() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsorders_get() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsorders_put() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	/**
	 * deleteItemsFromOrders(string licence, string partno, string standing_day)
	 * URL: /orders/deletionitemsorders/partno/<partno>/standingday/<standingday>
	 **/

	function deletionitemsorders_delete() {
		
		if($this->get('partno') && $this->get('standingday')){

			$partno = $this->get('partno');
			$standingday = $this->get('standingday');
			$orders_object = Orders::ordersService();

			try{
				$deletionitemsorders = $orders_object->deleteItemsFromOrders(LICENCE, $partno, $standingday);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($deletionitemsorders)){
        		$this->response($deletionitemsorders, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order partno/standingday is missing/invalid'), 400);
		}
	}

	/** End of deletionitemsorders **/


	/** Start of developmentproduction **/

	/**
	 * MakeProductionOrders(string licence, string standingOrder_day)
	 * URL: /orders/developmentproduction/standingorderday/<standingorderay>
	 **/

	function developmentproduction_post() {
		
		if($this->post('standingorderday')){

			$standingorderday = $this->post('standingorderday');
			$orders_object = Orders::ordersService();

			try{
				$developmentproduction = $orders_object->MakeProductionOrders(LICENCE, $standingorderday);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($developmentproduction)){
        		$this->response($developmentproduction, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order standingorderday is missing/invalid'), 400);
		}
	}

	function developmentproduction_get() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function developmentproduction_put() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function developmentproduction_delete() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	/** End of developmentproduction **/


	/** Start of deletionitemorder **/

	function deletionitemorder_post() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemorder_get() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemorder_put() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	/**
	 * DeleteSingleItemFromOrder(string licence, string partno, int orderno)
	 * URL: /orders/deletionitemorder/partno/<partno>/orderno/<orderno>
	 **/

	function deletionitemorder_delete() {
		
		if($this->get('partno') && $this->get('orderno')){

			$partno = $this->get('partno');
			$orderno = $this->get('orderno');
			$orders_object = Orders::ordersService();

			try{
				$deletionitemorder = $orders_object->DeleteSingleItemFromOrder(LICENCE, $partno, $orderno);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($deletionitemorder)){
        		$this->response($deletionitemorder, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order partno/orderno is missing/invalid'), 400);
		}	
	}

	/** End of deletionitemorder **/


	/** Start of productionfinishgoodsinvoice **/

	/**
	* ProduceFinishGoodsInvoice(string licence, string production_date, int orderno, int productionid)
	* URL: /orders/productionfinishgoodsinvoice/productiondate/<productiondate>/orderno/<orderno>/productionid/<productionid>
	**/

	function productionfinishgoodsinvoice_post() {
		
		if($this->post('productiondate') && $this->post('orderno') && $this->post('productionid')){

			$productiondate = $this->post('productiondate');
			$orderno = $this->post('orderno');
			$productionid = $this->post('productionid');
			$orders_object = Orders::ordersService();

			try{
				$productionfinishgoodsinvoice = $orders_object->ProduceFinishGoodsInvoice(LICENCE, $productiondate, $orderno, $productionid);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($productionfinishgoodsinvoice)){
        		$this->response($productionfinishgoodsinvoice, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order productiondate/orderno/productionid is missing/invalid'), 400);
		}
	}

	function productionfinishgoodsinvoice_get() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionfinishgoodsinvoice_put() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionfinishgoodsinvoice_delete() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	/** End of productionfinishgoodsinvoice **/


	/** Start of productionordersreadytopost **/

	/**
	 * MakeOrdersReadyToPost(string licence, string standingOrder_day)
	 * URL: /orders/productionordersreadytopost/standingorderday/<standingorderday>
	 **/

	function productionordersreadytopost_post() {
		
		if($this->post('standingorderday')){

			$standingorderday = $this->post('standingorderday');
			$orders_object = Orders::ordersService();

			try{
				$productionordersreadytopost = $orders_object->MakeOrdersReadyToPost(LICENCE, $standingorderday);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($productionordersreadytopost)){
        		$this->response($productionordersreadytopost, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order standingorderday is missing/invalid'), 400);
		}
	}

	function productionordersreadytopost_get() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionordersreadytopost_put() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	function productionordersreadytopost_delete() {
		$this->response(array('information' => 'Only POST method available on resource!'), 405);
	}

	/** End of productionordersreadytopost **/


	/** Start of deletionitemsforgivenorder **/

	function deletionitemsforgivenorder_post() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsforgivenorder_get() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	function deletionitemsforgivenorder_put() {
		$this->response(array('information' => 'Only DELETE method available on resource!'), 405);
	}

	/**
	* deleteItemsForGivenOrder(string licence, int orderno)
	* URL: /orders/deletionitemsforgivenorder/orderno/<orderno>
	**/

	function deletionitemsforgivenorder_delete() {
		
		if($this->get('orderno')){

			$orderno = $this->get('orderno');
			$orders_object = Orders::ordersService();

			try{
				$deletionitemsforgivenorder = $orders_object->deleteItemsForGivenOrder(LICENCE, $orderno);
			}
			catch(SoapFault $soapFault){
				var_dump($soapFault);
        		echo "Request :<br>", htmlentities($orders_object->__getLastRequest()), "<br>";
        		echo "Response :<br>", htmlentities($orders_object->__getLastResponse()), "<br>";
			}

			if(isset($deletionitemsforgivenorder)){
        		$this->response($deletionitemsforgivenorder, 200);
       		}
       		else{
       			$this->response(array('success' => false, 'error' => 'No data found!'), 404);
       		}
		}
		else{
			$this->response(array('success'=>false, 'error'=>'Order orderno is missing/invalid'), 400);
		}
	}

	/** End of deletionitemsforgivenorder **/

}