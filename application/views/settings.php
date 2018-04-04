<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <?php if($this->session->flashdata('updatemsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('updatemsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div class="card">
        <h3 class="card-header">Settings</h3>
        <div class="card-body">
          <?= form_open('Settings/updateUser'); ?>
            <div class="form-group">
              <label for="email">Email address</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=$email;?>" readonly/>
            </div>
            <div class="form-group">
              <label for="first_name">First name</label>
              <input type="first_name" class="form-control" id="first_name" name="first_name" value="<?=$first_name;?>" required/>
              <div class="invalid-feedback">
                <?= form_error('first_name'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="last_name">Last name</label>
              <input type="last_name" class="form-control" id="last_name" name="last_name" value="<?=$last_name;?>" required/>
              <div class="invalid-feedback">
                <?= form_error('last_name'); ?>
              </div>
            </div>
            <div class="form-group">
              <label for="security_question">Security Question</label>
              <select name="security_question" id="security_question" class="form-control">
                <? foreach($security_questions as $row) { ?>
                  <option id="<?=$row['security_question_id']?>" name="<?=$row['security_question_id']?>" value="<?=$row['security_question_id']?>" <? if ($row['security_question_id'] == $security_question_id){ echo "selected=selected";}?>><?=$row['name']?></option>
                <? } ?>
              </select>
            </div>
            <div class="form-group">
                <label for="security_answer">Security Answer</label>
                <input type="text" class="form-control" id="security_answer" name="security_answer" value="<?=$security_answer?>" required/>
                <div class="invalid-feedback">
                  <?= form_error('security_answer'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="calendar_view">Default Calendar View</label>
                <select name="calendar_view" id="calendar_view" class="form-control">
                  <? foreach($calendar_view as $view) { ?>
                    <option id="<?=$view['view_id']?>" name="<?=$view['view_id']?>" value="<?=$view['view_id']?>" <? if ($view['view_id'] == $calendar_view_id){ echo "selected=selected";}?>><?=$view['view']?></option>
                  <? } ?>
                </select>
            </div>
            <div class="form-group">
              <label for="assignment_priority">Assignment Priority</label>
              <select name="assignment_priority" id="assignment_priority" class="form-control">
                <? foreach($assignment_priority as $row) { ?>
                  <option id="<?=$row['assignment_priority_id']?>" name="<?=$row['assignment_priority_id']?>" value="<?=$row['assignment_priority_id']?>" <? if ($row['assignment_priority_id'] == $assignment_priority_id){ echo "selected=selected";}?>><?=$row['type']?></option>
                <? } ?>
              </select>
            </div>
            <button type="submit" class="btn btn-success">Update</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <br />
  <div class="row">
    <div class="col-sm-12">
      <div style="float:right;">
        <a href="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/ReportUser">Report User</a>
      </div>
    </div>
  </div>
</div>

<!-- <script type="text/javascript">
  $(".alert").alert()
</script> -->
