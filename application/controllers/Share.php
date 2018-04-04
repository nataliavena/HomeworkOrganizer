<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Share extends CI_Controller {

  var $TPL;

  public function __construct() {
    parent::__construct();
    // Your own constructor code
    $this->TPL['loggedin'] = $this->userauth->loggedin('Share');
  }

  public function index() {
    $this->display();
  }

  // Sets assignment id in session and displays template
  public function display($id) {

    $_SESSION['assignment_id'] = $id;
    // get emails that do not exist in shared_assignments
    $availableuserquery = $this->db->query("SELECT user_id, email FROM user WHERE user_id NOT IN (SELECT user_id FROM shared_assignments) AND email != '".$_SESSION['username']."'");

    $this->TPL['availableusers'] = $availableuserquery->result_array();

    $this->template->show('share', $this->TPL);
  }

  // Validates and sets users to share to assignment
  public function addUsers($id) {

    $this->form_validation->set_rules('availableusers', 'User', 'required');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->display($id);
    } else {
      $input = array(
                  'user_id' => $this->input->post('availableusers'),
                  'assignment_id' => $id
                );
      $this->db->set($input);
      $this->db->insert('shared_assignments', $input);

      $input2 = array(
                  'user_id' => $_SESSION['userid'],
                  'assignment_id' => $id
                );
      $this->db->set($input2);
      $this->db->insert('shared_assignments', $input2);

      $assInput = array(
                      'shared' => 1
                  );
      $this->db->set($assInput);
      $this->db->where('assignment_id', $id);
      $this->db->update('assignments', $assInput);
      redirect('AddTasks');
  }
}


  // Checks if user to be added exists in database
  public function checkUsername($value){
  $this->db->where('email', $value);
  $query = $this->db->count_all_results('user');
    if($query <= 0){
      $this->form_validation->set_message('checkUsername', 'Please enter an existing user email');
      return FALSE;
    } else {
      return TRUE;
    }
  }

}
