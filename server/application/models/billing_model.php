<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Billing_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    //Log Tenant Transaction
    function tenant_tranasaction($tenantid, $orgid, $email, $date) {
    	$results = FALSE;

    	//Get tenant transation data for current date
        $this->db->select('TransactionID, NoTransactions');
        $query = $this->db->get_where('TenantBilling', array('TenantID' => $tenantid, 'Date' => $date));
        if($this->get_db_data($query)) {
        	//Update billing table transaction count for that data
        	$this->db->where('TransactionID', $query->row()->TransactionID);
        	$transac = $query->row()->NoTransactions + 1;
        	$data = array('NoTransactions' => $transac);
        	$query = $this->db->update('TenantBilling', $data); //set tenant log status to closed
        	if($query) $results = TRUE;
        }
        else {
        	$row['TenantID'] = $tenantid;
        	$row['OrgID'] = $orgid;
        	$row['Email'] = $email;
        	$row['Date'] = $date;
        	$row['NoTransactions'] = 1;
        	$query = $this->db->insert('TenantBilling', $row);
        	if($query) $results = TRUE;
        }
        return $results;
    }

    //Report Tenant Monthly Fee (Current Month)
    //$start_date - first day in month
    //$end_date - current date
    function tenant_monthly_bill($tenantid, $email, $start_date, $end_date) {
    	//Get tenant transation data for current month
        $this->db->select('NoTransactions, Date');
        $this->db->from('TenantBilling');
        $this->db->where('TenantID =', $tenantid);
        $this->db->where('Date >=', $start_date);
        $this->db->where('Date <=', $end_date);
        $query = $this->db->get();
        if($query) return $query->result();
    }

    //Check if query returns rows
    private function get_db_data($query)
    {
        //echo $query->num_rows;
        //return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
        return ($query->num_rows() > 0);

    }
}