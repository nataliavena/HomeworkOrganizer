<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ResetSuccess extends CI_Controller {

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

  // displays success message on password reset
  public function display(){
    $this->template->show('resetsuccess', $this->TPL);
  }

}
