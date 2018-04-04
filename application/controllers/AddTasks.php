<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AddTasks extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
   $this->TPL['loggedin'] = $this->userauth->loggedin('AddTasks');
  }

// Calls display to load all information
  public function index() {
    $this->display();
  }

// Gets lists of users shared to assignment to display in dropdowns
  public function display(){
    $this->db->select('user.email, shared_assignments.user_id');
    $this->db->from('shared_assignments');
    $this->db->join('user', 'user.user_id = shared_assignments.user_id');
    $this->db->where('assignment_id', $_SESSION['assignment_id']);
    $query = $this->db->get();

    $this->TPL['sharedusers'] = $query->result_array();

    $this->template->show('addtasks', $this->TPL);
  }

  // Validates and sets form input to add task to users in shared assignment
  public function addTasks(){
    $this->form_validation->set_rules('task1', 'Task 1', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('task2', 'Task 2', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('dependency1', 'Dependency 1', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]|integer');
    $this->form_validation->set_rules('dependency2', 'Dependency 2', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]|integer');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    // Dynamic form data from add tasks
    $task_array = $this->input->post('tasks');
    $user_array = $this->input->post('user_list');
    $dependency_array = $this->input->post('dependency');

    if ($task_array != "" && $user_array != "" && $dependency_array != "") {
      $insertTaskData = '';
      // saved into array to insert as batch into database
      for($i = 0; $i < count($task_array); $i++){
        $insertTaskData[] = array(
          'user_id' => $user_array[$i],
          'description' => $task_array[$i],
          'assignment_id' => $_SESSION['assignment_id'],
          'dependency' => $dependency_array[$i]
          );
        }
      }

    if($this->form_validation->run() == FALSE){
      $this->display();
    } else {
      $input1 = array(
                  'user_id' => $this->input->post('user_list1'),
                  'description' => $this->input->post('task1'),
                  'assignment_id' => $_SESSION['assignment_id'],
                  'dependency' => $this->input->post('dependency1')
                );
      $this->db->set($input1);
      $this->db->insert('tasks', $input1);

      $input2 = array(
                  'user_id' => $this->input->post('user_list2'),
                  'description' => $this->input->post('task2'),
                  'assignment_id' => $_SESSION['assignment_id'],
                  'dependency' => $this->input->post('dependency2')
                );
      $this->db->set($input2);
      $this->db->insert('tasks', $input2);

      if ($insertTaskData != "" && $insertTaskData != null && $insertTaskData != 'undefined'){
        $this->db->insert_batch('tasks', $insertTaskData);
      }

      redirect('Dashboard');
  }
}




}
