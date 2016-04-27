<script>
	$(function(){
       $("#bar_{pagetab}").addClass("active open");
	});
</script>
<?php
$arr_class = array("","metro-nav-block nav-block-orange","metro-nav-block nav-block-yellow","metro-nav-block nav-block-blue double","metro-nav-block nav-block-grey","metro-nav-block nav-block-red","metro-nav-block nav-block-green double","metro-nav-block nav-block-blue","metro-nav-block nav-block-orange","metro-nav-block nav-block-grey");

?>
<div class="metro-nav">
<?php
	foreach($subs as $tab){
		if($tab['module']=="#"){
			$url = base_url().'spkp/index/'.$tab['id'];
		}else{
			$url = base_url().$tab['module'];
		}
?>    <div class="metro-nav-block nav-block-<?php echo $tab['color'] ?> <?php echo $tab['size'] ?>">
        <a data-original-title="" href="<?php echo $url;?>">
            <i class="<?php echo $tab['class'] ?>"></i>
            <div class="info"><?php echo $tab['filename'] ?></div>
            <div class="status"><?php echo $tab['description'] ?></div>
        </a>
    </div>
<?php
	}
?>
</div>
