<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {

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
                                'login'=> false);
  }

  public function index()
  {
    $this->display();
  }

  // Get security question list
  // Display template
  public function display(){
    $query = $this->db->query("SELECT * FROM security_question;");
    $this->TPL['security_questions'] = $query->result_array();
    $this->template->show('register', $this->TPL);
  }

//  Validates and inserts user info for creation
  public function addUser(){
    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_checkUsername');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|matches[password]');
    $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->display();
    } else {
      $hash = password_hash($this->input->post('password'), PASSWORD_DEFAULT);
      $input = array('user_id' => 'null',
                  'first_name' => $this->input->post('first_name'),
                  'last_name' => $this->input->post('last_name'),
                  'email' => $this->input->post('email'),
                  'password' => $hash,
                  'security_question_id' => $this->input->post('security_question'),
                  'security_answer' => $this->input->post('security_answer'),
                  'assignment_priority_id' => 1
                );
      $this->db->set($input);
      $this->db->insert('user', $input);
      $this->session->set_flashdata('registermsg', 'User successfully created!');
      redirect('Login');
    }
  }

// Checks that existing user does not already exist in database
  public function checkUsername($value){
  $this->db->where('email', $value);
  $query = $this->db->count_all_results('user');
    if($query > 0){
      $this->form_validation->set_message('checkUsername', 'A user with that email already exists');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}
