<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

  var $TPL;
  private $assignment_id = 0;

  public function __construct() {
    parent::__construct();

    // Your own constructor code
   $this->TPL['shared'] = false;
   $this->TPL['addtask'] = false;
   $this->TPL['adduser'] = false;
   $this->TPL['showTaskOptions'] = false;
   $this->TPL['availableUsers'] = false;
   $this->TPL['loggedin'] = $this->userauth->loggedin('Dashboard');
   $this->TPL['active'] = array('home' => false,
                                'dashboard'=> true,
                                'assignments' => false,
                                'settings' => false,
                                'admin' => false,
                                'login'=>false);

  }

  public function index() {
    $this->display();
  }

  // Displays assignment on load if it is shared
  public function display(){

    $query = $this->db->query("SELECT * FROM assignments JOIN shared_assignments ON assignments.assignment_id=shared_assignments.assignment_id WHERE shared_assignments.user_id='".$_SESSION['userid']."'");

    // Display assignment info
    foreach ($query->result_array() as $row) {
      $this->TPL['shared'] = $row['shared'];
      $this->assignment_id = $row['assignment_id'];
      $this->TPL['assignment_id'] = $row['assignment_id'];
      $this->TPL['name'] = $row['name'];
      $this->TPL['course'] = $row['course'];
      $this->TPL['due_date'] = $row['due_date'];
      $this->TPL['percentage_completed'] = $row['percentage_completed'];
    }

    // Display users on assignment
    $this->db->select('user.email');
    $this->db->from('user');
    $this->db->join('shared_assignments', 'user.user_id=shared_assignments.user_id');
    $this->db->where('assignment_id', $this->assignment_id);
    $userquery = $this->db->get();

    $this->TPL['users'] = $userquery->result_array();

    // Display tasks
    $this->db->select('*');
    $this->db->from('tasks');
    $this->db->join('user', 'user.user_id=tasks.user_id');
    $this->db->where('assignment_id', $this->assignment_id);
    $this->db->order_by('dependency', 'ASC');
    $taskquery = $this->db->get();

    $this->TPL['tasks'] = $taskquery->result_array();

    // Get lowest dependency value
    $this->db->select_min('dependency');
    $this->db->from('tasks');
    $this->db->where('assignment_id', $this->assignment_id);
    $this->db->where('complete !=', 1);
    $lowestquery = $this->db->get();
    foreach($lowestquery->result() as $row){
        $this->TPL['lowestdependency'] = $row->dependency;
    }

    $this->template->show('dashboard', $this->TPL);
  }

  // Only users who are not already on a shared assignment can be added
  public function addUser($id){
    $this->TPL['adduser'] = true;
    // get emails that do not exist in shared_assignments
    $availableuserquery = $this->db->query("SELECT user_id, email FROM user WHERE user_id NOT IN (SELECT user_id FROM shared_assignments)");

    $this->TPL['availableusers'] = $availableuserquery->result_array();

    $this->form_validation->set_rules('availableusers', 'User', 'required');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if ($this->form_validation->run() == FALSE){
      $this->display();
      $this->TPL['adduser'] = true;
    } else {
      // get shared assignment at assignment_id
      // insert value into that column
      $input = array(
                  'user_id' => $this->input->post('availableusers'),
                  'assignment_id' => $id
                );
      $this->db->set($input);
      $this->db->insert('shared_assignments', $input);
      $this->session->set_flashdata('createmsg', 'User added');
      redirect('Dashboard');
    }
  }

  // Validates and adds task for specified user to shared assignment
  public function addTasks($id){
    $this->TPL['addtask'] = true;

    $this->db->select('user.email, shared_assignments.user_id');
    $this->db->from('shared_assignments');
    $this->db->join('user', 'user.user_id = shared_assignments.user_id');
    $this->db->where('assignment_id', $id);
    $query = $this->db->get();

    $this->TPL['sharedusers'] = $query->result_array();

    $this->form_validation->set_rules('task', 'Task', 'trim|required|alpha_numeric_spaces');
    $this->form_validation->set_rules('dependency', 'Dependency', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[100]|numeric');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->TPL['addtask'] = true;
      $this->display();
    } else {
      $input = array(
                  'user_id' => $this->input->post('user_list'),
                  'description' => $this->input->post('task'),
                  'assignment_id' => $id,
                  'dependency' => $this->input->post('dependency')
                );
      $this->db->set($input);
      $this->db->insert('tasks', $input);
      $this->session->set_flashdata('addtaskmsg', 'Task added');
      redirect('Dashboard');
    }
  }

// Updates task to be completed
  public function completeTask($id){
    $input = array('complete' => '1');
    $this->db->where('task_id', $id);
    $this->db->update('tasks', $input);
    $this->session->set_flashdata('completetaskmsg', 'Task completed!');
    redirect('Dashboard');
  }

// Deletes specified task
  public function deleteTask($id){
    $query = $this->db->query("DELETE FROM tasks WHERE task_id = '$id';");
    $this->session->set_flashdata('deletetaskmsg', 'Task deleted');
    redirect('Dashboard');
  }

  // Deletes assignment
  public function delete($id){
    // if it exists in shared_assignments
    // delete from assignments AND shared assignments
    // delete all tasks with assignment id
    // else
    // perform normal delete
    $query = $this->db->query("DELETE FROM assignments WHERE assignment_id = '$id';");
    $shared_query = $this->db->query("DELETE FROM shared_assignments WHERE assignment_id = '$id';");
    $task_query = $this->db->query("DELETE FROM tasks WHERE assignment_id = '$id';");
    $chat_query = $this->db->query("DELETE FROM chat WHERE assignment_id='$id';");
    $this->session->set_flashdata('deleteassmsg', 'Assignment deleted');
    redirect('Dashboard');
  }

  // Inserts chat message in database, formats date, sets timezone
  public function sendChat($id){
    date_default_timezone_set("America/Toronto");
    $this->form_validation->set_rules('msg', 'Message', 'trim|required');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

    if($this->form_validation->run() == FALSE){
      $this->display();
    } else {
      $input = array(
                  'user_id' => $_SESSION['userid'],
                  'message' => $this->input->post('msg'),
                  'assignment_id' => $id

                );
      $this->db->set($input);
      $this->db->insert('chat', $input);
      redirect("Dashboard");
    }
  }

  // Gets all chat from database to display in chat window
  public function getChat($id){
    if ($id == '') {
      echo "Create a shared assignment to get started";
    }
    date_default_timezone_set("America/Toronto");
    $this->db->select('*');
    $this->db->from('chat');
    $this->db->join('user', 'user.user_id=chat.user_id');
    $this->db->where('assignment_id', $id);
    $query = $this->db->get();
    foreach($query->result_array() as $row){
      $date = new DateTime($row['sent']);
      $format = $date;
      echo $row['message'];
      echo "<br />";
      echo "<span style='font-size:9px'>".$row['email']." <span class='text-muted'>".$row['sent']."</span></span>";
      echo "<br />";
    }
  }
}
