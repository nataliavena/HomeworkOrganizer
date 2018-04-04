<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <p><?= $msg ?></p>
      <div class="card">
        <h4 class="card-header">Enter email</h4>
        <div class="card-body">
          <?= form_open("ResetPassword/checkEmail") ?>
          <div class="form-group">
            <label for"email">Enter email for registered account</label>
            <input type="email" class="form-control" id="email" name="email" value="<?=set_value("email")?>" required/>
            <?= form_error('email'); ?>
          </div>
          <button class="btn btn-secondary" onclick="location.href='<?= base_url();?>'">Back</button>
          <button type="submit" class="btn btn-primary" name="resetsubmit">Next</button>
          <?= form_fieldset_close(); ?>
          <?= form_close() ?>
        </div>
      </div>
    </div>
  </div>
</div>
