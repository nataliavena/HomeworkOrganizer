<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code

   $this->TPL['loggedin'] = $this->userauth->loggedin('Settings');
   $this->TPL['active'] = array('home' => false,
                                'dashboard'=> false,
                                'assignments' => false,
                                'settings' => true,
                                'admin' => false,
                                'login'=>false);

  }

  public function index()
  {
    $this->display();
  }

  // Gets user info from database to display in form fields
  public function display(){

    $this->TPL['username'] = $this->userauth->getUsername();

    $assignment_priority_query = $this->db->query("SELECT * FROM assignment_priority;");
    $this->TPL['assignment_priority'] = $assignment_priority_query->result_array();

    $security_question_query = $this->db->query("SELECT * FROM security_question;");
    $this->TPL['security_questions'] = $security_question_query->result_array();

    $calendar_view_query = $this->db->query("SELECT * FROM calendar_view;");
    $this->TPL['calendar_view'] = $calendar_view_query->result_array();

    $user_query = $this->db->query("SELECT * FROM user WHERE email='".$this->TPL['username']."'");

    foreach ($user_query->result() as $row)
    {
            $this->TPL['first_name'] = $row->first_name;
            $this->TPL['last_name'] = $row->last_name;
            $this->TPL['email'] = $row->email;
            $this->TPL['password'] = $row->password;
            $this->TPL['security_question_id'] = $row->security_question_id;
            $this->TPL['security_answer'] = $row->security_answer;
            $this->TPL['assignment_priority_id'] = $row->assignment_priority_id;
            $this->TPL['calendar_view_id'] = $row->calendar_view_id;
    }
    $this->template->show('settings', $this->TPL);
  }

  // Validates and updates user information
  public function updateUser(){

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->display();
    } else {
      $input = array(
                  'first_name' => $this->input->post('first_name'),
                  'last_name' => $this->input->post('last_name'),
                  'security_question_id' => $this->input->post('security_question'),
                  'security_answer' => $this->input->post('security_answer'),
                  'assignment_priority_id' => $this->input->post('assignment_priority'),
                  'calendar_view_id' => $this->input->post('calendar_view')
                );
      $this->db->set($input);
      $this->db->where('user_id', $this->userauth->getUserId());
      $this->db->update('user', $input);
      $this->session->set_flashdata('updatemsg', 'User updated');
      redirect('Settings');
    }
  }
}
