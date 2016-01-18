<!-- BEGIN CALENDAR PORTLET-->
<script>
$(document).ready(function() {

	var source={
		datatype: 'json',
		type: 'POST',
		datafields: [
			{name:'title', type:'string'},
			{name:'start', type:'string'}
		],
		url: '<?php echo base_url(); ?>spkp/calendar'
	};
		
    var date = new Date();
    var d = date.getDate();
    var m = date.getMonth();
    var y = date.getFullYear();

    $('#calendar').fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,basicWeek,basicDay'
        },
		events: source,
		eventColor: 'red'
    });
});
</script>
<div class="widget yellow">
	<div class="widget-title">
		<h4><i class="icon-calendar"></i> Kalendar</h4>
	</div>
	<div class="widget-body">
		<div id="calendar" class="has-toolbar"></div>
	</div>
</div>
<!-- END CALENDAR PORTLET-->