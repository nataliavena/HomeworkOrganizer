<div class="container">
  <div class="row" style="margin-top:60px;">
    <div class="col-sm-3"></div>
    <div class="col-sm-6 col-sm-offset-4">
      <?=$msg?>
      <?php if($this->session->flashdata('registermsg')): ?>
        <div class="alert alert-success" role="alert">
          <?php echo $this->session->flashdata('registermsg'); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>
      <div class="card border-primary mb-3">
        <div class="card-body text-primary">
          <h4 class="card-title">Login</h4>
          <form action="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/Login/loginuser" method="post" accept-charset="utf-8">
            <div class="form-group">
              <label for="username">Email address</label>
              <input type="email" class="form-control" id="username" name="username" placeholder="Enter email" value="<?=set_value('username',"")?>"/>
              <?= form_error('username');?>
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password"  placeholder="Password" value="<?=set_value('password',"")?>"/>
              <?= form_error('password');?>
            </div>
            <button type="submit"  name="loginsubmit" class="btn btn-primary">Login</button>
          </form>
          <br />
          <p>Don't have an account?
          <a href="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/Register">Register</a>
          </p>
          <p>Forgot Password?
          <a href="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/ResetPassword">Reset</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
