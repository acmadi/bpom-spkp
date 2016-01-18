<script>
$(function(){
	$('button').jqxButton({ height: 25, theme: theme });
});

function back(){
	window.location.href="<?php echo base_url()?>spkp/index/1";
}

</script>

<div class="row-fluid">
   <div class="span12">
	   <h3 class="page-title">
			<?php foreach($detail as $value){ echo $value['title_content']; }?>
	   </h3>
   </div>
</div>
<div>
	<div id="show_content" style="width:100%;background-color:#DDDDDD;-moz-border-radius:5px;border-radius:5px;padding:2px;border:3px solid #ebebeb;">
        <input style="padding: 5px;" align="right" value="Kembali" id="back" type="button" onclick="back()"/>
		<?php foreach($detail as $value){ echo "Author: ".$value['author'];?>
	</div>
	<div>
	<?php foreach($detail as $value){ echo $value['content']; } ?>
	</div>
</div>