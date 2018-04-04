<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Assignments extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();
    // Your own constructor code
    $this->TPL['edit'] = false;
    $this->TPL['create'] = false;
    $this->TPL['log'] = false;
    $this->TPL['showAssignments'] = false;
    $this->TPL['showCompleted'] = false;
    $this->TPL['toggleBtn'] = true;
    $this->TPL['tasks'] = false;
    $this->TPL['shareable'] = false;
    $this->TPL['displayTaskOption'] = false;
    $this->TPL['loggedin'] = $this->userauth->loggedin('Assignments');
    $this->TPL['active'] = array('home' => false,
                                'dashboard'=> false,
                                'assignments' => true,
                                'settings' => false,
                                'admin' => false,
                                'login'=>false);
  }

  public function index()
  {
    $this->display();
  }

  // Gathers data from assignment_priority
  // Gathers data from assignments and sorts based on user set priority
  public function display() {
    // Figure out if user has already shared an assignment
    $query = $this->db->query("SELECT user_id FROM shared_assignments WHERE user_id='".$_SESSION['userid']."'");
    if ($query->num_rows() > 0){
      // if user has shared an assignment, do not let them share another
        $this->TPL['shareable'] = false;
    } else {
        $this->TPL['shareable'] = true;
    }

    // Gets list of assignment priorities to display
    $assignment_priority_query = $this->db->query("SELECT * FROM assignment_priority;");
    $this->TPL['assignment_priority'] = $assignment_priority_query->result_array();

    // Gets assignment priority id from user
    $user_query = $this->db->query("SELECT * FROM user WHERE user_id='".$_SESSION['userid']."'");
    foreach ($user_query->result() as $row) {
      $assignment_priority_id = $row->assignment_priority_id;
      $this->TPL['assignment_priority_id'] = $row->assignment_priority_id;
    }

    // Gets assignment info and assigns order priority
    $this->db->select('assignments.assignment_id, assignments.name AS assignment_name, assignments.course, assignment_type.name, assignments.due_date, assignments.weight, assignments.completed, assignments.time_spent, assignments.estimate_time, assignments.percentage_completed, assignments.shared AS shared');
    $this->db->from('assignments');
    $this->db->join('assignment_type', 'assignments.assignment_type_id = assignment_type.assignment_type_id');
    $this->db->where('user_id', $_SESSION['userid']);

    if ($assignment_priority_id == 1) {
      $this->db->order_by('assignments.weight','ASC');
    }
    if ($assignment_priority_id == 2) {
      $this->db->order_by('assignments.weight','DESC');
    }
    if ($assignment_priority_id == 3) {
      $this->db->order_by('assignments.due_date','ASC');
    }
    if ($assignment_priority_id == 4) {
      $this->db->order_by('assignments.due_date','DESC');
    }
    if ($assignment_priority_id == 5) {
      $this->db->order_by('assignments.estimate_time','ASC');
    }
    if ($assignment_priority_id == 6) {
      $this->db->order_by('assignments.estimate_time','DESC');
    }
    $query = $this->db->get();
    $this->TPL['assignments_list'] = $query->result_array();

    // Check if any assignments that arent completed
    $this->db->select('*');
    $this->db->from('assignments');
    $this->db->where('user_id', $_SESSION['userid']);
    $this->db->where('completed', 0);
    $uncompletedquery = $this->db->get();
    if($uncompletedquery->num_rows() == 0){
      $this->TPL['showAssignments'] = false;
    } else {
      $this->TPL['showAssignments'] = true;
    }

    // Check if any assignments that are completed
    $this->db->select('*');
    $this->db->from('assignments');
    $this->db->where('user_id', $_SESSION['userid']);
    $this->db->where('completed', 1);
    $completedquery = $this->db->get();
    if($completedquery->num_rows() == 0){
      $this->TPL['showCompleted'] = false;
    } else {
      $this->TPL['showCompleted'] = true;
    }

    $assignmentquery = $this->db->query("SELECT * FROM assignment_type;");
    $this->TPL['assignment_types'] = $assignmentquery->result_array();

    $this->template->show('assignments', $this->TPL);
  }

  // Validates and inserts data to create new assignment
  public function create(){
    $this->TPL['edit'] = false;
    $this->TPL['log'] = false;
    $this->TPL['toggleBtn'] = false;
    $this->form_validation->set_rules('name', 'Assignment Name', 'trim|required');
    $this->form_validation->set_rules('course', 'Course', 'trim|required');
    $this->form_validation->set_rules('due_date', 'Due Date', 'trim|required');
    $this->form_validation->set_rules('estimate_time', 'Estimated Completion Time', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[100]|numeric');
    $this->form_validation->set_rules('weight', 'Assignment Weight', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[100]|numeric');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
    if($this->form_validation->run() == FALSE){
      $this->TPL['create'] = true;
      $this->display();
    } else {
      $input = array('assignment_id' => 'null',
      'name' => $this->input->post('name'),
      'course' => $this->input->post('course'),
      'due_date' => $this->input->post('due_date'),
      'assignment_type_id' => $this->input->post('assignment_type'),
      'estimate_time' => $this->input->post('estimate_time'),
      'user_id' => $_SESSION['userid'],
      'weight' => $this->input->post('weight'),
      'percentage_completed' => 1
    );
    $this->db->set($input);
    $this->db->insert('assignments', $input);
    $this->TPL['toggleBtn'] = true;
    $this->session->set_flashdata('createassmsg', 'Assignment created');
    redirect('Assignments');

  }
}
// Validates and updates data to edit user
public function edit($id) {
  $this->TPL['create'] = false;
  $this->TPL['log'] = false;
  $this->TPL['toggleBtn'] = false;

  $this->form_validation->set_rules('name', 'Assignment Name', 'trim|required');
  $this->form_validation->set_rules('course', 'Course', 'trim|required');
  $this->form_validation->set_rules('due_date', 'Due Date', 'trim|required');
  $this->form_validation->set_rules('estimate_time', 'Estimated Completion Time', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[100]|numeric');
  $this->form_validation->set_rules('weight', 'Assignment Weight', 'trim|required|greater_than_equal_to[1]|less_than_equal_to[100]|numeric');
  $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');
  $assignment_type_query = $this->db->query("SELECT * FROM assignment_type;");

  $this->TPL['assignment_types'] = $assignment_type_query->result_array();

  $query = $this->db->query("SELECT * FROM assignments WHERE assignment_id = '$id'");
  $this->TPL['entry'] = $query->result_array()[0];

  foreach ($query->result() as $row) {
          $this->TPL['assignment_id'] = $row->assignment_id;
          $this->TPL['name'] = $row->name;
          $this->TPL['course'] = $row->course;
          $this->TPL['due_date'] = $row->due_date;
          $this->TPL['estimate_time'] = $row->estimate_time;
          $this->TPL['assignment_type_id'] = $row->assignment_type_id;
          $this->TPL['weight'] = $row->weight;
  }

    if($this->form_validation->run() == FALSE){
      $this->TPL['edit'] = true;
        $this->display();
    } else {
      $name = $this->input->post("name");
      $course = $this->input->post("course");
      $due_date = $this->input->post("due_date");
      $estimate_time = $this->input->post("estimate_time");
      $assignment_type_id = $this->input->post("assignment_type");
      $weight = $this->input->post("weight");
      $query = $this->db->query("UPDATE assignments " .
                                "SET name = '$name'," .
                                "    course = '$course'," .
                                "    due_date = '$due_date'," .
                                "    estimate_time = '$estimate_time'," .
                                "    assignment_type_id = '$assignment_type_id'," .
                                "    weight = '$weight'" .
                                " WHERE assignment_id = '$id';");
    $this->TPL['toggleBtn'] = true;
    $this->session->set_flashdata('editassmsg', 'Assignment updated');
    redirect('Assignments');
  }

}

// Deletes specified assignment
public function delete($id) {
  // if it exists in shared_assignments
  // delete from assignments AND shared assignments
  // delete all tasks with assignment id
  // else
  // perform normal delete
  $assquery = $this->db->query("SELECT * FROM shared_assignments WHERE assignment_id = '$id'");
  if ($assquery->num_rows() != 0){
    $query = $this->db->query("DELETE FROM assignments WHERE assignment_id = '$id';");
    $shared_query = $this->db->query("DELETE FROM shared_assignments WHERE assignment_id = '$id';");
    $task_query = $this->db->query("DELETE FROM tasks WHERE assignment_id = '$id';");
  } else {
    $query = $this->db->query("DELETE FROM assignments WHERE assignment_id = '$id';");
  }

  $this->session->set_flashdata('deleteassmsg', 'Assignment deleted');
  redirect('Assignments');
}

// Completes assignment and also deletes from shared assignments and associated tasks
public function complete($id){
  // delete assignment from shared_assignments
  // delete tasks
  // shared = 0
  $assquery = $this->db->query("SELECT * FROM shared_assignments WHERE assignment_id = '$id'");
  if ($assquery->num_rows() != 0){
    $shared_query = $this->db->query("DELETE FROM shared_assignments WHERE assignment_id = '$id';");
    $task_query = $this->db->query("DELETE FROM tasks WHERE assignment_id = '$id';");
  }

  $input = array(
                  'completed' => '1',
                  'shared' => 0
                );
  $this->db->where('assignment_id', $id);
  $this->db->update('assignments', $input);
  $this->session->set_flashdata('completeassmsg', 'Assignment completed!');
  redirect('Assignments');
}

// Allows user to log time for an assignment
// Calls calculatepercentage
// Logs each time in log_history for further viewing
public function log($id){
  date_default_timezone_set("America/Toronto");

  $this->TPL['create'] = false;
  $this->TPL['edit'] = false;
  $this->TPL['toggleBtn'] = false;

  $query = $this->db->query("SELECT * FROM log_history WHERE assignment_id='".$id."'");
  $this->TPL['loghistory'] = $query->result_array();

  $current_time_spent = 0;

  $this->form_validation->set_rules('time_spent', 'Log Time', 'trim|required|numeric|greater_than_equal_to[1]|less_than_equal_to[100]');
    $this->form_validation->set_error_delimiters('<div style="color:red;">', '</div>');

  $CI =& get_instance();
  $query = $CI->db->query("SELECT assignment_id, time_spent, estimate_time, percentage_completed FROM assignments WHERE assignment_id = '$id'");

  $this->TPL['entry'] = $query->result_array()[0];

  foreach ($query->result_array() as $row){
    $current_time_spent = (int)$row['time_spent'];
    $estimate_time = (int)$row['estimate_time'];
    $percentage_completed = $row['percentage_completed'];
  }

  if($this->form_validation->run() == FALSE){
    $this->TPL['log'] = true;
    $this->display();
  } else {
    $logged_time = (int)$this->input->post("time_spent") + $current_time_spent;
    $input = array('time_spent' => $logged_time);
    $this->db->where('assignment_id', $id);
    $this->db->update('assignments', $input);

    $inputhistory = array(
      'date_logged' => date("Y-m-d h:i:sA"),
      'quantity_logged' => $this->input->post("time_spent"),
      'assignment_id' => $id
    );
    $this->db->insert('log_history', $inputhistory);

    $this->TPL['toggleBtn'] = true;
    $this->session->set_flashdata('logmsg', 'Time logged');
    $this->calculatePercentage($id);
  }
}

// Gathers data to display tasks for logged in user
public function displayTasks($id){
  $this->TPL['tasks'] = true;
  $this->db->select('*');
  $this->db->from('tasks');
  $this->db->order_by('dependency', 'ASC');
  $this->db->where('user_id', $_SESSION['userid']);
  $this->db->where('assignment_id', $id);
  $query = $this->db->get();
  $this->TPL['task_list'] = $query->result_array();

  // Get lowest dependency value
  $this->db->select_min('dependency');
  $this->db->from('tasks');
  $this->db->where('assignment_id', $id);
  $this->db->where('complete !=', 1);
  $lowestquery = $this->db->get();
  foreach($lowestquery->result() as $row){
      $this->TPL['lowestdependency'] = $row->dependency;
  }

  $this->display();
}

// Deletes specified task
public function deleteTask($id){
  $query = $this->db->query("DELETE FROM tasks WHERE task_id = '$id';");
  $this->session->set_flashdata('deletetasksmsg', 'Task deleted');
  redirect('Assignments');
}

// Updates specified task in db to be completed, removes from assignment list
public function completeTask($id){
  $input = array('complete' => '1');
  $this->db->where('task_id', $id);
  $this->db->update('tasks', $input);
  $this->session->set_flashdata('completetasksmsg', 'Task completed!');
  redirect('Assignments');
}

// Peforms calculation based on estimated time and logged time to display percentage
function calculatePercentage($id){
  $CI =& get_instance();
  $query = $CI->db->query("SELECT time_spent, estimate_time, percentage_completed FROM assignments WHERE assignment_id = '$id'");
  foreach ($query->result_array() as $row){
    $current_time_spent = intval($row['time_spent']);
    $estimate_time = intval($row['estimate_time']);
  }

  $percentage_completed = round(($current_time_spent / $estimate_time) * 100);

  $input = array('percentage_completed' => $percentage_completed);
  $this->db->where('assignment_id', $id);
  $this->db->update('assignments', $input);
  // $this->display();
  redirect('Assignments');
}

// Allows user to change assignment priority
function updatePriority(){
  $input = array('assignment_priority_id' => $this->input->post('assignment_priority'));
  $this->db->where('user_id', $_SESSION['userid']);
  $this->db->update('user', $input);
  redirect('Assignments');
}

}
