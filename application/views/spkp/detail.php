<?php foreach($detail as $value):?>
<div class="row-fluid">
	<div class="span12">
		<h3><i class="<?php 
		if($mod=='news'){ echo 'icon-bell-alt'; } 
		elseif($mod=='announcement'){ echo 'icon-comment-alt'; }
		elseif($mod=='event'){ echo 'icon-tasks'; }?>"></i> <?php echo $value['filename'].' &raquo; '.$value['title_content']; ?></h3>
	</div>
</div>
	<h6 style="width:40%;background-color:#DDDDDD; padding:2px; padding-left:10px">
		<?php if($mod!='event'){echo "Author: ".$value['author'].', At '.$value['waktu'];}
		else{echo "Publisher: ".$value['author'].', At '.$value['waktu_akhir'];}?>
	</h6>
	<div style="min-height:300px">
	<table style="padding-left:10px; width: 100%; border:1px #ebebeb;font-size:12px;color:#111111">
		<tr valign="top">
			<td>
				<?php $angkabln=array('01','02','03','04','05','06','07','08','09','10','11','12');
				$indobln=array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus',
				'September','Oktober','November','Desember');
				if($mod=='event'){
				echo '<p>Waktu Pelaksanaan: '.substr($value['waktu_kegiatan'],8,2).' '.
				str_ireplace($angkabln,$indobln,(substr($value['waktu_kegiatan'],5,2))).' '.
				substr($value['waktu_kegiatan'],0,4).'<p>';
				echo '<p>Tempat Pelaksanaan: '.$value['headline'].'</p>';
				}
				echo $value['content']; ?>
			</td>
		</tr>
	</table>
	</div>
<?php endforeach; ?>
<?php if($mod!='event'){ ?>
<div class="row-fluid">
	<div class="span6">
	   {announcement}  
	</div>
	<div class="span6">
		{news}
	</div>
</div>
<?php } else{ ?>
<div class="row-fluid">
	<div class="span7 responsive" data-tablet="span7 fix-margin" data-desktop="span7">
		{calendar}
	</div>
	<div class="span5">
		{event}
	</div>
</div>
<?php } ?>