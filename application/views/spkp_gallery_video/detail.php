<style type="text/css">
/* <![CDATA[ */
	@import url(<?php echo base_url()?>plugins/js/jPlayer/jplayer.blue.monday.css);			
/* ]]> */
</style>
<script>
//<![CDATA[
$(document).ready(function(){
	$("#bar_perpustakaan").click();
	$('button, submit, reset').jqxButton({ height: 22, theme: theme });
		$("input[name='param']").jqxInput({ theme: 'fresh', height: '22px', width: '300px' });
	$("#jquery_jplayer_1").jPlayer({
		ready: function () {
			$(this).jPlayer("setMedia", {
				m4v: "<?php echo base_url(); ?>media/video/{links}"
			});
		},
		swfPath: "<?php echo base_url()?>plugins/js/jPlayer",
		supplied: "m4v ",
		size: {
			width: "600px",
			height: "339px",
			cssClass: "jp-video-360p"
		},
		smoothPlayBar: true,
		keyEnabled: true
	});

});

function back(){
	window.location.href="<?php echo base_url() ?>/spkp_gallery_video";
}
//]]>
</script>
<script type="text/javascript" src="<?php echo base_url()?>plugins/js/jPlayer/jquery.jplayer.min.js"></script>
<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
			{title}
			<div style="float:right">
				<form action="<?php echo base_url().'spkp_gallery_video/search/1'; ?>" method='post' style='float:right; padding-left:10px'>
					<input name='param' id='param' placeholder='Search...' value="<?php 
					if(set_value('param')=="" && isset($param)){
						echo $param;
					}else{
						echo set_value('param');
					}?>" />
				</form>
				<button name='show' id='show' onclick='back()' style='float:right;'>Kembali </button>
			</div>
	   </h3>
   </div>
</div>

<div class="row-fluid">
	<div class="widget blue" style="float:left;width:100%;padding-bottom:15px">
        <div class="widget-body">
		
		<div style="position:relative;float:left">
		<div id="jp_container_1" class="jp-video jp-video-360p">
			<div class="jp-type-single">
				<div id="jquery_jplayer_1" class="jp-jplayer"></div>
				<div class="jp-gui">
					<div class="jp-video-play">
						<a href="javascript:;" class="jp-video-play-icon" tabindex="1">play</a>
					</div>
					<div class="jp-interface">
						<div class="jp-progress">
							<div class="jp-seek-bar">
								<div class="jp-play-bar"></div>
							</div>
						</div>
						<div class="jp-current-time"></div>
						<div class="jp-duration"></div>
						<div class="jp-controls-holder">
							<ul class="jp-controls">
								<li><a href="javascript:;" class="jp-play" tabindex="1">play</a></li>
								<li><a href="javascript:;" class="jp-pause" tabindex="1">pause</a></li>
								<li><a href="javascript:;" class="jp-stop" tabindex="1">stop</a></li>
								<li><a href="javascript:;" class="jp-mute" tabindex="1" title="mute">mute</a></li>
								<li><a href="javascript:;" class="jp-unmute" tabindex="1" title="unmute">unmute</a></li>
								<li><a href="javascript:;" class="jp-volume-max" tabindex="1" title="max volume">max volume</a></li>
							</ul>
							<div class="jp-volume-bar">
								<div class="jp-volume-bar-value"></div>
							</div>
							<ul class="jp-toggles">
								<li><a href="javascript:;" class="jp-full-screen" tabindex="1" title="full screen">full screen</a></li>
								<li><a href="javascript:;" class="jp-restore-screen" tabindex="1" title="restore screen">restore screen</a></li>
								<li><a href="javascript:;" class="jp-repeat" tabindex="1" title="repeat">repeat</a></li>
								<li><a href="javascript:;" class="jp-repeat-off" tabindex="1" title="repeat off">repeat off</a></li>
							</ul>
						</div>
						<legend></legend>
						<?php foreach($detail as $data): ?>
						<div style="padding:10px">
							<span class="title"><h1><b><?php echo $data['title_content']; ?></b></h1></span>
							<legend></legend>
							<span class="subtitle"><?php echo $data['content']; ?></span>
							<legend></legend>
							<span class="author"><h4>Publisher: <b><?php echo $data['author']; ?></b></h4></span>
							<span class="date-time"><h5>At <?php echo date('d M Y H:m:s',$data['dtime_end']).' - view :'.$data['hits']; ?><h5></span>
						</div>
						<?php endforeach; ?>
					</div>
				</div>
				<div class="jp-no-solution">
					<span>Update Required</span>
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
				</div>
			</div>
		</div>
		</div>
		
		<div style="width:475px;float:left;margin-left:15px">
			<ul class="ul-video-detail">
				<?php foreach($konten as $val): ?>
					<li>
						<div class="cover-video">
							<a href="<?php echo base_url()?>spkp_gallery_video/play/<?php echo $val['id']; ?>">
								<img src="<?php echo base_url(); ?>media/video/thumbnail.jpg" />
							</a>
							<div class="video-title-cover-detail">
							<span class="title"><a href="<?php echo base_url() ?>spkp_gallery_video/play/<?php echo $val['id']; ?>" ><?php echo $val['title_content']; ?></a></span><br/>
							<span class="subtitle"><?php echo substr($val['content'],0,50).'...'; ?></span><br/>
							<span class="author"><?php echo 'Publisher :'.$val['author']; ?></span><br/>
							<span class="date-time"><?php echo $val['waktu_update'].' - view :'.$val['hits']; ?></span><br/>
							</div>
						</div>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
				
				<!--li>
					<div class="cover-video">
						<a href="<?php echo base_url()?>spkp_gallery_video/show">
							<video id="video1" width="200" height="120" style="float:left">
							<source src="<?php echo base_url()?>media/video/1.mp4" type="video/mp4">
							</video>
						</a>
						<div class="video-title-cover-detail">
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
						<div class="video-title-cover-detail">
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
						<div class="video-title-cover-detail">
							<span class="title"><a href="<?php echo base_url()?>spkp_gallery_video/show">Launching Program Pengembangan POMPI</a></span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li-->
		
			<!--
			<ul class="ul-video">
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>	
				
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
				
				<li>
					<div class="cover-video">
						<img alt="" src="<?php echo base_url()?>media/images/video.png">
						<div class="video-title-cover">
							<span class="title">Launching Program Pengembangan POMPI</span><br/>
							<span class="subtitle">Mengembangkan potensi pada diri Anak</span><br/>
							<span class="author">theredzonez</span><br/>
							<span class="date-time">12/11/2013</span><br/>
						</div>
					</div>
				</li>
			</ul>
			-->
			
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