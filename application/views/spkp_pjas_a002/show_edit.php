<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
{form_edit}
<div id="jqxTabs">
	<ul>
		<li>Narasumber</li>
		<li>Peserta</li>
	</ul>
	<div style="padding: 2px;">
		{show_narasumber}
	</div>
	<div style="padding: 2px;">
		{show_peserta}
	</div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        $("#bar_datapjas").click();
        $('#jqxTabs').jqxTabs({ width: '1127px', height: '500', position: 'top', theme: theme });
    });
</script>
