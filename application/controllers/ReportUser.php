<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ReportUser extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $this->TPL['loggedin'] = $this->userauth->loggedin('ReportUser');
   $this->TPL['active'] = array('home' => false,
                                'dashboard'=> false,
                                'assignments' => false,
                                'settings' => false,
                                'admin' => false,
                                'login'=>false);

  }

  public function index()
  {
    $this->display();
  }

  // Displays template
  public function display(){
    $this->template->show('reportuser', $this->TPL);
  }

  // Validates and inserts data for reported user
  public function report(){
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_checkEmail');
    $this->form_validation->set_rules('description', 'Description', 'trim|required|max_length[225]');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->display();
      $this->TPL['msg'] = '<div class="alert alert-danger" role="alert">Failed to report user</div>';
    } else {
      $input = array(
                  'reporter' => $_SESSION['username'],
                  'reported_user_email' => $this->input->post('email'),
                  'description' => $this->input->post('description')
                );

      $this->db->set($input);
      $this->db->insert('reported_users', $input);
      $this->session->set_flashdata('reportmsg', 'User reported');
      redirect('ReportUser');
    }
  }

  // checks that email exists in database before submit
  public function checkEmail($value){
  $this->db->where('email', $value);
  $query = $this->db->count_all_results('user');
    if ($query <= 0){
      $this->form_validation->set_message('checkEmail', 'Please enter an existing user email');
      return FALSE;
    } else {
      return TRUE;
    }
  }
}
