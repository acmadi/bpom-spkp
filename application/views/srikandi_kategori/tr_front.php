			<tr valign="top" style="cursor: move;" id="<?php echo "1"?>__<?php echo $id_kategori_parent?>">
				<td class="tbl_list" width=100% align="left" style="padding-left:20px;padding-right:0px">|__  <?php echo $nama?>
				<a href="#" onclick="if(confirm('Tambah sub Kategori?')){tambahsubkategori(<?php echo $id_kategori;?>)}" title="Tambah Sub Kategori"><img src="<?php echo base_url()?>media/images/16_add.gif"  align="right" style="padding:4px"/></a> 
				<?php if(!$this->srikandi_kategori_model->check_child($id_subdit,$id_kategori)){ ?>
				<?php 
				
					$linkData="index.php/admin_menu/dodel/id/".$id_subdit."/id_theme/{id_theme}/position/{id_subdit}";
					$testLink=$this->verifikasi_icon->del_icon('admin_menu',$linkData);
					echo $testLink;
					
//					$level=$this->session->userdata('level');
//					if($level=="super administrator"){ 
				?>	
<!--				<a href="#" onclick="if(confirm('Hapus data ini?'))document.location.href='<?php echo base_url()?>index.php/menus/dodel/id/<?php echo $id?>/id_theme/{id_theme}/position/{position}'" title="Hapus">-->
<!--					<img src="<?php echo base_url()?>media/images/16_del.gif"  align="right" style="padding:4px"/>-->
<!--				</a>-->
				<?php 
//					}else{
					?>
<!--					<img src="<?php  echo base_url()?>media/images/16_lock.gif" align="right" style="padding:4px"/>-->
				<?php //}?>
				
				<?php } ?>
				
