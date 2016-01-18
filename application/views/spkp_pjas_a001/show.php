<script type="text/javascript">
    $(document).ready(function () {
        $("#bar_datapjas").click();
        $('#jqxTabs').jqxTabs({ width: '100%', height: '500', position: 'top', theme: theme });
    });
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div id="jqxTabs">
    <ul>
        <li id="mn_program">Program</li>
        <li id="mn_kegiatan">Kegiatan</li>
    </ul>
    <div style="padding: 10px;">
        {form_program}
    </div>
    <div style="padding: 10px;">
        {form_kegiatan}
    </div>
</div>