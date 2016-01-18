<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("#btn_download").jqxInput({ theme: 'fresh', height: '29px', width: '120px' });
        $("input[name='filename']").jqxInput({ theme: 'fresh', height: '22px', width: '200px' }); 
        
        $("#btn_download").click(function(){
		      window.open("<?php echo base_url()?>spkp_pjas_f2/dodownload");  
		});
        
        $("#btn_import").click(function(){
            var data = new FormData();
			jQuery.each($('#filename_import')[0].files, function(i, file) {
				data.append('filename', file);
			});	
            $("#divLoadImport").html("<div style='text-align: center;margin: 0 auto;'><img src='<?php echo base_url(); ?>media/images/loaderB32.gif'/><br>loading</div>");	
            $.ajax({
                type: "POST",
                cache: false,
				contentType: false,
				processData: false,
                url: "<?php echo base_url(); ?>index.php/spkp_pjas_f2/doimport/{id}",
                data: data,
                success: function(response){
                   if(response){
                     $("#divLoadImport").show();
                     $("#divLoadImport").html(response);
                     $('#refreshdatabuttonpembinaan').click();
                     $('#refreshdatabuttonpengawalan').click();
                   }
                }  
            });
        });
    });
</script>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataImport">
            <div style="padding: 5px;text-align: center;">
                <button type="button" id="btn_download">Download Format</button>
            	<button type="button" id="btn_import">Import</button>
                <button type="button" onclick="close_dialog();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr>
                    <td width='10%'>File</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="file" size="10" name="filename" id="filename_import"/> *
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <span>
                        Keterangan : </br>
                            - Download format file excel dan ikuti contoh pengisian data sesuai format</br>
                            - File disimpan dalam format excel 2007 (.xls)</br>
                            - Proses import file akan menimpa data-data sebelumnya
                        </span>
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
                <tr>
                    <td colspan="3">
                        <div style="display: none;" id="divLoadImport"></div>
                    </td>
                </tr>
            </table>
        </form>
    </div>
