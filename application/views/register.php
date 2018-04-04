<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <div class="card">
        <h4 class="card-header">Register</h4>
        <div class="card-body">
          <form action="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/Register/addUser" method="post" accept-charset="utf-8" id="registerForm">
              <div class="form-group">
                <label for="first_name">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" value="<?=set_value("first_name")?>" required/>
                <?= form_error('first_name'); ?>
              </div>
              <div class="form-group">
                <label for="last_name">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" value="<?=set_value("last_name")?>" required/>
                <?= form_error('last_name'); ?>
              </div>
              <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?=set_value("email")?>" required/>
                <?= form_error('email'); ?>
              </div>
              <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" value="<?=set_value("password")?>" required/>
                <?= form_error('password'); ?>
              </div>
              <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?=set_value("confirm_password")?>" required/>
                <?= form_error('confirm_password'); ?>
              </div>
              <div class="form-group">
                <label for="security_question">Security Question</label>
                <select name="security_question" id="security_question" class="form-control">
                  <? foreach($security_questions as $row) { ?>
                    <option id="<?=$row['security_question_id']?>" name="<?=$row['security_question_id']?>" value="<?=$row['security_question_id']?>"><?=$row['name']?></option>
                  <? } ?>
                </select>
              </div>
              <div class="form-group">
                <label for="security_answer">Security Answer</label>
                <input type="text" id="security_answer" class="form-control" name="security_answer" value="<?=set_value("security_answer")?>" required/>
                <?= form_error('security_answer'); ?>
              </div>
                        <a class="btn btn-secondary" href='<?= base_url();?>'>Back</a>
          <?= form_submit(array('id' => 'submit', 'value' => 'Submit', 'class' => 'btn btn-primary')); ?>
          <button type="reset" class="btn btn-secondary" value="Reset">Reset</button>
          <?= form_close(); ?>
        </div>
      </div>
    </div>
  </div>
</div>
