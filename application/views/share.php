<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <h1>Share Assignment</h1>
    </div>
  </div>
    <br />
  <div class="row">
    <div class="col-sm-12">
      <p>Select from a list of available users <span class="text-muted"><small>(You can add more later)</small></span></p>
      <? if(count($availableusers) != 0) {?>
      <?= form_open('Share/addUsers/'.$_SESSION['assignment_id'])?>
      <div class="form-row">
        <div class="form-group col-md-6">
          <select name="availableusers" id="availableusers" class="form-control">
            <? foreach($availableusers as $row) { ?>
              <option value="<?=$row['user_id']?>"><?=$row['email']?></option>
            <? } ?>
          </select>
        </div>
      </div>
        <a id="submit" class="btn btn-secondary" href="<?= base_url() ?>index.php/Assignments/">Back</a>
        <?= form_submit(array('id' => 'submit', 'value' => 'Add Users', 'class' => 'btn btn-success')); ?>
      <?= form_close(); ?><br/>
      <?} else {?>
        <h4>There are no available users to share with.</h4>
      <? }?>
    </div>
  </div>
</div>
