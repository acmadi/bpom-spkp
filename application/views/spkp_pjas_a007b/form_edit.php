<script type="text/javascript">
    $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='ttd_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='ttd_nip']").jqxMaskedInput({ theme: theme, height: '22px', width: '175px', mask: '######## ###### # ###' });
		$("input[name='ttd_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$('#ttd_tgl, #kegiatan_tgl').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd'});
        $("input[name='kegiatan_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='kegiatan_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
		$("input[name='kegiatan_penyelenggara']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
	});
	
	function export_dialog() {
		//Collecting filter information into querystring
		var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
		var filter = $("#jqxgridpetugas,#jqxgridpeserta,#jqxgridmateri,#jqxgridpesertalintas").jqxGrid('getfilterinformation');
		k=0;
		for (i = 0; i < filter.length; i++) {
			var filters = filter[i].filter.getfilters();
			var datafield = filter[i].filtercolumn;
			for (j = 0; j < filters.length; j++){
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
			data: datastring+'&filterscount='+k + $("#frmData").serialize(),
			url: "<?php echo base_url();?>spkp_pjas_a007b/export/{id}",
			success: function(response){
				//Download excel file response
				window.open("<?php echo base_url();?>spkp_loader/"+response);
			}
		 }); 		
		//END - Creating excel file
	}
	
    function edit_kegiatan_dialog(){
        $("#divForm").hide();
        $("#divload").css("display","block");
        $("#divload").html("<div style='text-align:center;margin-top: 70px;'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a007b/doedit/{id}",
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
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a007b";
    }
</script>
<div style="display: none;" id="divload"></div>
<div id="divForm" style="height: 250px; padding:8px; border:1px solid #CDCDCD; border-bottom:0px;">
	<form method="post" id="frmData">
	<div style="background: #F4F4F4;padding: 5px;text-align: right;">
		<span id="show-time" style="display: none;"></span>
		<span style="float: right;padding: 5px;display: none;color: green;" id="msg"></span>
		<button type="button" onclick="export_dialog();">Ekspor</button>
		<button type="button" onclick="edit_kegiatan_dialog();">Simpan</button>
		<button type="reset">Ulang</button>
		<button type="button" onclick="back();">Kembali</button>
	</div>
	</br>
	<table width='100%'><tr><td>
		<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
			<tr style="display: none;">
				<td width='40%'>ID</td>
				<td width='1%' align='middle'>:</td>
				<td>
					<input type="text" size="10" maxlength="15" name="id" value="{id}" readonly=""/>
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
				<td width='25%'>Balai</td>
				<td width='3%' align='middle'>:</td>
				<td width='50%'>
					<select size="1" class="input" name="id_balai" id="id_balai" style="width: 200px;margin: 0;">
					<?php
					$balai = $this->spkp_pjas_a007b_model->get_all_balai();
					foreach($balai as $row_balai){
					?>
					   <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$id_balai) echo "Selected"; ?>><?php echo $row_balai->nama_balai; ?></option>
					<?php
					}
					?>
					</select> *
				</td>
			</tr>
			<tr>
				<td>Nama Kegiatan</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="80" maxlength="100" name="kegiatan_nama" value="<?php if(set_value('kegiatan_nama')=="" && isset($kegiatan_nama)){
						echo $kegiatan_nama;
					}else{
						echo  set_value('kegiatan_nama');
					}?>"/> *
				</td> 
			</tr>
			<tr>
				<td>Tanggal Kegiatan</td>
				<td align='middle'>:</td>
				<td>
					<div id="kegiatan_tgl"  value="<?php if(set_value('kegiatan_tgl')=="" && isset($kegiatan_tgl)){
						echo $kegiatan_tgl;
					}else{
						echo  set_value('kegiatan_tgl');
					}?>"></div>
				</td>
			</tr>
			<tr>
				<td>Tempat Kegiatan</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="80" maxlength="100" name="kegiatan_tmpt"  value="<?php if(set_value('kegiatan_tmpt')=="" && isset($kegiatan_tmpt)){
						echo $kegiatan_tmpt;
					}else{
						echo  set_value('kegiatan_tmpt');
					}?>"/>  *
				</td>
			</tr>
			<tr>
				<td>Instansi Penyelenggara</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="80" maxlength="100" name="kegiatan_penyelenggara"  value="<?php if(set_value('kegiatan_penyelenggara')=="" && isset($kegiatan_penyelenggara)){
						echo $kegiatan_penyelenggara;
					}else{
						echo  set_value('kegiatan_penyelenggara');
					}?>"/> *
				</td>
			</tr>
			</table>
			</td>
			<td>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
			<tr>
				<td colspan='2'><br>PENANGGUNG JAWAB :</td>
			</tr>
			<tr>
				<td>Tempat TTD</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="80" maxlength="100" name="ttd_tmpt"  value="<?php if(set_value('ttd_tmpt')=="" && isset($ttd_tmpt)){
						echo $ttd_tmpt;
					}else{
						echo  set_value('ttd_tmpt');
					}?>"/> 
				</td>
			</tr>
			<tr>
				<td>Tanggal TTD</td>
				<td align='middle'>:</td>
				<td>
					<div id="ttd_tgl"  value="<?php if(set_value('ttd_tgl')=="" && isset($ttd_tgl)){
						echo $ttd_tgl;
					}else{
						echo  set_value('ttd_tgl');
					}?>"></div>
				</td>
			</tr>
			<tr>
				<td>Nama</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="80" maxlength="100" name="ttd_nama"  value="<?php if(set_value('ttd_nama')=="" && isset($ttd_nama)){
						echo $ttd_nama;
					}else{
						echo  set_value('ttd_nama');
					}?>"/> *
				</td>
			</tr>
			<tr>
				<td>NIP</td>
				<td align='middle'>:</td>
				<td>
					<input type="text" size="20" maxlength="50" name="ttd_nip"  value="<?php if(set_value('ttd_nip')=="" && isset($ttd_nip)){
						echo $ttd_nip;
					}else{
						echo  set_value('ttd_nip');
					}?>"/> 
				</td>
			</tr>
			</table>
			</td>
			</tr>
		</table>
    </form>
</div>
