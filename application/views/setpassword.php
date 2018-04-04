<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <p><?= $msg ?></p>
      <div class="card">
        <h4 class="card-header">Reset Password</h4>
        <div class="card-body">
          <?= form_open("SetPassword/setPassword") ?>
          <div class="form-group">
              <label for="password">New Password:</label>
              <input type="password" class="form-control" id="password" name="password" value="<?=set_value("password")?>" required/>
              <?= form_error('password'); ?>
          </div>
          <div class="form-group">
              <label for="confirm_password">Confirm Password:</label>
              <input type="password" class="form-control" id="confirm_password" name="confirm_password" value="<?=set_value("confirm_password")?>" required/>
              <?= form_error('confirm_password'); ?>
          </div>
          <div>
          <button class="btn btn-secondary" onclick="location.href='<?= site_url();?>/SecurityQuestion'">Back</button>
          <button type="submit" class="btn btn-primary" name="resetsubmit">Next</button>
          <?= form_close(); ?><br/>
        </div>
      </div>
    </div>
  </div>
</div>
