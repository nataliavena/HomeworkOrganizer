<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResetPassword extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $this->TPL['loggedin'] = false;
   $this->TPL['active'] = array('home' => false,
                                'dashboard'=> false,
                                'assignments' => false,
                                'settings' => false,
                                'admin' => false,
                                'login'=>false);
  }

  // Destroys session to allow for login after resetting password
  public function index() {
    $this->display();
    $this->session->sess_destroy();
  }

  // Displays template
  public function display(){
    $this->template->show('resetpassword', $this->TPL);
  }

  // Validates and sets email as session data for reset
  public function checkEmail(){
        $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_userIsInDatabase');
        $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
        if($this->form_validation->run() == FALSE){
          $this->display();
        } else {
          $data = array('username' => $this->input->post('email'));
          $this->session->set_userdata($data);
          redirect('SecurityQuestion');
        }
  }

  // checks that user exists in the database 
  public function userIsInDatabase($value){
    $this->db->where('email', $value);
    $query = $this->db->count_all_results('user');
      if($query <= 0){
        $this->form_validation->set_message('userIsInDatabase', 'Please enter a valid registered email.');
        return FALSE;
      } else {
        return TRUE;
      }
    }
}
