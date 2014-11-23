<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Tenants_model extends CI_Model {

    private $_siteKey;

    function __construct() {
        parent::__construct();
        $this->_siteKey = SecurityKey;
    }


    function tenant_exists($username) {
        $result = FALSE;

        //Check for user in database
        if($username)
        {
            $query = $this->db->get_where('tenant', array('username' => $username));
            if($this->get_db_data($query)) $result = TRUE;
        }
        return $result;
    }

    //Create a new tenant
    function create_tenant($tenantid, $fname, $lname, $company, $username, $password, $dor, $industry, $country) {
        $result = FALSE;

        //Generate user's salt
        $tenant_salt = $this->randomString();

        //Salt and Hash the password
        $password = $tenant_salt . $password;
        $password = $this->hashData($password);

        //Add records to the database
        $row['TenantID'] = $tenantid;
        $row['FirstName'] = $fname;
        $row['LastName'] = $lname;
        $row['Company'] = $company;
        $row['Username'] = $username;
        $row['Password'] = $password;
        $row['DOR'] = $dor; //Date of Registration
        $row['Industry'] = $industry;
        $row['Country'] = $country;
        $row['TenantSalt'] = $tenant_salt;
        $query = $this->db->insert('tenant', $row);

        if($query) $result = TRUE;

        return $result;
    }

    //Tenant Log_In
    function login_tenant($username, $password) 
    {
        //default token for incorrect username
        $results = array();
        $results['token'] = -1;

        if($this->tenant_exists($username)) //Check if the tenant exists
        {   
            // Get user login data
            $this->db->select('TenantID, FirstName, Password, TenantSalt');
            $query = $this->db->get_where('Tenant', array('Username' => $username));

            // Get user's first name
            $results['fname'] = $query->row()->FirstName;
            // Get user's id
            $results['tenantid'] = $query->row()->TenantID;

            //Compute hash password
            $password_hash = $query->row()->TenantSalt . $password;
            $password_hash = $this->hashData($password_hash);

            // Compare hash password with password in database file
            if(strcmp($query->row()->Password, $password_hash) == 0) 
            {
                if($this->check_tenant_log_status($query->row()->TenantID)) 
                { //check if the user in already logged
                    $results['token'] = $this->get_active_tenant_token($query->row()->TenantID); //return token for active user
                    return $results;
                }

                //generate a random string.
                $random = $this->randomString();

                //Build the token
                $token = $_SERVER['HTTP_USER_AGENT'] . $random;
                $token = $this->hashData($token);

                //Enter new log record in db
                $row['TenantID'] = $query->row()->TenantID;
                $row['Status'] = "active";
                $row['Token'] = $token;
                $query = $this->db->insert('TenantLog', $row);

                if($query) $results['token'] = $token;
            }
            else
            {
                $results['token'] = 0;
            }
        
        }

        return $results;
    }

    //User logout
    function logout_tenant($token) 
    {

        $result = FALSE;

        //Update log table status to closed
        $this->db->where('token', $token);
        $data = array('status' => 'closed');
        $query = $this->db->update('TenantLog', $data); //set tenant log status to closed

        if($query)  $result = TRUE;

        return $result;
    }

    //Check user log status
    private function check_tenant_log_status($tenantid) 
    {
        $status = FALSE;

        $this->db->select('Status');
        $query = $this->db->get_where('TenantLog', array('TenantID' => $tenantid, 'Status' => 'active'));

        if($this->get_db_data($query)) $status = TRUE; //user already logged-in

        return $status;
    }

    //Return token for active user
    private function get_active_tenant_token($tenantid) 
    {
        $token = -1; //Default

        $this->db->select('Token');
        $query = $this->db->get_where('TenantLog', array('TenantID' => $tenantid, 'Status' => 'active'));
        if($query) $token = $query->row()->Token; //return user's

        return $token;
    }

    //Generate random string
    private function randomString() 
    {
        $token = md5(uniqid($this->_siteKey, TRUE));
        return $token;
    }

    //Hash function
    private function hashData($data) 
    {
        return hash_hmac('sha512', $data, $this->_siteKey);
    }

    //Check if query returns rows
    private function get_db_data($query)
    {
        //echo $query->num_rows;
        return ($query->num_rows() > 0) ? $query->result_array() : FALSE;
    }

}