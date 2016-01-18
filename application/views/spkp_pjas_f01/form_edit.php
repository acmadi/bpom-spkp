<script type="text/javascript">
    $(document).ready(function(){
		$('#bar_datapjas').click();
        $("export,button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
		$("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' });
		$("input[name='tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });		
	});
	
	function export_dialog() {
		//Collecting filter information into querystring
		var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
		var filter = $("#jqxgrid_target").jqxGrid('getfilterinformation');
		k=0;
		for (i = 0; i < filter.length; i++) {
			var filters = filter[i].filter.getfilters();
			var datafield = filter[i].filtercolumn;
			for (j = 0; j < filters.length; j++) {
				var condition = filters[j].condition;
				var operator = filters[j].operator;
				datastring +='&filtervalue'+k+'=' + value + '&filtercondition'+k+'=' + condition + '&filterdatafield'+k+'=' + datafield+ '&filteroperator'+k+'='+ operator;
				k++;
			}
			datastring +='&'+datafield+'operator=and';
		}
		//Creating html view
		$.ajax({ 
			type: "POST",
			data: datastring+'&filterscount='+k + $("#frmDataSebar").serialize(),
			url: "<?php echo base_url();?>spkp_pjas_f01/export/{id}",
			success: function(response){
				//Download excel file response
				window.open("<?php echo base_url();?>spkp_loader/"+response);
			}
		 }); 		
		//END - Creating excel file
	}
	
    function save_sebar(){
        $("#divFormSebar").hide();
        $("#divloadSebar").css("display","block");
        $("#divloadSebar").html("<div style='text-align:center;'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_f01/do{action}_sebar/{id}",
           data: $("#frmDataSebar").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divloadSebar").css("display","none");
				   $("#divFormSebar").show();
                   
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divloadSebar").css("display","none");
                    $("#divFormSebar").show();
                    
                }
           } 
        });
    }
    
    function import_dialog(){
        $("#popup_content").html("<div style='text-align:center'><br><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>loading</div>");
		$("#popup").jqxWindow({
			theme: theme, resizable: false, position: { x: 400, y: 250},
            width: 500,
            height: 300,
    		isModal: true, autoOpen: false, modalOpacity: 0.2
		});
        $("#popup").jqxWindow('open');
		$.get("<?php echo base_url();?>spkp_pjas_f01/load_form_import/{id}" , function(response) {
            $("#popup_content").html("<div>"+response+"</div>");
		});        
    }
    
    function close_dialog(){
        $("#popup").jqxWindow('close');
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_f01";
    }
</script>
<div id="popup" style="display:none"><div id="popup_title">Import Form F01</div><div id="popup_content">{popup}</div></div>
<div style="display: none;" id="divloadSebar"></div>
<div id="divFormSebar" style="padding:8px; height: 225px;">
        <form method="post" id="frmDataSebar">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <button type="button" onclick="import_dialog()">Import</button>
			<button type="button" onclick="export_dialog();">Export</button>
            <button type="button" onclick="save_sebar();">Simpan</button>
        	<button type="reset">Ulang</button>
			<button type="button" onclick="back();">Kembali</button>
        </div>
        </br>
		<table width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
		<tr style="display: none;">
				<td>ID</td>
				<td align='middle'>:</td>
                <td>
                    <?php
                    if($action=="edit"){
                    ?>
                    <input type="text" size="10" maxlength="15" name="id" value="{id}" readonly=""/>
                    <?php
					}
                    ?>
                </td>
            </tr>
		<tr>
            <td width='25%'>Tanggal</td>
            <td align='middle'>:</td>
            <td>
                <div id='tanggal' name='tanggal'></div>
            </td>
        </tr>
		<tr><td>Penanggung Jawab<td></tr>
        <tr>
           <td>Nama</td>
           <td align='middle'>:</td>
           <td>
             <input class=input type="text" size="50" name="penanggungjawab_nama" id="penanggungjawab_nama" value="<?php if(set_value('penanggungjawab_nama')=="" && isset($penanggungjawab_nama)){
								 	echo $penanggungjawab_nama;
								}else{
									echo  set_value('penanggungjawab_nama');
								}?>" />
           </td>
        </tr>
		<tr>
           <td>NIP</td>
           <td align='middle'>:</td>
           <td>
             <input class=input type="text" size="20" name="penanggungjawab_nip" id="penanggungjawab_nip" value="<?php if(set_value('penanggungjawab_nip')=="" && isset($penanggungjawab_nip)){
								 	echo $penanggungjawab_nip;
								}else{
									echo  set_value('penanggungjawab_nip');
								}?>" />
           </td>
        </tr>
		<tr>
           <td>Tempat (Pembuatan Laporan)</td>
           <td align='middle'>:</td>
           <td>
             <input class=input type="text" size="20" name="tmpt" id="tmpt" value="<?php if(set_value('tmpt')=="" && isset($tmpt)){
								 	echo $tmpt;
								}else{
									echo  set_value('tmpt');
								}?>" />
           </td>
        </tr>
	</table>
    </form>
</div>