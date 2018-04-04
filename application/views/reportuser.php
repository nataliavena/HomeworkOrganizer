<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <?php if($this->session->flashdata('reportmsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('reportmsg'); ?>
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
        <h4 class="card-header">Report User</h4>
        <div class="card-body">
          <?= form_open('ReportUser/report'); ?>
            <div class="form-group">
              <label for="email">Enter email address of user to report</label>
              <input type="email" class="form-control" id="email" name="email" value="<?=set_value("email")?>" required/>
              <?= form_error('email'); ?>
            </div>
            <div class="form-group">
              <label for="description">Reason for report (max 225 characters)</label>
              <textarea maxlength="225" rows="3" class="form-control" id="description" name="description" value="<?=set_value("description")?>" required></textarea>
              <div class="invalid-feedback">
                <?= form_error('description'); ?>
              </div>
            </div>
            <button type="submit" class="btn btn-danger">Report</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <br />
</div>
