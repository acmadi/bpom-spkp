<script type="text/javascript">
    $(document).ready(function(){
        $("button,reset").jqxInput({ theme: 'fresh', height: '28px', width: '54px' });
		<?php if($action=="edit_jadwal"){ ?>
			$("#tgl").html('{tanggal}');
		<?php }else{ ?>
			$("#tgl").jqxDateTimeInput({ width: '110px', height: '28px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl}' });
		<?php } ?>
		$("#tempat").jqxInput({ width: '100px', height: '28px', theme: theme});
		$("#keterangan").jqxInput({ width: '400px', height: '28px', theme: theme});
		
		$("[name='btn_add_jadwal']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>spkp_personalia_jadwal_kegiatan/do{action}/{id}/{tgl}",
				data: $('#frmDataKegiatan').serialize(),
				success: function(response){
					res = response.split("_");
					 if(res[0]=="OK"){
						 $.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						 $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
						$("#jqxgridkegiatan2").jqxGrid('updatebounddata', 'cells');
						$("#popupkegiatan").jqxWindow("close");
					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: res[1],
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
					$("#uploadloader").hide();
					$("#uploaddiv").show("fade");
				}
			 }); 		
		});

    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataKegiatan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" name="btn_add_jadwal">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_kegiatan();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr>
                    <td width='14%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
					<td>
						<div id='tgl'></div>
					</td>
                </tr>
                <tr>
                    <td>Kegiatan</td>
                    <td align='middle'>:</td>
					<td>{option_kegiatan} *</td>
                </tr>
                 <tr>
                    <td>Tempat</td>
                    <td align='middle'>:</td>
					<td><input type="text" id="tempat" name="tempat" value="<?php 
							if(set_value('tempat')=="" && isset($tempat)){
								echo $tempat;
							}else{
								echo  set_value('tempat');
							}
							 ?>"/>
					</td>
                </tr>
                <tr>
                    <td>Keterangan</td>
                    <td align='middle'>:</td>
					<td><input type="text" id="keterangan" name="keterangan" value="<?php 
							if(set_value('keterangan')=="" && isset($keterangan)){
								echo $keterangan;
							}else{
								echo  set_value('keterangan');
							}
							 ?>"/>
					</td>
                </tr>
				<tr>
					<td>Publish</td>
					<td>:</td>
					<td><select name="status" style="height:25px;padding:2px;">
						<option value='1' <?php echo(isset($status) && $status==1 ? "selected":"") ?>>Published</option>
						<option value='0' <?php echo(isset($status) && $status==0 ? "selected":"") ?>>Unpublished</option>
					</select>
					</td>
				</tr>
				<tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>