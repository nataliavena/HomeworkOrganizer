<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->TPL['edit'] = false;
    $this->TPL['create'] = false;
    $this->TPL['toggleBtn'] = true;
    $this->TPL['editReportedUser'] = false;
    $this->TPL['loggedin'] = $this->userauth->loggedin('Admin');
    $this->TPL['active'] = array('home' => false,
                                'dashboard'=> false,
                                'assignments' => false,
                                'settings' => false,
                                'admin' => true,
                                'login'=>false);

  }

  public function index(){
    $this->display();
  }

  // Calls display users and displaysReportedUsers on page load
  public function display() {
    $this->displayUsers();
    $this->displayReportedUsers();
    $this->template->show('admin', $this->TPL);
  }

  // Gets list of users from database
  // Gets list of security questions
  // Gets assignment priority
  // Displays on admin page
  public function displayUsers(){
    $query = $this->db->query("SELECT user.user_id, user.first_name, user.last_name, user.email, user.assignment_priority_id, security_question.security_question_id, security_question.name, user.security_answer, user.accesslevel, user.assignment_priority_id, assignment_priority.type FROM user JOIN security_question ON user.security_question_id=security_question.security_question_id JOIN assignment_priority ON user.assignment_priority_id=assignment_priority.assignment_priority_id ORDER BY user.user_id ASC");

    $this->TPL['users_list'] = $query->result_array();

    $query = $this->db->query("SELECT * FROM security_question;");
    $this->TPL['security_questions'] = $query->result_array();

    $assignment_priority_query = $this->db->query("SELECT * FROM assignment_priority;");

    $this->TPL['assignment_priority'] = $assignment_priority_query->result_array();
  }

 // Gets data to display reported users on admin page
  public function displayReportedUsers(){
    $query = $this->db->query("SELECT * FROM reported_users ORDER BY id ASC");
    $this->TPL['reported_users'] = $query->result_array();
  }

//  Validates and sets input to create new user
  public function create(){
    $this->TPL['toggleBtn'] = false;

    $calendar_view_query = $this->db->query("SELECT * FROM calendar_view;");
    $this->TPL['calendar_view'] = $calendar_view_query->result_array();

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|callback_checkUsername');
    $this->form_validation->set_rules('password', 'Password', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('confirm_password', 'Confirm Password', 'trim|required|alpha_numeric_spaces|matches[password]');
    $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
    if($this->form_validation->run() == FALSE){
      $this->TPL['create'] = true;
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
                  'assignment_priority_id' => $this->input->post('assignment_priority'),
                  'calendar_view_id' => $this->input->post('calendar_view')
                );
      $this->db->set($input);
      $this->db->insert('user', $input);
      $this->TPL['toggleBtn'] = true;
      $this->session->set_flashdata('createmsg', 'User created');
      redirect('Admin');
    }
  }

 //  Callback that checks if username exists in database on creating new user
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

// Validates and updates info for editing a user
  public function edit($id){

    // Shows or hides Add New User based on option clicked
    $this->TPL['toggleBtn'] = false;

    // Get calendar views
    $calendar_view_query = $this->db->query("SELECT * FROM calendar_view;");
    $this->TPL['calendar_view'] = $calendar_view_query->result_array();

    // Displays security question name instead of id
    $security_question_query = $this->db->query("SELECT * FROM security_question;");
    $this->TPL['security_questions'] = $security_question_query->result_array();

    $user_query = $this->db->query("SELECT * FROM user WHERE user_id='".$id."'");
    $this->TPL['entry'] = $user_query->result_array()[0];
    foreach ($user_query->result() as $row)
    {
            $this->TPL['first_name'] = $row->first_name;
            $this->TPL['last_name'] = $row->last_name;
            $this->TPL['email'] = $row->email;
            $this->TPL['password'] = $row->password;
            $this->TPL['security_question_id'] = $row->security_question_id;
            $this->TPL['security_answer'] = $row->security_answer;
            $this->TPL['accesslevel'] = $row->accesslevel;
            $this->TPL['$assignment_priority_id'] = $row->assignment_priority_id;
            $this->TPL['calendar_view_id'] = $row->calendar_view_id;
    }

    $this->form_validation->set_rules('first_name', 'First Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('security_answer', 'Security Answer', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
    if($this->form_validation->run() == FALSE){
      $this->TPL['edit'] = true;
      $this->display();
      $this->TPL['msg'] = "User failed to update";
    } else {
      $input = array(
                  'first_name' => $this->input->post('first_name'),
                  'last_name' => $this->input->post('last_name'),
                  'security_question_id' => $this->input->post('security_question'),
                  'security_answer' => $this->input->post('security_answer'),
                  'accesslevel' => $this->input->post("accesslevel"),
                  'assignment_priority_id' => $this->input->post('assignment_priority'),
                  'calendar_view_id' => $this->input->post('calendar_view')
                );

          $this->db->set($input);
          $this->db->where('user_id', $id);
          $this->db->update('user', $input);
          $this->TPL['toggleBtn'] = true;
          $this->session->set_flashdata('editmsg', 'User updated');
          redirect('Admin');
    }
  }

  // Deletes specified user from database
  public function delete($id){
    // Delete from users
    $query = $this->db->query("DELETE FROM user WHERE user_id = '$id';");
    // delete assignments
    $assquery = $this->db->query("DELETE FROM assignments WHERE user_id = '$id';");
    // delete chats
    $chatquery = $this->db->query("DELETE FROM chat WHERE user_id = '$id';");
    // delete reported user ??

    // delete from shared assignments
    $sharedquery = $this->db->query("DELETE FROM shared_assignments WHERE user_id='$id';");
    //delete from tasks
    $taskquery = $this->db->query("DELETE FROM tasks WHERE user_id='$id';");

    $this->session->set_flashdata('deletemsg', 'User deleted');
    redirect('Admin');
  }

  //  Validates and updates data for reported user
  public function editReportedUser($id){
    $query = $this->db->query("SELECT * FROM reported_users WHERE id='".$id."'");
    $this->TPL['reported_user_id'] = $query->result_array()[0];

    foreach ($query->result() as $row) {
            $this->TPL['description'] = $row->description;
    }

    $this->form_validation->set_rules('description', 'Description', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->TPL['editReportedUser'] = true;
      $this->display();
    } else {
      $input = array('description' => $this->input->post('description'));
          $this->db->set($input);
          $this->db->where('id', $id);
          $this->db->update('reported_users', $input);
          $this->TPL['toggleBtn'] = true;
          $this->session->set_flashdata('editreportmsg', 'Reported user updated');
          redirect('Admin');
    }
  }

  // Deletes specified reported user
  public function deleteReportedUser($id){
    $query = $this->db->query("DELETE FROM reported_users WHERE id = '$id';");
    $this->session->set_flashdata('deletereportmsg', 'Reported user deleted');
    redirect('Admin');
  }

}
