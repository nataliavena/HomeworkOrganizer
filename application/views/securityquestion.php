<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <p><?= $msg ?></p>
      <div class="card">
        <h4 class="card-header">Security Question</h4>
        <div class="card-body">
          <?= form_open("SecurityQuestion/reset") ?>
          <div class="form-control">
          <label for="security_answer"><?=$security_question?></label>
            <input type="text" class="form-group" id="security_answer" name="security_answer" value="<?=set_value("security_answer")?>" required/>
            <?= form_error('security_answer'); ?>
          </div>
          <button class="btn btn-secondary" onclick="location.href='<?= site_url();?>/ResetPassword'">Back</button>
          <button type="submit" class="btn btn-primary" name="resetsubmit">Next</button>
          <?= form_close(); ?><br/>
      </div>
    </div>
  </div>
</div>
