<div class="container">
  <div class="row">
    <div class="col-sm-3"></div>
    <div class="col-sm-6">
      <p><?= $msg ?></p>
      <div class="card">
        <h4 class="card-header">Reset Success</h4>
        <div class="card-body">
          <p>Your password has been successfully reset. </p>
          <?= anchor('Login', 'Return to login') ?>
      </div>
    </div>
  </div>
</div>
