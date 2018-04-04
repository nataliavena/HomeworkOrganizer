<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <? if($this->session->flashdata('createassmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('createassmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('editassmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('editassmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('deleteassmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('deleteassmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('completeassmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('completeassmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('logmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('logmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('deletetasksmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('deletetasksmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('completetasksmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('completetasksmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <h3>Assignments</h3>
    </div>
  </div>
  <br />
  <div class="row">
      <? if ($tasks) {?>
        <!-- <div class="row"> -->
          <div class="col-sm-6">
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center active">
                  <h4>Tasks</h4>
                    <a href="<?= base_url() ?>index.php/Assignments/" class="close">&times;</a>
                </li>
              <? foreach($task_list as $task) { ?>
                <? if ($task['complete'] == 0){ ?>
                  <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?=$task['description']?>
                    <? if ($task['dependency'] == $lowestdependency) { ?>
                      <span style='float:right;'>
                        <a title="Complete" href="<?= base_url() ?>index.php/Assignments/completeTask/<?= $task['task_id']?>">
                          <i class="fa fa-check" aria-hidden="true" style="padding-right:10px;"></i>
                        </a>
                        <a title="Delete" href="<?= base_url() ?>index.php/Assignments/deleteTask/<?= $task['task_id']?>">
                          <i class="fa fa-trash" aria-hidden="true" style="color:grey;"></i>
                        </a>
                      </span>
                    <? }  else {?>
                      <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="You can only complete this task when the previous task is complete"><i class="fa fa-question" aria-hidden="true"></i></span>
                    <? }?>
                  </li>
              <? } ?>
              <? if ($task['complete'] == 1) {?>
                <li class="list-group-item align-items-start flex-column disabled">
                  <div class="d-flex w-100 justify-content-between">
                    <span class="mb-1"><?=$task['description']?></span>
                    <small class="text-muted">
                      Complete
                    </small>
                  </div>
                </li>
              <? } ?>
            <? } ?>
            </ul>
          </div>
        <!-- </div> -->
      <? } ?>
    <div class="col-sm-6">
      <? if ($toggleBtn) {?>
        <!-- <div class="col-sm-6"> -->
          <div>
              <a class="btn btn-success" href="<?= base_url() ?>index.php?/Assignments/create">Add Assigment</a>
          </div>
        <!-- </div> -->
        <?}?>
    </div>
  </div>
  <br />
  <? if ($create) {?>
    <div class="row">
      <div class="col-sm-8">
        <?= form_open('Assignments/create'); ?>
        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="name">Assignment Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?=set_value("name")?>" required/>
              <?= form_error('name'); ?>
          </div>
          <div class="form-group col-md-6">
              <label for="course">Course</label>
              <input type="text" class="form-control" id="course" name="course" value="<?=set_value("course")?>" required/>
              <?= form_error('course'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="<?=set_value("due_date")?>" required/>
            <?= form_error('due_date'); ?>
            <!-- <input type="time" class="form-control" id="due_date" name="due_date" value="<?=set_value("due_date")?>" required/> -->
          </div>
          <div class="form-group col-md-6">
              <label for="estimate_time">Estimated Completion Time</label>
              <div class="input-group">
                <input type="decimal" class="form-control" id="estimate_time" name="estimate_time" value="<?=set_value("estimate_time")?>" min="1" max="100" required/>
                <div class="input-group-addon">hours</div>
              </div>
              <?= form_error('estimate_time'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="assignment_type">Assignment Type</label>
              <select name="assignment_type" id="assignment_type" class="form-control">
                  <? foreach($assignment_types as $row) { ?>
                      <option id="<?=$row['assignment_type_id']?>" name="<?=$row['assignment_type_id']?>" value="<?=$row['assignment_type_id']?>"><?=$row['name']?></option>
                  <? } ?>
              </select>
          </div>
          <div class="form-group col-md-6">
              <label for="weight">Assignment Weight:</label>
              <div class="input-group">
                <input type="decimal" class="form-control" id="weight" name="weight" value="<?=set_value("weight")?>" min="1" max="100" required/>
                <div class="input-group-addon">%</div>
              </div>
              <?= form_error('weight'); ?>
          </div>
        </div>
        <?= form_submit(array('id' => 'submit', 'value' => 'Add Assignment', 'class' => 'btn btn-success')); ?>
        <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Assignments/">Close</a>
        <?= form_close(); ?><br/>
      </div>
    </div>
  <? } ?>
  <? if ($edit) {?>
    <div class="row">
      <div class="col-sm-8">
        <?= form_open('Assignments/edit/'. $entry['assignment_id']); ?>
        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="name">Name</label>
              <input type="text" class="form-control" id="name" name="name" value="<?=$name?>" required/>
              <?= form_error('name'); ?>
          </div>
          <div class="form-group col-md-6">
              <label for="course">Course</label>
              <input type="text" class="form-control" id="course" name="course" value="<?=$course?>" required/>
              <?= form_error('course'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="due_date">Due Date</label>
            <input type="date" class="form-control" id="due_date" name="due_date" value="<?=$due_date?>" required/>
            <?= form_error('due_date'); ?>
          </div>
          <div class="form-group col-md-6">
              <label for="estimate_time">Estimated Completion Time</label>
              <div class="input-group">
                <input type="decimal" class="form-control" id="estimate_time" name="estimate_time" value="<?=$estimate_time?>" required/>
                <div class="input-group-addon">hours</div>
              </div>
              <?= form_error('estimate_time'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
              <label for="assignment_type">Assignment Type</label>
              <select name="assignment_type" id="assignment_type" class="form-control">
                <? foreach($assignment_types as $row) { ?>
                    <option id="<?=$row['assignment_type_id']?>" name="<?=$row['assignment_type_id']?>" value="<?=$row['assignment_type_id']?>" <? if ($row['assignment_type_id'] == $assignment_type_id){ echo "selected=selected";}?>><?=$row['name']?></option>
                <? } ?>
              </select>
          </div>
          <div class="form-group col-md-6">
              <label for="weight">Assignment Weight:</label>
              <div class="input-group">
                <input type="decimal" class="form-control" id="weight" name="weight" value="<?=$weight?>" required/>
                <div class="input-group-addon">%</div>
              </div>
              <?= form_error('weight'); ?>
          </div>
        </div>
        <?= form_submit(array('id' => 'submit', 'value' => 'Update', 'class' => 'btn btn-success')); ?>
        <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Assignments/">Close</a>
        <?= form_close(); ?>
      </div>
    </div>
  <? } ?>
  <? if ($log){ ?>
    <div class="row">
      <div class="col-sm-8">
        <?= form_open('Assignments/log/'. $entry['assignment_id']); ?>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="time_spent">Log Time</label>
              <div class="input-group">
                <input type="decimal" id="time_spent" name="time_spent" value="<?=set_value("time_spent")?>" class="form-control" required placeholder="Enter time in hours"/>
                <div class="input-group-addon">hours</div>
              </div>
              <?= form_error('time_spent'); ?>
            </div>
          </div>
          <?= form_submit(array('id' => 'submit', 'value' => 'Log Time', 'class' => 'btn btn-success')); ?>
          <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Assignments/">Close</a>
        <?= form_close(); ?><br/>
          <div class="card mb-3">
            <p class="card-header">Previous Logs</p>
            <div class="card-body">
              <ul class="list-group list-group-flush">
                <? if ($loghistory) {?>
                <?foreach($loghistory as $log){?>
                  <li class="list-group-item">
                    <small><?=$log['date_logged']?></small>
                    <span style="float:right"><?=$log['quantity_logged']?>
                      <?if ($log['quantity_logged']== 1) {?>
                        hour
                        <?} else {?>
                          hours
                        <?}?>
                      </span>
                    </li>
                <?}?>
              <?} else { ?>
                  <p>
                    You have not logged any time on this assignment.
                  </p>
              <?  } ?>
              </ul>
          </div>
        </div>
      </div>
    </div>
  <? } ?>

  <br />
  <div class="row">
    <div class="col-sm-12">
      <?if($showAssignments){?>
      <form action="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/Assignments/updatePriority" class="form-inline" method="post" accept-charset="utf-8" style="float: right;padding-bottom:5px;">
      <div class="form-group">
        <label for="assignment_priority" style="margin-right:8px;">Assignment Priority</label>
        <select name="assignment_priority" id="assignment_priority" class="form-control" style="margin-right:8px;">
          <? foreach($assignment_priority as $row) { ?>
            <option id="<?=$row['assignment_priority_id']?>" name="<?=$row['assignment_priority_id']?>" value="<?=$row['assignment_priority_id']?>" <? if ($row['assignment_priority_id'] == $assignment_priority_id){ echo "selected=selected";}?>><?=$row['type']?></option>
          <? } ?>
        </select>
      </div>
      <button type="submit" class="btn btn-secondary">Sort</button>
      </form>
      <?}?>
      <?if($showAssignments){?>
        <table class="table table-responsive table-hover" style="overflow-y: inherit;min-height: 200px;">
          <thead>
            <tr>
              <th>Id</th>
              <th>Assignment Name</th>
              <th>Course Name</th>
              <th>Assignment Type</th>
              <th>Due Date</th>
              <th>Assignment Weight</th>
              <th>Estimated Completion Time</th>
              <th>Manage Assignment</th>
            </tr>
          </thead>
          <tbody>
            <? foreach ($assignments_list as $row) {
              if ($row['completed'] == 0){ ?>
                <tr>
                  <td><?= $row['assignment_id']?></td>
                  <td><?= $row['assignment_name']?></td>
                  <td><?= $row['course']?></td>
                  <td><?= $row['name']?></td>
                  <td><?= $row['due_date']?></td>
                  <td><?= $row['weight']?>%</td>
                  <td><?= $row['estimate_time'] ?> hours</td>
                  <td>
                    <div class="btn-group">
                      <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Select Option <span class="caret"></span>
                      </button>
                      <ul class="dropdown-menu">
                        <li>
                          <a href="<?= base_url() ?>index.php?/Assignments/edit/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-pencil" aria-hidden="true" style="padding: 5px;color:#3498DB;"></i> Edit</a>
                        </li>
                        <li>
                          <a href="<?= base_url() ?>index.php?/Assignments/log/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-hourglass-o" aria-hidden="true" style="padding: 5px;color:#F39C12;"></i> Log Time</a>
                        </li>
                        <li role="separator" class="divider"></li>
                        <li>
                          <a href="<?= base_url() ?>index.php?/Assignments/complete/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-check" aria-hidden="true" style="padding: 5px;color:#18BC9C"></i>Complete</a>
                        </li>
                        <? if ($shareable) {?>
                          <? if($row['shared'] == 0) {?>
                            <li>
                              <a href="<?= base_url() ?>index.php?/Share/display/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-share" aria-hidden="true" style="padding: 5px;color:#7D0CE8"></i>Share</a>
                            </li>
                          <? } ?>
                        <? } ?>
                        <? if($row['shared'] == 1) {?>
                          <li>
                            <a href="<?= base_url() ?>index.php?/Assignments/displayTasks/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-list-ul" aria-hidden="true" style="padding: 5px;color:#2C3E50"></i>Tasks</a>
                          </li>
                        <? } ?>
                        <li>
                          <a href="<?= base_url() ?>index.php?/Assignments/delete/<?= $row['assignment_id']?>" class="dropdown-item"><i class="fa fa-trash" aria-hidden="true" style="padding: 5px;color:#E74C3C;"></i> Delete</a>
                         </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                <tr>
                  <td colspan=8>
                    <div class="progress">
                      <div id="progressBar" class="progress-bar bg-info" role="progressbar" style="width:<?=$row['percentage_completed']?>%;"><?=$row['percentage_completed']?>%
                      </div>
                    </div>
                  </td>
                </tr>
              <? } } ?>
            </tbody>
          </table>
        <?} else { ?>
          <div class="card border-light mb-3">
            <div class="card-body">
              <h4>You dont have any assignments. Click Add Assignment above to get started.</h4>
            </div>
          </div>
        <? } ?>
    </div>
  </div>
  <br />
  <div class="row">
    <div class="col-sm-4">
      <button class="btn btn-primary" id="btnCompleted">Hide Completed</button>
    </div>
  </div>
  <br />
  <br />
  <div class="row">
    <div class="col-sm-12">
      <div id="completedAssignments">
        <h3>Completed Assignments</h3>

          <?if ($showCompleted) { ?>
          <table class="table table-hover table-responsive" >
            <tr>
            <th>Assignment Name</th>
            <th>Course Name</th>
            <th>Assignment Type</th>
            <th>Due Date</th>
            <th>Assignment Weight</th>
            <th>Time Spent</th>
            <th>Estimated Completion Time</th>
            <th></th>
            </tr>
            <? foreach ($assignments_list as $row) {
                if ($row['completed'] == 1){
              ?>
             <tr>
             <td><?= $row['assignment_name']?></td>
             <td><?= $row['course']?></td>
             <td><?= $row['name']?></td>
             <td><?= $row['due_date']?></td>
             <td><?= $row['weight']?>%</td>
             <td><?= $row['time_spent']?> hours</td>
             <td><?= $row['estimate_time']?> hours</td>
             </tr>
           <? } } ?>
          </table>
        <? } else {?>
          <div class="card border-light mb-3">
            <div class="card-body">
              <h4>You dont have any completed assignments.</h4>
            </div>
          </div>
        <?}?>
        </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="deleteModalLabel">Confirm Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        Are you sure you want to delete this assignment?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        <a class="btn btn-danger" href="<?= base_url() ?>index.php?/Assignments/delete/<?= $row['assignment_id']?>">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
$('[data-toggle="tooltip"]').tooltip();
  $("#btnCompleted").click(function() {
    $(this).text(function(i, text){
    return text === "Show Completed" ? "Hide Completed" : "Show Completed";
    });
    $("#completedAssignments").toggle('slow');
  });
</script>
