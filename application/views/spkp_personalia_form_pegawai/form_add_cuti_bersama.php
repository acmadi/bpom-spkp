<script type="text/javascript">
    $(document).ready(function(){
		$("button,submit,reset").jqxInput({ theme: 'fresh', height: '28px', width: '100px' }); 
		$("input[name='keterangan']").jqxInput({ theme: 'fresh', height: '28px', width: '350px' }); 
        
        <?php
        if($action=='add'){
            ?>
                $("#tgl").jqxDateTimeInput({ width: '110px', height: '28px', formatString: 'yyyy-MM-dd', theme: theme});
            <?php
        }else{
            ?>
                $("#tgl").jqxDateTimeInput({ width: '110px', height: '28px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tgl}' });
            <?php
        }
        ?>
        
        $("[name='btn_simpan']").click(function(){
			$("#uploaddiv").hide();
			$.ajax({ 
				type: "POST",
				cache: false,
				url: "<?php echo base_url()?>spkp_personalia_form_pegawai/do{action}_cuti_bersama/{id}",
				data: $("#frmDataCB").serialize(),
				success: function(response){
					 if(response=="1"){
						$.notific8('Notification', {
						  life: 5000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
                        $("#jqxgridCB").jqxGrid('updatebounddata', 'cells');
                        $("#jqxgrid").jqxGrid('updatebounddata', 'cells');
                        close_dialog();
					 }else{
						$("#uploadloader").show("fade");
						$.notific8('Notification', {
						  life: 5000,
						  message: response,
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
<form method="POST" id="frmDataCB">
	<button type="button" name="btn_simpan"> Simpan </button>
	<button type="reset"> Ulang </button>
	<button type="button" onCLick="close_dialog();"> Batal </button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" align="center">
		<tr>
			<td>
                <table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Tgl *</td>
						<td>:</td>
						<td>
							<div id='tgl'></div>
						</td>
					</tr>
					<tr>
						<td>Status</td>
						<td>:</td>
						<td>
                            <select size="1" name="status" style="width: 170px;">
                                <?php
                                if($action=='add'){
                                    ?>
                                    <option value="Cuti Bersama">Cuti Bersama</option>
                                    <option value="Libur Nasional">Libur Nasional</option>
                                    <?php
                                }else{
                                    ?>
                                    <option value="Cuti Bersama" <?php if($status=="Cuti Bersama") echo "Selected";  ?>>Cuti Bersama</option>
                                    <option value="Libur Nasional" <?php if($status=="Libur Nasional") echo "Selected";  ?>>Libur Nasional</option>
                                    <?php
                                }
                                ?>
                            </select>
                        </td>
					</tr>
					<tr>
						<td>Keterangan</td>
						<td>:</td>
						<td><input type="text" size="100" name="keterangan" style="padding: 2px;" value="<?php 
								if(set_value('keterangan')=="" && isset($keterangan)){
								 	echo $keterangan;
								}else{
									echo  set_value('keterangan');
								}
								 ?>"/>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</form>
</div>