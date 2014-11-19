<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Customers_model extends CI_Model {

    private $_siteKey;

    function __construct() {
        parent::__construct();
        $this->_siteKey = 'secret';
    }

    function get_all_rows() {
        /*$sql = "SELECT * FROM users";
        $query = $this->db->query($sql);*/
        $query = $this->db->get('tenant');

        //return $query->num_rows();
        return $query->row();
    }

    function customer_exists($username) {
        $result = false;

        /*$sql = "SELECT * FROM users WHERE username = ?";
        $query = $this->db->query($sql, array($username));*/
        $query = $this->db->get_where('users', array('username' => $username));

        if ($query->num_rows() > 0) {
            $result = TRUE;
        }

        return $result;
    }

    function create_customer($username, $password) {
        $result = false;

        //Generate users salt
        $user_salt = $this->randomString();             

        //Salt and Hash the password
        $password = $user_salt . $password;
        $password = $this->hashData($password);

        $row['username'] = $username;
        $row['password'] = $password;
        $row['user_salt'] = $user_salt;
        $result = $this->db->insert('users', $row);
        
        return $result;
    }

    function login_customer($username, $password) {
        $result = -1;

        if($this->customer_exists($username)) {
            /*$sql = "SELECT * FROM users where username = ?";
            $query = $this->db->query($sql, array($username));*/
            $this->db->select('id, password, user_salt');
            $query = $this->db->get_where('users', array('username' => $username));
            $password_hash = $query->row()->user_salt . $password;
            $password_hash = $this->hashData($password_hash);

            if(strcmp($query->row()->password, $password_hash) == 0) {
                //First, generate a random string.
                $random = $this->randomString();

                //Build the token
                $token = $_SERVER['HTTP_USER_AGENT'] . $random;
                $token = $this->hashData($token);

                //Setup session
                $_SESSION['token'] = $token;
                $_SESSION['user_id'] = $query->row()->id;

                /*$sql = "DELETE * from logged_in_users where user_id = ?";
                $this->db->query($sql, array($query->row()->id));*/
                $this->db->delete('logged_in_users', array('user_id' => $query->row()->id));

                $row['user_id'] = $query->row()->id;
                $row['session_id'] = $_SESSION['user_id'];
                $row['token'] = $token;

                $results = $this->db->insert('logged_in_users', $row);
                if($results) $result = $token; 
            }
        }

        return $result;   
    }

    function check_session() {

        $result = false;
                
        $this->db->select('user_id, session_id, token');
        $query = $this->db->get_where('logged_in_users', array('user_id' => $_SESSION['id']));
        if(query) {
            //Check ID and Token
            if(strcmp($_SESSION['id'], $query->row()->session_id()) == 0 && 
               strcmp($_SESSION['token'], $query->row()->token) == 0) {

                //Id and token match, refresh the session for the next request
                $this->refreshSession();
                $result = TRUE;
            }
        }
        return $result;   
    }

    private function refreshSession() {
        //To be implemented
    }

   /* function createToken($username, $password){
        $token = NULL;
        if($this->customer_exists($username, $password)){
            $token = md5(uniqid($username, TRUE));
        }
        return $token;
    } */

    private function randomString() {
        $token = md5(uniqid($this->_siteKey, TRUE));

        return $token;
    }

   /* private function randomString($length = 50) {

        $characters = '0123456789abcdefghijklmnopqrstuvwxyz';
        $string = '';   
            
        for ($p = 0; $p < $length; $p++) {

            $string .= $characters[mt_rand(0, strlen($characters))];
        }

        return $string;
    } */

    private function hashData($data) {

        return hash_hmac('sha512', $data, $this->_siteKey);
    }

}
