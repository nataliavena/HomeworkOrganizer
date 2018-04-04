<div class="container">
  <br />
  <div class="row">
    <div class="col">
      <?php if($this->session->flashdata('createmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('createmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('addtaskmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('addtaskmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('completetaskmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('completetaskmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('deletetaskmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('deletetaskmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <?php if($this->session->flashdata('deleteassmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('deleteassmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <h3>Shared Dashboard</h3>
    </div>
  </div>
  <div class="row">
    <?if($shared == 1){?>
    <div class="col-sm-6">
      <div class="card border-light mb-3">
        <div class="card-body">
          <div class="row">
            <div class="col-sm-6">
              <h4 class="card-title"><?=$name?> - <?=$course?></span>
              </div>
              <div class="col-sm-6">
                <p style="float:right;">Due: <?=$due_date?></p>
              </div>
            </div>
            <div class="row">
              <div class="col-sm-12">
                <span class="card-text">Progress</span>
                <div class="progress">
                  <div id="progressBar" class="progress-bar bg-info" role="progressbar" style="width:<?=$percentage_completed?>%;"><?=$percentage_completed?>%</div>
                </div>
              </div>
            </div>
            <br />
            <div class="row">
              <div class="col">
                <? if ($addtask) {?>
                  <div>
                    <?= form_open('Dashboard/addTasks/'.$assignment_id)?>
                      <div class="form-row">
                        <div class="form-group">
                          <label for="task">Task Description</label>
                          <input type="text" id="task" name="task" value="<?=set_value("task")?>" class="form-control"  required/>
                          <?= form_error('task'); ?>
                        </div>
                      <div class="form-group">
                        <label for="user_list">Assign User</label>
                        <select name="user_list" id="user_list" class="form-control">
                          <? foreach($sharedusers as $row) { ?>
                            <option value="<?=$row['user_id']?>"><?=$row['email']?></option>
                          <? } ?>
                        </select>
                      </div>
                      <div class="form-group col-sm-2">
                        <label for="dependency">Priority</label>
                        <input type="decimal" id="dependency" name="dependency" value="<?=set_value("dependency")?>" class="form-control" min="1" max="100" required/>
                        <?= form_error('dependency'); ?>
                      </div>
                    </div>
                      <?= form_submit(array('id' => 'submit', 'value' => 'Add Task', 'class' => 'btn btn-success')); ?>
                      <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Dashboard/">Close</a>
                    <?= form_close(); ?><br/>
                  </div>
                <? } ?>

                <? if($adduser) {?>
                  <?= form_open('Dashboard/addUser/'.$assignment_id)?>
                    <div class="form-row">
                      <div class="form-group col-md-6">
                        <select name="availableusers" id="availableusers" class="form-control">
                          <? foreach($availableusers as $row) { ?>
                            <option value="<?=$row['user_id']?>"><?=$row['email']?></option>
                          <? } ?>
                        </select>
                      </div>
                    </div>
                    <?= form_submit(array('id' => 'submit', 'value' => 'Add User', 'class' => 'btn btn-success')); ?>
                    <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Dashboard/">Close</a>
                  <?= form_close(); ?><br/>
                <? } ?>
                <br />
                <div class="row">
                  <div class="col-sm-12">
                  <div class="list-group">
                    <span class="list-group-item list-group-item-action flex-column align-items-start active">Tasks (ordered by priority)</span>
                  <? foreach($tasks as $task) { ?>
                  <?  if ($task['complete'] == 0){ ?>
                      <span class="list-group-item list-group-item-action flex-column align-items-start" style="color: black;">
                        <div class="d-flex w-100 justify-content-between">
                          <h5 class="mb-1"><?=$task['description']?></h5>
                          <? if ($task['user_id'] == $_SESSION['userid']) { ?>
                            <? if ($task['dependency'] == $lowestdependency) { ?>
                              <small class="text-muted">
                                <a title="Complete" href="<?= base_url() ?>index.php?/Dashboard/completeTask/<?=$task['task_id']?>"><i class="fa fa-check" aria-hidden="true" style="padding-right:5px;"></i></a>
                                <a title="Delete" href="<?= base_url() ?>index.php?/Dashboard/deleteTask/<?=$task['task_id']?>"><i class="fa fa-trash" aria-hidden="true" style="padding: 5px;color:#E74C3C;"></i></a>
                              </small>
                            <? }  else {?>
                              <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="You can only complete this task when the previous task is complete"><i class="fa fa-question" aria-hidden="true"></i></span>
                            <? }?>
                        <?} else {?>
                            <span data-toggle="tooltip" data-placement="bottom" title="" data-original-title="You can only complete this task if it is assigned to you"><i class="fa fa-question" aria-hidden="true"></i></span>
                        <?  }?>
                        </div>
                        <small class="text-muted"><?=$task['email']?></small>
                      </span>
                  <? } if ($task['complete'] == 1){?>
                    <span class="list-group-item list-group-item-action flex-column align-items-start disabled">
                      <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1"><?=$task['description']?></h5>
                        <small class="text-muted">
                          Complete
                        </small>
                      </div>
                      <small class="text-muted"><?=$task['email']?></small>
                    </span>
                  <? } ?>
                <? } ?>
                  </div>
                  <br />
                  <div>
                    <a class="btn btn-primary" href="<?= base_url() ?>index.php?/Dashboard/addUser/<?=$assignment_id?>">Add User</a>
                    <a class="btn btn-primary" href="<?= base_url() ?>index.php?/Dashboard/addTasks/<?=$assignment_id?>">Add Task</a>
                    <button class="btn btn-secondary" data-toggle="modal" data-target="#deleteModal">Delete Assignment</button>
                  </div>
                </div>
              </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col">
        <?if($shared == 1){?>
        <div class="row">
          <div class="col">
            <div class="card">
              <div class="card-header">Chat</div>
              <div class="card-body">
                <p id="displayMsgs" class="card-text" style="height:150px;overflow-y:scroll;"></p>
                <?= form_open('Dashboard/sendChat/'.$assignment_id)?>
                  <div class="form-row">
                    <div class="form-group">
                      <div class="input-group" style="width:160%">
                        <input type="text" id="msg" name="msg" value="<?=set_value("msg")?>" class="form-control" required placeholder="type message"/>
                        <div class="input-group-addon">
                          <?= form_submit(array('id' => 'submit', 'value' => 'Send', 'class' => 'btn btn-primary')); ?>
                        </div>
                      </div>
                      <?= form_error('msg'); ?>
                    </div>
                  </div>
                  <?=form_close()?>
              </div>
          </div>
        </div>
      </div>
      <br />
      <div class="row">
        <div class="col">
          <ul class="list-group">
            <span class="list-group-item d-flex justify-content-between align-items-center active" >Users on Assignment </span>
            <? foreach($users as $user){?>
            <li class="list-group-item d-flex justify-content-between align-items-center">
              <?=$user['email']?>
            </li>
            <?}?>
          </ul>
        </div>
      </div>
      <?}?>
      </div>
    <? } else {?>
      <div class="col-sm-12">
        <div class="card border-light mb-3">
          <div class="card-body">
            <h4>You have no shared assignments. <br />
            Click 'Share' from the <a href="<?=base_url()?>index.php?/Assignments">Assignments page</a> to get started</h4>
          </div>
        </div>
      </div>
    <? }?>
    </div>


  <div class="modal" id="deleteModal">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this assignment?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <a href="<?= base_url() ?>index.php?/Dashboard/delete/<?=$assignment_id?>" class="btn btn-danger">Delete</a>
      </div>
    </div>
  </div>
</div>

<script>
  $('#displayMsgs').val('');
<? if ($assignment_id != ''){ ?>
    function sendMail() {
         xmlhttp = new XMLHttpRequest();
         xmlhttp.open("GET","<?php echo site_url('Dashboard/getChat/'.$assignment_id); ?>",false);
         xmlhttp.send(null);
        document.getElementById("displayMsgs").innerHTML = xmlhttp.responseText;
    }
    setInterval(function () {
        sendMail();
    }, 2000);
    <?}?>
    $("[data-toggle=popover]").popover();
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>
