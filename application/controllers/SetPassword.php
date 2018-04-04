<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SetPassword extends CI_Controller {

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

  public function index() {
    $this->display();
  }

  // Displays template
  public function display(){
    $this->template->show('setpassword', $this->TPL);
  }

  // Validates and updates new password for user
  public function setPassword(){
    $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
    if($this->form_validation->run() == FALSE){
      $this->display();
    } else {
      $hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
      $input = array('password' => $hash);
      $this->db->set($input);
      $this->db->where('email', $this->session->userdata['username']);
      $this->db->update('user');
      redirect('ResetSuccess');
    }
  }
}
