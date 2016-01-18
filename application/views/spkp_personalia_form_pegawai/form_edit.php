<script type="text/javascript">
    $(document).ready(function(){
        $("#bar_personalia").click(); 
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
    });
</script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 {title}
	   </h3>
   </div>
</div>
<div>
	<div id="divProfile" style="width:98%;padding-bottom:8px;padding-top:5px">{form_profile}</div>
    <div style="width: 100%;height: <?php if($kode=="itm") echo "915px"; else echo "630px"; ?>;padding: 5px;border: 2px solid #DDDDDD">
        <div id="divLoadForm" style="display: none;"></div>
        <div id="divFormCuti">{form}</div>
    </div>
</div>