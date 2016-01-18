<script>
	$(function(){
       $("#bar_personalia").click();
       $('#jqxTabs').jqxTabs({ width: '100%', height:'920px', position: 'top', theme: theme });
       $("input[type='button']").jqxButton({ height: 28, theme: theme });
       
    });   
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div id="popup" style="display:none"><div id="popup_title">{title}</div><div id="popup_content">{popup}</div></div>
<div id="jqxTabs">
    <ul>
        <li>Cuti Pegawai</li>
        <li>Daftar Hari Libur & Cuti Bersama</li>
    </ul>
    <div style="padding: 2px;">
		{form_cuti}
	</div>
    <div style="padding: 2px;">
		{form_cuti_bersama}
	</div>
</div>