<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <h2>Share Assignment</h2>
    </div>
  </div>
    <br />
  <div class="row">
    <div class="col-sm-12">
      <?= form_open('AddTasks/addTasks')?>
      <h4>Add tasks for users</h4>
        <div class="form-row">
          <div class="form-group col-md-5">
            <label for="task1"><strong>Task Description</strong></label>
           <input type="text" id="task1" name="task1" value="<?=set_value("task1")?>" class="form-control" required/>
            <?= form_error('task1'); ?>
          </div>
          <div class="form-group">
            <label for="user_list1"><strong>Assign User to Task</strong></label>
            <select name="user_list1" id="user_list1" class="form-control">
              <? foreach($sharedusers as $row) { ?>
                <option value="<?=$row['user_id']?>"><?=$row['email']?></option>
              <? } ?>
            </select>
          </div>
          <div class="form-group col-md-2">
            <label for="dependency1"><strong>Order of Completion</strong></label>
            <input type="number" id="dependency1" name="dependency1" value="<?=set_value("dependency1")?>" class="form-control" min="1" max="100" required/>
            <?= form_error('dependency1'); ?>
          </div>
        </div>
        <div class="form-row">
          <div class="form-group col-md-5">
            <input type="text" id="task2" name="task2" value="<?=set_value("task2")?>" class="form-control" required/>
            <?= form_error('task2'); ?>
          </div>
          <div class="form-group">
            <select name="user_list2" id="user_list2" class="form-control">
              <? foreach($sharedusers as $row) { ?>
                <option value="<?=$row['user_id']?>"><?=$row['email']?></option>
              <? } ?>
            </select>
          </div>
          <div class="form-group col-md-2">
            <input type="number" id="dependency2" name="dependency2" value="<?=set_value("dependency2")?>" class="form-control "min="1" max="100" required/>
            <?= form_error('dependency2'); ?>
          </div>
                      <a href="javascript:void(0);" class="add_button" title="Add field">Add Field</a>
        </div>
        <div class="field_wrapper">
        <div>

        </div>
      </div>
        <?= form_submit(array('id' => 'submit', 'value' => 'Next', 'class' => 'btn btn-success')); ?>
      <?= form_close(); ?><br/>
    </div>
  </div>
</div>
<script type="text/javascript">
$(document).ready(function(){
    var maxField = 10; //Input fields increment limitation
    var addButton = $('.add_button'); //Add button selector
    var wrapper = $('.field_wrapper'); //Input field wrapper

    //New input field html
    var fieldHTML = '<div class="form-row"><div class="form-group col-md-5"><input type="text" id="tasks[]" name="tasks[]" value="<?=set_value("tasks[]", '')?>" class="form-control" required/><?= form_error("tasks[]"); ?></div><div class="form-group"><select name="user_list[]" id="user_list[]" class="form-control"><? foreach($sharedusers as $row) { ?><option value="<?=$row['user_id']?>"><?=$row['email']?></option><? } ?></select></div><div class="form-group col-md-2"><input type="number" id="dependency[]" name="dependency[]" value="<?=set_value("dependency[]")?>" class="form-control" min="1" max="100" required/><?= form_error('dependency[]'); ?></div><a href="javascript:void(0);" class="remove_button" title="Remove field">Remove</a></div>';

    var x = 1; //Initial field counter is 1
    $(addButton).click(function(){ //Once add button is clicked
        if(x < maxField){ //Check maximum number of input fields
            x++; //Increment field counter
            $(wrapper).append(fieldHTML); // Add field html
        }
    });
    $(wrapper).on('click', '.remove_button', function(e){ //Once remove button is clicked
        e.preventDefault();
        $(this).parent('div').remove(); //Remove field html
        x--; //Decrement field counter
    });
});
</script>
