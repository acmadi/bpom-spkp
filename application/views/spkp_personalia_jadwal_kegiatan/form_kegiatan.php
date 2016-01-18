<script type="text/javascript" language="javascript" src="<?php echo base_url()?>plugins/js/jquery/jqwidgets/jqxcolorpicker.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
		$("button").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '22px', width: '500px' }); 
		$("input[name='kegiatan']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' }); 
		$("input[name='kode']").jqxInput({ theme: 'fresh', height: '22px', width: '50px' }); 
		$("#bgcolor").jqxColorPicker({ color: "{bgcolor}", colorMode: 'saturation', width: 220, height: 200, theme: 'fresh' });
		$("#fontcolor").jqxColorPicker({ color: "{fontcolor}", colorMode: 'hue', width: 220, height: 200, theme: 'fresh' });

		$("#bgcolor").on('colorchange', function (event) {
			$("input[name='bgcolor']").val(event.args.color.hex);
			$("input[name='kode']").css('background-color',event.args.color.hex);
		});

		$("#fontcolor").on('colorchange', function (event) {
			$("input[name='fontcolor']").val(event.args.color.hex);
			$("input[name='kode']").css('color',event.args.color.hex);
		});


		$("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$("#uploadloader").show("fade");

			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>spkp_personalia_jadwal_kegiatan/do{action}/{id}",
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
						$("[name='keterangan']").val("");
						$("[name='kegiatan']").val("");
						$("[name='kode']").val("");
						$("#jqxgridKegiatan").jqxGrid('updatebounddata', 'cells');
						$("#popup").jqxWindow("close");
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
<div id="uploadloader" style='display:none;text-align:center'><br><br><br><img src='<?php echo base_url();?>media/images/indicator.gif' alt='loading content.. '><br>uploading<br><br><br><br></div>
<div id="uploaddiv" style="padding:5px;text-align:center">
<form method="POST" id="frmDataKegiatan">
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_kegiatan();"> Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Tahun *</td>
						<td>:</td>
						<td colspan="2"><select name="thn" style="height:25px;padding:2px;width:100px">
						<?php for($i=(date("Y")+1);$i>=(date("Y")-10);$i--){ ?>
							<option value='<?php echo $i?>' <?php echo($thn==$i ? "selected":"") ?>><?php echo $i?></option>
						<?php } ?>
						</select>
						</td>
					</tr>
					<tr>
						<td>Kegiatan *</td>
						<td>:</td>
						<td colspan="2"><input type="text" size="50" name="kegiatan" value="<?php 
								if(set_value('kegiatan')=="" && isset($kegiatan)){
								 	echo $kegiatan;
								}else{
									echo  set_value('kegiatan');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td colspan="2"><input type="text" size="80" name="keterangan" value="<?php 
								if(set_value('keterangan')=="" && isset($keterangan)){
								 	echo $keterangan;
								}else{
									echo  set_value('keterangan');
								}
								 ?>"/>
						</td>
					</tr>
					<tr>
						<td>Kode</td>
						<td>:</td>
						<td colspan="2"><input type="text" size="5" name="kode" value="<?php 
								if(set_value('kode')=="" && isset($kode)){
								 	echo $kode;
								}else{
									echo  set_value('kode');
								}
								 ?>" style="background:#{bgcolor};color:#{fontcolor};text-align:center"/>
						</td>
					</tr>
					<tr>
						<td>Warna *</td>
						<td>:</td>
						<td>
							<input type="hidden" name="bgcolor" value="{bgcolor}">
							<div id="bgcolor"></div>
						</td>
						<td>
							<input type="hidden" name="fontcolor" value="{fontcolor}">
							<div id="fontcolor"></div>
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td colspan="2"><select name="status" style="height:25px;padding:2px;width:100px;">
							<option value='1' <?php echo(isset($status) && $status==1 ? "selected":"") ?>>Show</option>
							<option value='0' <?php echo(isset($status) && $status==0 ? "selected":"") ?>>Hide</option>
						</select>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>