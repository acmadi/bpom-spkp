<script type="text/javascript">
    $(document).ready(function(){
        $("export,button,submit,reset").jqxInput({ theme: 'fresh', height: '25px', width: '54px' });
		$("input[name='judul']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
		$("input[name='tempat']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$("textarea").jqxInput({ theme: theme, height: '29px', width: '320px', height:'100px' });
		$("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '220px' });
		$("input[name='penanggungjawab_nip']").jqxMaskedInput({ theme: theme, height: '22px', width: '175px', mask: '######## ###### # ###' });
		$("input[name='tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '150px' });
        $('#tanggal').jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme });
	});
	
	function export_dialog() {
		//Collecting filter information into querystring
		var datastring="pagenum=0&pagesize=9999&groupscount=0&groupscount=10&recordstartindex=0&";
		var filter = $("#jqxgrid,#jqxgridpeserta").jqxGrid('getfilterinformation');
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
			data: datastring+'&filterscount='+k + $("#frmDatajudul").serialize(),
			url: "<?php echo base_url();?>spkp_pjas_a002/export/{id}",
			success: function(response){
				//Download excel file response
				window.open("<?php echo base_url();?>spkp_loader/"+response);
			}
		 }); 		
		//END - Creating excel file
	}
	
    function save_judul(){
        $("#divFormjudul").hide();
        $("#divloadjudul").css("display","block");
        $("#divloadjudul").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a002/do{action}_judul/{id}",
           data: $("#frmDatajudul").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divloadjudul").css("display","none");
				   $("#divFormjudul").show();
                   
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divloadjudul").css("display","none");
					$("#divFormjudul").show();
                }
           } 
        });
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a002";
    }
</script>
<div style="display: none;" id="divloadjudul"></div>
<div id="divFormjudul" style="padding:8px;border:1px solid #CDCDCD;border-bottom:0">
        <form method="post" id="frmDatajudul">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <span id="show-time" style="display: none;"></span>
            <span style="float: right;padding: 5px;display: none;color: green;" id="msg"></span>
			<button type="button" onclick="export_dialog();">Ekspor</button>
            <button type="button" onclick="save_judul();">Simpan</button>
        	<button type="reset">Ulang</button>
			<button type="button" onclick="back();">Kembali</button>
        </div>
        </br>
		<table width='95%'><tr><td width='50%'>
			<table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
				<tr style="display: none;">
					<td width='40%'>ID</td>
					<td width='1%' align='middle'>:</td>
					<td>
						<input type="text" size="10" maxlength="15" name="id" value="{id}" readonly=""/>
					</td>
				</tr>
				<tr>
					<td>Tanggal</td>
					<td align='middle'>:</td>
					<td>
						<div id='tanggal' name='tanggal'> *</div>
					</td>
				</tr>
				<tr>
					<td>Kegiatan / Pemaparan Materi</td>
					<td align='middle'>:</td>
					<td>
						<input type="text" size="30" maxlength="40" name="judul" id="judul" value="<?php if(set_value('judul')=="" && isset($judul)){
							echo $judul;
						}else{
							echo  set_value('judul');
						}?>" /> *
					</td>
				</tr>
				<tr>
					<td>Tempat</td>
					<td align='middle'>:</td>
					<td>
						<input type="text" size="15" maxlength="15" name="tempat" id="tempat" value="<?php if(set_value('tempat')=="" && isset($tempat)){
											echo $tempat;
										}else{
											echo  set_value('tempat');
										} ?>" /> *
					</td>
				</tr>
				<tr>
					<td>Hasil</td>
					<td align='middle'>:</td>
					<td>
						<textarea id="hasil" name="hasil" class="input" wrap="virtual" rows="3" cols="65"><?php if(set_value('hasil')=="" && isset($hasil)){
											echo $hasil;
										}else{
											echo  set_value('hasil');
										} ?></textarea>
					</td>
				</tr>
			</table>
		</td>
		<td valign='top'>
				<table cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
			<tr>
			   <td colspan="3">Penanggung Jawab</td>
			</tr>
			<tr>
			   <td width='30%'>Nama</td>
			   <td align='middle'>:</td>
			   <td>
				 <input class=input type="text" size="50" name="penanggungjawab_nama" id="penanggungjawab_nama" value="<?php if(set_value('penanggungjawab_nama')=="" && isset($penanggungjawab_nama)){
						echo $penanggungjawab_nama;
					}else{
						echo  set_value('penanggungjawab_nama');
					}?>" /> *
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
					}?>" /> *
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
					}?>" /> *
			   </td>
			</tr>
		</table>
	</td>
	</tr></table>
    </form>
</div>
