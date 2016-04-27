<script>
	$(function(){
        $("#bar_perpustakaan").addClass("active open");
        $("#galeri_video").addClass("active");
	    $('button, submit, reset').jqxButton({ height: 22, theme: theme });
		$("input[name='param']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
	});
	
	function show_all_data(){
		window.location.href="<?php echo base_url(); ?>spkp_gallery_video/show_list";
	}
	
</script>
<script type="text/javascript" src="<?php echo base_url()?>plugins/js/jPlayer/jquery.jplayer.min.js"></script>

<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
		 Gallery Video
		 <div style="float:right">
			<form action="<?php echo base_url().'spkp_gallery_video/search/1'; ?>" method='post' style='float:right; padding-left:10px'>
				<input name='param' id='param' placeholder='Search...' value="<?php 
				if(set_value('param')=="" && isset($param)){
					echo $param;
				}else{
					echo set_value('param');
				}?>" />
			</form>
			<button name='show' id='show' onclick='show_all_data()' style='float:right;'> Show All... </button>
		</div>
	   </h3>
   </div>
</div>
<div style="display:<?php echo $display ?>;float:right;">page <?php $sixpercount=$count/6;
if($sixpercount>intval($sixpercount)){
	$sixpercount=(intval($sixpercount))+1;
}else{
	$sixpercount=intval($sixpercount);
}
echo $begin.' - '.$sixpercount;?></div>

<div class="row-fluid">
	<div class="widget blue">
        <div class="widget-body">
		
			<ul class="ul-video">
			<?php foreach($konten as $val): ?>
				<li>
					<div class="cover-video" id="cover">
						<a href="<?php echo base_url().'spkp_gallery_video/play/'.$val['id']; ?>" >
							<img src="<?php echo base_url(); ?>media/video/thumbnail.jpg" />
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url().'spkp_gallery_video/play/'.$val['id']; ?>" ><b><?php echo $val['title_content']; ?></b></a></span><br/>
							<span class="subtitle"><?php echo substr($val['content'],0,75).'...'; ?></span><br/>
							<span class="author">Publisher: <?php echo $val['author']; ?></span><br/>
							<span class="date-time"><?php echo $val['waktu_update'].' - view :'.$val['hits']; ?></span><br/>
						</div>
					</div>
				</li>
			<?php endforeach; ?>
			</ul>
			<div style="display:<?php echo $display; ?>; float:right; padding:15 0 15 15;">page <?php echo $begin.' - '.$sixpercount;?></div>
			<div class="pagination" style="float:right; display:<?php echo $display; ?>">
			<ul>
				<?php if($sixpercount!=1){
					for($i=1;$i<=$sixpercount;$i++){
						echo "<li><a href='".base_url()."spkp_gallery_video/page_search/".$param."/".$i."'>".$i."</a></li>";
					}
				} ?>
			</ul>
			</div>
				<!--li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/gempa_sumatera.mp4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/Big_Buck_Bunny_Trailer.MP4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/1.mp4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/Big_Buck_Bunny_Trailer.MP4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/1.mp4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				
			
			<!--
			<div class="row-fluid product-search">
				<div class="span4 product-text">
					<img alt="" src="<?php echo base_url()?>media/images/video.png">
					<div class="portfolio-text-info">
						<h4>iMac Slim</h4>
						<p>21 inch Display, 1.8 GHz Processor, 8 GB Memory</p>
					</div>
				</div>
				
				<div class="spaceh20"></div>

				<div class="span4 product-text">
					<img alt="" src="<?php echo base_url()?>media/images/video.png">
					<div class="portfolio-text-info">
						<h4>iMac Slim</h4>
						<p>21 inch Display, 1.8 GHz Processor, 8 GB Memory</p>
					</div>
				</div>
				
				<div class="spaceh20"></div>
				
				<div class="span4 product-text">
					<img alt="" src="<?php echo base_url()?>media/images/video.png">
					<div class="portfolio-text-info">
						<h4>iMac Slim</h4>
						<p>21 inch Display, 1.8 GHz Processor, 8 GB Memory</p>
					</div>
				</div>
				
				
			</div>
			-->

			
		</div>
	</div>
</div>