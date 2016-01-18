			<tr valign="top" style="cursor: move;" id="<?php echo $sort?>__<?php echo $id?>">
				<td class="tbl_list" width=100% align="left" style="padding-left:20px;padding-right:0px">|__  <?php echo $sort?>. <?php echo $filename?> | <?php echo $module?>
				<a href="#" onclick="if(confirm('Tambah sub menu?'))document.location.href='<?php echo base_url()?>index.php/admin_menu/add/sub_id/<?php echo $id?>/id_theme/{id_theme}/position/{position}'" title="Hapus"><img src="<?php echo base_url()?>media/images/16_add.gif"  align="right" style="padding:4px"/></a> 
				<?php if(!$this->admin_menu_model->check_child($position,$id)){ ?>
				<?php 
				
					$linkData="index.php/admin_menu/dodel/id/".$id."/id_theme/{id_theme}/position/{position}";
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
				