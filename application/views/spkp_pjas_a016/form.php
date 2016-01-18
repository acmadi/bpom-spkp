<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='penanggungjawab_jabatan']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='penanggungjawab_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '160px' }); 
        $("#tanggal").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{tanggal}'});
    });
    
    function save_form(){
        $("#divForm").hide();
        $("#divLoadForm").css("display","block");
        $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a016/doedit_form/{id}",
           data: $("#frmData").serialize(),
           success: function(response){
                if(response=="1"){
                   $.notific8('Notification', {
    				   life: 5000,
    				   message: 'Save data succesfully.',
    				   heading: 'Saving data',
    				   theme: 'lime'
    			   });
                   
                   $("#divLoadForm").css("display","none");
                   
                   $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a016/load_form/{id}",
                     success: function(response){
                        $("#divForm").show();
                        $("#divForm").html(response);
                     }
                   });
                }else{
                    $.notific8('Notification', {
					  life: 5000,
					  message: response,
                      heading: 'Saving data FAIL',
					  theme: 'red'
					});
                    
                    $("#divLoadForm").css("display","none");
                    
                    $.ajax({
                     type: "POST",
                     url: "<?php echo base_url(); ?>spkp_pjas_a016/load_form/{id}",
                     success: function(response){
                        $("#divForm").show();
                        $("#divForm").html(response);
                     }
                   });
                }
           } 
        });
    }
    
    function back(){
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a016";
    }
    
    function export_word(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a016/export/{id}",
           success: function(response){
              window.open("<?php echo base_url();?>spkp_loader/"+response);
           } 
        });
    }
    
    function export_kota(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a016/export_kota",
           success: function(response){
              window.open("<?php echo base_url();?>spkp_loader/"+response);
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
		$.get("<?php echo base_url();?>spkp_pjas_a016/load_form_import/{id}" , function(response) {
            $("#popup_content").html("<div>"+response+"</div>");
		});
    }
    
    function close_dialog(){
		$("#popup").jqxWindow("close");
	}
</script>
<div id="popup" style="display:none"><div id="popup_title">Import Form A016</div><div id="popup_content">{popup}</div></div>
<div style="display: none;" id="divLoadForm"></div>
<div id="divForm" style="padding:8px">
        <form method="post" id="frmData">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <button type="button" onclick="import_dialog()">Import</button>
            <button type="button" onclick="export_word()">Export</button>
            <button type="button" onclick="save_form();">Simpan</button>
        	<button type="reset">Ulang</button>
            <button type="button" onclick="export_kota()" style="display: none;">Export Kota</button>
            <button type="button" onclick="back()">Kembali</button>
        </div>
        </br>
        <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
            <tr>
                <td>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td width='14%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='tanggal'></div>
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Bulan</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <select size="1" name="bulan" style="width: 150px;">
                                    <?php
                                    $arr_bulan = array("","Januari","Februari","Maret","April","Mei","Juni","Juli","Agustus","September","Oktober","November","Desember");
                                    if(set_value('bulan')=="" && isset($bulan)){
                                        for($x=1;$x<=12;$x++){
                                        ?>
                                            <option value="<?php echo $x; ?>" <?php if($x==$bulan) echo "Selected"; ?>><?php echo $arr_bulan[$x]; ?></option>
                                        <?php
                                        }
                                    }else{
                                        for($x=1;$x<=12;$x++){
                                        ?>
                                            <option value="<?php echo $x; ?>"><?php echo $arr_bulan[$x]; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span style="vertical-align: top">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Balai</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <select size="1" name="id_balai" style="width: 230px;">
                                    <?php
                                    $data_balai = $this->spkp_pjas_a016_model->get_all_balai();
                                    if(set_value('id_balai')=="" && isset($id_balai)){
                                        foreach($data_balai as $row_balai){
                                        ?>
                                        <option value="<?php echo $row_balai->id_balai; ?>" <?php if($row_balai->id_balai==$id_balai) echo "Selected";  ?>><?php echo $row_balai->nama_balai; ?></option>
                                        <?php
                                        }
                                    }else{
                                        foreach($data_balai as $row_balai){
                                        ?>
                                        <option value="<?php echo $row_balai->id_balai; ?>"><?php echo $row_balai->nama_balai; ?></option>
                                        <?php
                                        }
                                    }
                                    ?>
                                </select>
                                <span style="vertical-align: top">*</span>
                            </td>
                        </tr>
                    </table>
                </td>
                <td>
                   <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td colspan="3">Penanggung Jawab</td>
                        </tr>
                        <tr>
                            <td width='14%'>Jabatan</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="penanggungjawab_jabatan" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('penanggungjawab_jabatan')=="" && isset($penanggungjawab_jabatan)){
            								 	echo $penanggungjawab_jabatan;
            								}else{
            									echo  set_value('penanggungjawab_jabatan');
            								}
            								 ?>"/> 
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>Nama</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="penanggungjawab_nama" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('penanggungjawab_nama')=="" && isset($penanggungjawab_nama)){
            								 	echo $penanggungjawab_nama;
            								}else{
            									echo  set_value('penanggungjawab_nama');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>NIP</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="20" maxlength="20" name="penanggungjawab_nip" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('penanggungjawab_nip')=="" && isset($penanggungjawab_nip)){
            								 	echo $penanggungjawab_nip;
            								}else{
            									echo  set_value('penanggungjawab_nip');
            								}
            								 ?>"/> 
                            </td>
                        </tr>
                        <tr>
        				    <td colspan="3" height="30">&nbsp;</td>
        				</tr>
                    </table>  
                </td>
            </tr>
        </table>
    </form>
</div>
