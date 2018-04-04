<div class="container">
  <br />
  <div class="row">
    <div class="col-sm-12">
      <div class="card border-light mb-3">
        <div class="card-header">
          Assignments
          <span style="float:right;font-size:20px;" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="Your top two assignments will show here in the summary view.  Assignments will display on the calendar in grey for completed and orange for current."><i class="fa fa-question" aria-hidden="true"></i></span>
        </div>
        <div class="card-body">
          <? if($showAssignments){?>
          <h4 class="card-title">Summary</h4>
          <p class="card-text">
            <? foreach ($assignments_list as $row) {
              if ($row['completed'] == 0){ ?>
                <div class="row">
                  <div class="col-sm-12">
                    <div>
                      <p>
                        <?=$row['course']?> <?=$row['name']?> - Due date: <?=$row['due_date']?>
                      </p>
                      <div class="progress">
                        <div id="progressBar" class="progress-bar bg-info" role="progressbar" style="width:<?=$row['percentage_completed']?>%;"><?=$row['percentage_completed']?>%
                        </div>
                      </div>
                      <br />
                    </div>
                  </div>
                </div>
            <? } ?>
          <? }?>
          </p>
          <div class="row">
            <div class="col-sm-12">
              <form action="https://csunix.mohawkcollege.ca/~000350911/private/homeworkOrganizer/index.php/Home/updatePriority" class="form-inline" method="post" accept-charset="utf-8" style="float:right;">
              <div class="form-group">
                <label for="assignment_priority" style="margin-right:8px;">Assignment Priority</label>
                <select name="assignment_priority" id="assignment_priority" class="form-control" style="margin-right:8px;">
                  <? foreach($assignment_priority as $row) { ?>
                    <option id="<?=$row['assignment_priority_id']?>" name="<?=$row['assignment_priority_id']?>" value="<?=$row['assignment_priority_id']?>" <? if ($row['assignment_priority_id'] == $assignment_priority_id){ echo "selected=selected";}?>><?=$row['type']?></option>
                  <? } ?>
                </select>
              </div>
              <button type="submit" class="btn btn-primary">Sort</button>
              </form>
            </div>
          </div>
          <?} else {?>
          <h4>You don't have any assignments. Go to the <a href="<?=base_url()?>index.php?/Assignments">Assignments page</a> to get started.</h4>
          <?}?>
        </div>
      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-sm-12">
      <div id="calendar"></div>
    </div>
  </div>
</div>
<script>
      $(document).ready(function() {
            $('[data-toggle="tooltip"]').tooltip();
            // page is now ready, initialize the calendar...
            $('#calendar').fullCalendar({
                  themeSystem: 'standard',
                  header: {
                        left: 'prev,next, today',
                        center: 'title',
                        right: 'month,basicWeek,basicDay'
                  },
                  defaultView: '<?=$view?>',
                  navLinks: true, // can click day/week names to navigate views
                  editable: true,
                  eventLimit: true, // allow "more" link when too many events
                  eventSources: [
                      // your event source
                      {
                          events: <?=$encoded?>
                      }
                      // any other event sources...
                  ]
            });
      });
</script>
