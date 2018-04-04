$(document).ready(function() {

	// assignments.php
	$("#completedAssignments").hide();
	$("#btnCompleted").click(function() {
		$("#completedAssignments").show();
	});

	// admin.php
	$("#reportedUsers").hide();
	$("#btnToggleReported").click(function() {
		$("#reportedUsers").show();
	});

	// home.php
	// page is now ready, initialize the calendar...
	$('#calendar').fullCalendar({
		themeSystem: 'standard',
		header: {
			left: 'prev,next, today',
			center: 'title',
			right: 'month,basicWeek,basicDay'
		},
		navLinks: true, // can click day/week names to navigate views
		editable: true,
		eventLimit: true, // allow "more" link when too many events
		eventSources: [
			// your event source
			{
				// events: <?=$encoded?>,
				events: 'Home/calendarAssignments',
				color: '#18BC9C', // an option!
				textColor: 'white' // an option!
			}
			// any other event sources...
		]
	});
});
