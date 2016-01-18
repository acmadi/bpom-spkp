<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#bar_profile").click();
        $('#jqxTabs').jqxTabs({ width: '100%', height: '960', position: 'top', theme: theme });
    });
</script>
<div id="jqxTabs">
    <ul>
        <li>Profile</li>
        <li>Jabatan</li>
        <li>Pangkat</li>
        <li>Dokumen</li>
    </ul>
    <div style="padding: 10px;">
        {form_profile}
    </div>
    <div style="padding: 10px;">
        {form_jabatan}
    </div>
    <div style="padding: 10px;">
        {form_pangkat}
    </div>
    <div style="padding: 10px;">
        {form_dokumen}
    </div>
</div>