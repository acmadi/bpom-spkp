<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#bar_perpustakaan").addClass("active open");
        $("#materi").addClass("active");
        $('#jqxTabs').jqxTabs({ width: '100%', height: '500', position: 'top', theme: theme });
    });
</script>
<div id="jqxTabs">
    <ul>
        <li>Materi</li>
        <li id="mn_upload">Upload Data</li>
    </ul>
    <div style="padding: 10px;">
        {form_materi}
    </div>
    <div style="padding: 10px;">
        {form_upload}
    </div>
</div>