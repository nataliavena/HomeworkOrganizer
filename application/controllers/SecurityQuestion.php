<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SecurityQuestion extends CI_Controller {

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

  // Displays security question for user
  public function display(){

    $query = $this->db->query("SELECT security_question.name FROM security_question JOIN user ON security_question.security_question_id = user.security_question_id WHERE email='".$this->session->userdata['username']."'");

    foreach ($query->result() as $row) {
        $this->TPL['security_question'] = $row->name;
      }
    $this->template->show('securityquestion', $this->TPL);
  }

  // Validates form fields
  public function reset(){
    $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|callback_checkSecurityAnswer');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
      if($this->form_validation->run() == FALSE){
        $this->display();
      } else {
        redirect('SetPassword');
      }
  }

  // Checks security question answer 
  public function checkSecurityAnswer($value){
    $this->db->where('security_answer', $value);
    $this->db->where('email', $this->session->userdata['username']);
    $query = $this->db->count_all_results('user');
    if ($query <= 0) {
      $this->form_validation->set_message('checkSecurityAnswer', 'That answer is incorrect');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}
