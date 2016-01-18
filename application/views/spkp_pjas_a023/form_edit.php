<script type="text/javascript">
    $(document).ready(function(){
        $("export,button,submit,reset").jqxInput({ theme: 'fresh', height: '25px', width: '54px' });
		$("input[name='penanggungjawab_jabatan']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '250px' });
		$("input[name='penanggungjawab_nip']").jqxMaskedInput({ theme: theme, height: '22px', width: '175px', mask: '######## ###### # ###' });
		$("input[name='tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '100px' });
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '22px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
	});
		
	function export_dialog() {
		//Collecting filter information into querystring
		var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
		var filter = $("#jqxgridsdmi").jqxGrid('getfilterinformation');
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
		//END - Collecting filter information into querystring

		//Creating html view
		$.ajax({ 
			type: "POST",
			data: datastring+'&filterscount='+k + $("#frmData").serialize(),
			url: "<?php echo base_url();?>spkp_pjas_a023/export/{id}",
			success: function(response){
				//Download excel file response
				window.open("<?php echo base_url();?>spkp_loader/"+response);
			}
		 }); 		
		//END - Creating excel file
	}
		
    function edit_dialog(){
        $("#divForm").hide();
        $("#divload").css("display","block");
        $("#divload").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a023/doedit/{id}",
           data: $("#frmData").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divload").css("display","none");
				   $("#divForm").show();
                   
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divload").css("display","none");
					$("#divForm").show();
                }
           } 
        });
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a023";
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
		$.get("<?php echo base_url();?>spkp_pjas_a023/load_form_import/{id}" , function(response) {
            $("#popup_content").html("<div>"+response+"</div>");
		});        
    }
    
    function close_dialog(){
        $("#popup").jqxWindow('close');
    }
</script>
<div id="popup" style="display:none"><div id="popup_title">Import Form A023</div><div id="popup_content">{popup}</div></div>
<div style="display: none;" id="divload"></div>
<div id="divForm" style="height: 225; padding:8px">
	<form method="post" id="frmData">
	<div style="background: #F4F4F4;padding: 5px;text-align: right;">
        <button type="button" onclick="import_dialog()">Import</button>
        <button type="button" onclick="export_dialog();">Export</button>
		<button type="button" onclick="edit_dialog();">Simpan</button>
		<button type="reset">Ulang</button>
		<button type="button" onclick="back();">Kembali</button>
	</div>
	</br>
	<table width='100%'><tr valign="top"><td width='40%'>
		<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
			<tr style="display: none;">
				<td width='40%'>ID</td>
				<td width='1%' align='middle'>:</td>
				<td>
					<input type="text" size="10" maxlength="15" name="id" value="{id}" readonly=""/>
				</td>
			</tr>
			<tr style="display: none;">
				<td width='40%'>Propinsi</td>
				<td width='1%' align='middle'>:</td>
				<td>
					<input type="text" size="10" maxlength="15" name="propinsi" value="{nama_propinsi}" readonly=""/>
				</td>
			</tr>
			<tr style="display: none;">
				<td width='40%'>Balai</td>
				<td width='1%' align='middle'>:</td>
				<td>
					<input type="text" size="10" maxlength="15" name="balai" value="{nama_balai}" readonly=""/>
				</td>
			</tr>
			<tr>
				<td width='20%'>Propinsi</td>
				<td align='middle'>:</td>
				<td>
					<select size="1" class="input" name="id_provinsi" id="id_provinsi" style="width: 250px;margin: 0;">
					<?php
						$propinsi = $this->spkp_pjas_a023_model->get_all_propinsi();
						foreach($propinsi as $row_propinsi){
						?>
						   <option value="<?php echo $row_propinsi->id_propinsi; ?>" <?php if($row_propinsi->id_propinsi==$id_provinsi) echo "Selected"; ?>><?php echo $row_propinsi->nama_propinsi; ?></option>
						<?php
						}
					?>
					</select> *
				</td>
			</tr>
			<tr>
				<td>Tanggal</td>
				<td align='middle'>:</td>
				<td>
					<div id='tanggal' name='tanggal'></div>
				</td>
			</tr>
			<tr>
				<td>Balai</td>
				<td align='middle'>:</td>
				<td>
					<select size="1" class="input" name="id_balai" id="id_balai" style="width: 250px;margin: 0;">
					<?php
					$balai = $this->spkp_pjas_a023_model->get_all_balai();
					foreach($balai as $row_balai){
					?>
					   <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$id_balai) echo "Selected"; ?>><?php echo $row_balai->nama_balai; ?></option>
					<?php
					}
					?>
					</select> *
				</td>
			</tr>
			</table>
			</td><td width='50%'>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
			<tr>
			   <td colspan="3">Penanggung Jawab</td>
			</tr>
			<tr>
			   <td width='30%'>Jabatan</td>
			   <td align='middle'>:</td>
			   <td>
				 <input class="input" type="text" size="50" name="penanggungjawab_jabatan" id="penanggungjawab_jabatan" value="<?php if(set_value('penanggungjawab_jabatan')=="" && isset($penanggungjawab_jabatan)){
						echo $penanggungjawab_jabatan;
					}else{
						echo  set_value('penanggungjawab_jabatan');
					}?>" />
			   </td>
			</tr>
			<tr>
			   <td>Nama</td>
			   <td align='middle'>:</td>
			   <td>
				 <input class="input" type="text" size="50" name="penanggungjawab_nama" id="penanggungjawab_nama" value="<?php if(set_value('penanggungjawab_nama')=="" && isset($penanggungjawab_nama)){
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
				 <input class=input type="text" size="20" name="tmpt" id="penanggungjawab_nip" value="<?php if(set_value('tmpt')=="" && isset($tmpt)){
						echo $tmpt;
					}else{
						echo  set_value('tmpt');
					}?>" />
			   </td>
			</tr>
		</table></td></tr></table>
    </form>
</div>
