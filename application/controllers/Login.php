<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

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
                                'login'=>true);
  }

  // Displays template and creates a new session
  public function index() {
    $this->display();
    $this->session->sess_destroy();
  }

  public function display(){
    $this->template->show('login', $this->TPL);
  }

  // passes form info to user auth for authentication
  public function loginuser()
  {
    $this->TPL['msg'] = $this->userauth->login($this->input->post("username"),
                             $this->input->post("password"));
    $this->display();
  }

  // destroys session 
  public function logout()
  {
    $this->userauth->logout();
  }

}
