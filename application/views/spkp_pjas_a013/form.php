<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '30px', width: '100px' });
        $("input[name='ttd_nama']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='ttd_nip']").jqxInput({ theme: 'fresh', height: '22px', width: '130px' }); 
        $("input[name='ttd_tmpt']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("#ttd_tgl").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value: '{ttd_tgl}'});
    });
    
    function save_form(){
        $("#divForm").hide();
        $("#divLoadForm").css("display","block");
        $("#divLoadForm").html("<div style='text-align:center;margin-top: 70px'><br><br><br><br><img src='<?php echo base_url();?>media/images/loaderB64.gif' alt='loading content.. '><br>loading</div>");
             
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a013/doedit_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a013/load_form/{id}",
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
                     url: "<?php echo base_url(); ?>spkp_pjas_a013/load_form/{id}",
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
        window.location.href = "<?php echo base_url(); ?>spkp_pjas_a013";
    }
    
    function export_word(){
        $.ajax({
           type: "POST",
           url: "<?php echo base_url(); ?>spkp_pjas_a013/export/{id}",
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
		$.get("<?php echo base_url();?>spkp_pjas_a013/load_form_import/{id}" , function(response) {
            $("#popup_content").html("<div>"+response+"</div>");
		});        
    }
    
    function close_dialog(){
        $("#popup").jqxWindow('close');
    }
</script>
<div id="popup" style="display:none"><div id="popup_title">Import Form A013</div><div id="popup_content">{popup}</div></div>
<div style="display: none;" id="divLoadForm"></div>
<div id="divForm" style="padding:8px">
        <form method="post" id="frmData">
        <div style="background: #F4F4F4;padding: 5px;text-align: right;">
            <button type="button" onclick="import_dialog()">Import</button>
            <button type="button" onclick="export_word()">Export</button>
            <button type="button" onclick="save_form();">Simpan</button>
        	<button type="reset">Ulang</button>
            <button type="button" onclick="back()">Kembali</button>
        </div>
        </br>
        <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
            <tr>
                <td valign='top'>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td width='19%'>Tahun</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <select size="1" name="tahun" style="width: 85px;height:25px;padding:2px;margin: 0;">
                                        <?php
                                        if(set_value('tahun')=="" && isset($tahun)){
                                            for($x=intval(date('Y'));$x>=intval(date('Y'))-5;$x--){
                                            ?>
                                            <option value="<?php echo $x; ?>" <?php if($x==$tahun) echo "Selected"; ?>><?php echo $x; ?></option>
                                            <?php
                                            }
                                        }else{
                                            for($x=intval(date('Y'));$x>=intval(date('Y'))-5;$x--){
                                                ?>
                                                <option value="<?php echo $x; ?>"><?php echo $x; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                     </select>  
                                     <span style="vertical-align: top">*</span>
                            </td>
                        </tr>
                        <tr>
                            <td width='19%'>Balai Besar / Balai POM</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <select size="1" name="id_balai" style="width: 230px;">
                                    <?php
                                    $data_balai = $this->spkp_pjas_a013_model->get_all_balai();
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
                        <tr>
        				    <td colspan="3" height="30">&nbsp;</td>
        				</tr>
                        <tr>
                            <td colspan="3">Penanggung Jawab</td>
                        </tr>
                        <tr>
                            <td width='17%'>Tempat</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="ttd_tmpt" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_tmpt')=="" && isset($ttd_tmpt)){
            								 	echo $ttd_tmpt;
            								}else{
            									echo  set_value('ttd_tmpt');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='19%'>Tanggal</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <div id='ttd_tgl'></div>
                            </td>
                        </tr>
                        <tr>
        				    <td colspan="3" height="30">&nbsp;</td>
        				</tr>
                    </table>
                </td>
                <td valign='top'>
                    <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black">
                        <tr>
                            <td colspan="3" height="123">&nbsp;</td>
                        </tr>
                        <tr>
                            <td width='14%'>Nama</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="50" maxlength="50" name="ttd_nama" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_nama')=="" && isset($ttd_nama)){
            								 	echo $ttd_nama;
            								}else{
            									echo  set_value('ttd_nama');
            								}
            								 ?>"/> *
                            </td>
                        </tr>
                        <tr>
                            <td width='14%'>NIP</td>
                            <td width='3%' align='middle'>:</td>
                            <td width='50%'>
                                <input type="text" size="30" maxlength="30" name="ttd_nip" style="margin: 0;padding: 2px;" value="<?php 
            								if(set_value('ttd_nip')=="" && isset($ttd_nip)){
            								 	echo $ttd_nip;
            								}else{
            									echo  set_value('ttd_nip');
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
