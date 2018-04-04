
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

  var $TPL;

  public function __construct()
  {
    parent::__construct();

   $this->TPL['showAssignments'] = false;
   $this->TPL['loggedin'] = $this->userauth->loggedin('Home');
   $this->TPL['active'] = array('home' => true,
                                'dashboard'=> false,
                                'assignments' => false,
                                'settings' => false,
                                'admin' => false,
                                'login'=>false);
  }

  // On page load, loads display()
  public function index()
  {
      $this->display();
  }

  // Loads calendar and summary view
  public function display(){
    $this->calendarAssignments();
    $this->displayAssignments();
    $this->calendarView();

    $this->template->show('home', $this->TPL);
  }

  // Gets assignment info to display in summary view
  // Allows ordering by user priority
  public function displayAssignments(){
    $assignment_priority_query = $this->db->query("SELECT * FROM assignment_priority;");

    $this->TPL['assignment_priority'] = $assignment_priority_query->result_array();

    $user_query = $this->db->query("SELECT * FROM user WHERE user_id='".$_SESSION['userid']."'");

    foreach ($user_query->result() as $row) {
      $assignment_priority_id = $row->assignment_priority_id;
      $this->TPL['assignment_priority_id'] = $row->assignment_priority_id;
    }

    $this->db->select('assignments.assignment_id, assignments.name AS assignment_name, assignments.course, assignment_type.name, assignments.due_date, assignments.weight, assignments.completed, assignments.time_spent, assignments.estimate_time, assignments.percentage_completed');
    $this->db->from('assignments');
    $this->db->join('assignment_type', 'assignments.assignment_type_id = assignment_type.assignment_type_id');
    $this->db->where('user_id', $_SESSION['userid']);
    $this->db->limit(4);

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

    if ($query->num_rows() == 0){
      $this->TPL['showAssignments'] = false;
    } else {
      $this->TPL['showAssignments'] = true;
    }

    $this->TPL['assignments_list'] = $query->result_array();
  }

  // Updates user assignment priority
  function updatePriority(){
    $input = array('assignment_priority_id' => $this->input->post('assignment_priority'));
    $this->db->where('user_id', $_SESSION['userid']);
    $this->db->update('user', $input);
    redirect('Home');
  }

  // Gathers assignment data and outputs JSON format for calendar to display
  public function calendarAssignments(){
      $query = $this->db->query("SELECT name, course, due_date, completed FROM assignments WHERE user_id='".$_SESSION['userid']."'");
      $data_events = array();
      foreach ($query->result_array() as $row) {
        $data_events[] = array(
          'title' => $row['name']." - ".$row['course'],
          'start' => $row['due_date'],
          'end' => $row['due_date'],
          'color' => $row['completed'] ? 'grey' : '#F39C12',
          'textColor' => 'white'
        );
      }
      $this->TPL['encoded'] = json_encode($data_events);
    }

    public function calendarView(){
      $query = $this->db->query("SELECT calendar_view_id FROM user WHERE user_id='".$_SESSION['userid']."'");

      foreach($query->result() as $row){
          $data = $row->calendar_view_id;
      }

      if($data == '1'){
        $view = 'basicDay';
      }
      if ($data == '2'){
        $view = 'basicWeek';
      }
      if ($data == '3'){
        $view = 'month';
      }
      $this->TPL['view'] = $view;
    }
  }
