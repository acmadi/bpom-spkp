<script type="text/javascript">
    $(document).ready(function(){
        $("button,submit,reset").jqxInput({ theme: 'fresh', height: '29px', width: '54px' });
        $("input[name='penerima']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='distribusi']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='produk']").jqxInput({ theme: 'fresh', height: '22px', width: '280px' }); 
        $("input[name='jumlah']").jqxInput({ theme: 'fresh', height: '22px', width: '80px' }); 
        
        <?php if($action=="edit"){ ?>
            $("#tanggal_kegiatan").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme, value : '{tanggal}'});
        <?php }else{ ?>
            $("#tanggal_kegiatan").jqxDateTimeInput({ width: '110px', height: '25px', formatString: 'yyyy-MM-dd', theme: theme});
        <?php } ?>
    });
</script>
<div style="display: none;" id="divLoad"></div>
    <div id="divForm" style="padding:8px">
        <form method="post" id="frmDataKegiatan">
            <div style="padding: 5px;text-align: center;">
                <button type="button" onclick="save_{action}_kegiatan_dialog($('#frmDataKegiatan').serialize());">Simpan</button>
            	<button type="reset">Ulang</button>
                <button type="button" onclick="close_dialog_kegiatan();">Batal</button>
            </div>
            </br>
            <table border='0' width='100%' cellpadding='3' cellspacing='2' style="font-size: 12px;color: black;position:relative;float:left">
                <tr style="display: none;">
                    <td width='18%'>ID</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                       <input type="text" size="10" maxlength="10" name="id" style="margin: 0;width: 50px;" value="{id}" readonly=""/>
                       <?php
                       if($action=="edit"){
                        ?>
                        <input type="text" size="10" maxlength="10" name="id_kegiatan" style="margin: 0;width: 50px;" value="{id_kegiatan}" readonly=""/>
                        <?php
                       }
                       ?>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Tanggal</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <div id='tanggal_kegiatan'></div>
                    </td>
                </tr>
                <tr>
                    <td width='18%'>Penerima Produk</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="penerima" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('penerima')=="" && isset($penerima)){
    								 	echo $penerima;
    								}else{
    									echo  set_value('penerima');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Metode Distribusi</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="distribusi" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('distribusi')=="" && isset($distribusi)){
    								 	echo $distribusi;
    								}else{
    									echo  set_value('distribusi');
    								}
    								 ?>"/> 
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jenis dan Judul Produk</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="50" maxlength="50" name="produk" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('produk')=="" && isset($produk)){
    								 	echo $produk;
    								}else{
    									echo  set_value('produk');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td width='14%'>Jumlah Produk</td>
                    <td width='3%' align='middle'>:</td>
                    <td width='50%'>
                        <input type="text" size="10" maxlength="10" name="jumlah" style="margin: 0;padding: 2px;" value="<?php 
    								if(set_value('jumlah')=="" && isset($jumlah)){
    								 	echo $jumlah;
    								}else{
    									echo  set_value('jumlah');
    								}
    								 ?>"/> *
                    </td>
                </tr>
                <tr>
                    <td colspan="3">&nbsp;</td>
                </tr>
            </table>
        </form>
    </div>
</div>