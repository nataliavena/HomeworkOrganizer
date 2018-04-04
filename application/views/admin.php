<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <? if($this->session->flashdata('createmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('createmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('editmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('editmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('deletemsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('deletemsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('editreportmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('editreportmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
      <? if($this->session->flashdata('deletereportmsg')){ ?>
        <div class="alert alert-success" role="alert">
          <? echo $this->session->flashdata('deletereportmsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?}?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-6">
      <div>
        <h3>Users</h3>
      </div>
    </div>
    <div class="col-sm-6">
      <br />
      <? if ($toggleBtn) {?>
        <div style="float:right;">
          <a class="btn btn-warning" href="<?= base_url() ?>index.php/Admin/create">Add New User</a>
        </div>
      <?}?>
    </div>
  </div>
  <br />
  <? if ($create) {?>
  <div class="row">
    <div class="col-sm-8">
      <?= form_open('Admin/create'); ?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="first_name">First Name</label>
          <input type="text" class="form-control" id="first_name" name="first_name" value="<?=set_value("first_name")?>" required/>
          <div class="">
              <?= form_error('first_name'); ?>
          </div>
        </div>
        <div class="form-group col-md-6">
          <label for="last_name">Last Name</label>
          <input type="text" class="form-control" id="last_name" name="last_name" value="<?=set_value("last_name")?>" required/>
          <?= form_error('last_name'); ?>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="email">Email</label>
          <input type="text" class="form-control" id="email" name="email" value="<?=set_value("email")?>" required/>
          <?= form_error('email'); ?>
        </div>
        <div class="form-group col-md-6">
          <label for="accesslevel">Access Level</label>
            <select name="accesslevel" id="accesslevel" class="form-control">
              <option id="member" name="member" value="member" <? if ("member" == $accesslevel){ echo "selected=selected";}?>>Member</option>
              <option id="admin" name="admin" value="admin" <? if ("admin" == $accesslevel){ echo "selected=selected";}?>>Admin</option>
            </select>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="password">Password</label>
          <input type="password" class="form-control" id="password" name="password" value="<?=set_value("password")?>" required/>
          <?= form_error('password'); ?>
        </div>
        <div class="form-group col-md-6">
          <label for="confirm_password">Confirm Password</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?=set_value("confirm_password")?>" required/>
          <?= form_error('confirm_password'); ?>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
          <label for="security_question">Security Question</label>
          <select name="security_question" id="security_question" class="form-control">
            <? foreach($security_questions as $row) { ?>
              <option id="<?=$row['security_question_id']?>" name="<?=$row['security_question_id']?>" value="<?=$row['security_question_id']?>"><?=$row['name']?></option>
            <? } ?>
          </select>
        </div>
        <div class="form-group col-md-6">
          <label for="security_answer">Security Answer</label>
          <input type="text" id="security_answer" class="form-control" name="security_answer" value="<?=set_value("security_answer")?>" required/>
          <?= form_error('security_answer'); ?>
        </div>
      </div>
      <div class="form-row">
        <div class="form-group col-md-6">
            <label for="calendar_view">Default Calendar View</label>
            <select name="calendar_view" id="calendar_view" class="form-control">
              <? foreach($calendar_view as $view) { ?>
                <option id="<?=$view['view_id']?>" name="<?=$view['view_id']?>" value="<?=$view['view_id']?>"><?=$view['view']?></option>
              <? } ?>
            </select>
        </div>
        <div class="form-group col-md-6">
          <label for="assignment_priority">Assignment Priority</label>
          <select name="assignment_priority" id="assignment_priority" class="form-control">
            <? foreach($assignment_priority as $row) { ?>
              <option id="<?=$row['assignment_priority_id']?>" name="<?=$row['assignment_priority_id']?>" value="<?=$row['assignment_priority_id']?>"><?=$row['type']?></option>
            <? } ?>
          </select>
        </div>
      </div>
      <button type="submit" value="Submit" id="submit" class="btn btn-warning">Submit</button>
      <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Admin/">Close</a>
      <?= form_close(); ?><br/>
    </div>
  </div>
  <? } ?>
  <? if ($edit) {?>
    <div class="row">
      <div class="col-sm-8">
        <?= form_open('Admin/edit/'. $entry['user_id']); ?>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="first_name">First Name</label>
            <input type="text" class="form-control" id="first_name" name="first_name" value="<?=$first_name;?>" required/>
            <div class="">
                <?= form_error('first_name'); ?>
            </div>
          </div>
          <div class="form-group col-md-6">
            <label for="last_name">Last Name</label>
            <input type="text" class="form-control" id="last_name" name="last_name" value="<?=$last_name;?>" required/>
            <?= form_error('last_name'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-6">
            <label for="email">Email</label>
            <input type="text" class="form-control" id="email" name="email" value="<?=$email;?>" disabled/>
            <?= form_error('email'); ?>
          </div>
          <div class="form-group col-md-6">
            <label for="accesslevel">Access Level</label>
              <select name="accesslevel" id="accesslevel" class="form-control">
                <option id="member" name="member" value="member" <? if ("member" == $accesslevel){ echo "selected=selected";}?>>Member</option>
                <option id="admin" name="admin" value="admin" <? if ("admin" == $accesslevel){ echo "selected=selected";}?>>Admin</option>
              </select>
          </div>
        </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="security_question">Security Question</label>
              <select name="security_question" id="security_question" class="form-control">
                <? foreach($security_questions as $row) { ?>
                    <option id="<?=$row['security_question_id']?>" name="<?=$row['security_question_id']?>" value="<?=$row['security_question_id']?>" <? if ($row['security_question_id'] == $security_question_id){ echo "selected=selected";}?>><?=$row['name']?></option>
                <? } ?>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="security_answer">Security Answer</label>
              <input type="text" id="security_answer" class="form-control" name="security_answer" value="<?=$security_answer?>" required/>
              <?= form_error('security_answer'); ?>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
                <label for="calendar_view">Default Calendar View</label>
                <select name="calendar_view" id="calendar_view" class="form-control">
                  <? foreach($calendar_view as $view) { ?>
                    <option id="<?=$view['view_id']?>" name="<?=$view['view_id']?>" value="<?=$view['view_id']?>" <? if ($view['view_id'] == $calendar_view_id){ echo "selected=selected";}?>><?=$view['view']?></option>
                  <? } ?>
                </select>
            </div>
            <div class="form-group col-md-6">
              <label for="assignment_priority">Assignment Priority</label>
              <select name="assignment_priority" id="assignment_priority" class="form-control">
                <? foreach($assignment_priority as $row) { ?>
                  <option id="<?=$row['assignment_priority_id']?>" name="<?=$row['assignment_priority_id']?>" value="<?=$row['assignment_priority_id']?>" <? if ($row['assignment_priority_id'] == $assignment_priority_id){ echo "selected=selected";}?>><?=$row['type']?></option>
                <? } ?>
              </select>
            </div>
          </div>
          <button type="submit" value="Submit" id="submit" class="btn btn-warning">Update</button>
          <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Admin/">Close</a>
          <?= form_close(); ?><br/>
      </div>
    </div>
   <?}?>
  <div class="row">
    <div class="col-sm-12">
      <table class="table table-responsive table-hover">
        <thead>
          <tr>
            <th scope="col">ID</th>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Email</th>
            <th scope="col">Security Question</th>
            <th scope="col">Security Answer</th>
            <th scope="col">Access Level</th>
            <th scope="col">Assignment Priority</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          <? foreach ($users_list as $row) {?>
            <tr>
              <td scope="row"><?= $row['user_id']?></td>
              <td><?= $row['first_name']?></td>
              <td><?= $row['last_name']?></td>
              <td><?= $row['email']?></td>
              <td><?= $row['name']?></td>
              <td><?= $row['security_answer']?></td>
              <td><?= $row['accesslevel']?></td>
              <td><?= $row['type']?></td>
              <td>
                <a class="btn btn-primary" href="<?= base_url() ?>index.php?/Admin/edit/<?= $row['user_id']?>"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                <a href="<?= base_url() ?>index.php?/Admin/delete/<?= $row['user_id']?>" class="btn btn-secondary"><i class="fa fa-trash" aria-hidden="true"></i></a>
              </td>
            </tr>
          <? } ?>
        </tbody>
      </table>
    </div>
  </div>
  <br />
  <div class="row">
    <div class="col-sm-4">
      <button class="btn btn-primary" id="btnToggleReported">Hide Reported Users</button>
    </div>
  </div>
  <br />
  <div id="reportedUsers">
        <? if ($editReportedUser) {?>
          <div class="row">
            <div class="col">
              <?= form_open('Admin/editReportedUser/'. $reported_user_id['id']); ?>
              <div class="form-row">
                <div class="form-group col-md-6">
                  <label for="description">Description</label>
                  <input type="text" class="form-control" id="description" name="description" value="<?=$description;?>" required/>
                  <?= form_error('description'); ?>
                  <button type="submit" value="Submit" id="submit" class="btn btn-warning">Update</button>
                  <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Admin/">Close</a>
                <?= form_close(); ?><br/>
            </div>
          </div>
         <?}?>
    <div class="row">
      <div class="col-sm-12">
        <div>
          <h2>Reported Users</h2>
        </div>
      </div>
    </div>
    <br />
    <div class="row">
      <div class="col-sm-12">
        <table class="table table-responsive table-hover">
          <thead>
            <tr>
              <th scope="col">ID</th>
              <th scope="col">Reporter</th>
              <th scope="col">Reported User</th>
              <th scope="col">Description</th>
              <th></th>
            </tr>
          </thead>
          <tbody>
            <? foreach ($reported_users as $row) {?>
              <tr>
                <td scope="row"><?= $row['id']?></td>
                <td><?= $row['reporter']?></td>
                <td><?= $row['reported_user_email']?></td>
                <td colspan=4><?= $row['description']?></td>
                <td>
                  <a href="<?= base_url() ?>index.php?/Admin/editReportedUser/<?= $row['id']?>" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                  <a href="<?= base_url() ?>index.php?/Admin/deleteReportedUser/<?= $row['id']?>" class="btn btn-secondary"><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
              </tr>
            <? } ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
<script>
  $("#btnToggleReported").click(function() {
    $(this).text(function(i, text){
    return text === "Show Reported Users" ? "Hide Reported Users" : "Show Reported Users";
    });
    $("#reportedUsers").toggle('slow');
  });
</script>
