<script type="text/javascript">
	$(function() {

		$("input[name^='all__']").click(function() {
			tmp_id = $(this).attr("name").split("__");
			if(this.checked == true){
				$("input[name='show__"+ tmp_id[1] +"']").attr("checked",true);
				$("input[name='add__"+ tmp_id[1] +"']").attr("checked",true);
				$("input[name='edit__"+ tmp_id[1] +"']").attr("checked",true);
				$("input[name='del__"+ tmp_id[1] +"']").attr("checked",true);
			}else{
				$("input[name='all__all']").attr("checked",false);
				$("input[name='show__"+ tmp_id[1] +"']").attr("checked",false);
				$("input[name='add__"+ tmp_id[1] +"']").attr("checked",false);
				$("input[name='edit__"+ tmp_id[1] +"']").attr("checked",false);
				$("input[name='del__"+ tmp_id[1] +"']").attr("checked",false);
			}
		});

		$("input[name$='__all']").click(function() {
			tmp_id = $(this).attr("name").split("__");
			if(tmp_id[0] == "all"){
				if(this.checked  == true){
					$(":checkbox").attr("checked",true);
				}else{
					$(":checkbox").attr("checked",false);
				}
			}
			else if(this.checked  == true){
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",true);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",true);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",true);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",true);
			}else{
				$("input[name^='all__']").attr("checked",false);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",false);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",false);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",false);
				$("input[name^='"+ tmp_id[0] +"']").attr("checked",false);
			}
		});
	});
</script>
<div class="title">{title_form} &raquo; <?php echo ucfirst($level) ?></div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_role/{action}/{level}" method="POST" name="frmGroup_roles">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_role/';">Kembali</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="0"  width="100%" class="tbl">
		<thead>
			<tr>
				<th rowspan=2 class=tbl_head width=5% align=center style="font-size:11px">No</th>
				<th rowspan=2 class=tbl_head width=40% colspan=3 style="font-size:11px">Modules / Controllers / Theme</th>
				<th colspan=10 class=tbl_head width=5% align=center style="font-size:11px">Privileges</th>
			</tr>
			<tr>
				<th class=tbl_head width=5% align=center style="font-size:11px" id="col__show">All<br><input type="checkbox" name="all__all"></th>
				<th class=tbl_head width=5% align=center style="font-size:11px" id="col__show">Show<br><input type="checkbox" name="show__all"></th>
				<th class=tbl_head width=5% align=center style="font-size:11px" id="col__add">Add<br><input type="checkbox" name="add__all"></th>
				<th class=tbl_head width=5% align=center style="font-size:11px" id="col__edit">Edit<br><input type="checkbox" name="edit__all"></th>
				<th class=tbl_head width=5% align=center style="font-size:11px" id="col__del">Delete<br><input type="checkbox" name="del__all"></th>
			</tr>
		</thead>
		<tbody>
		<?php 
		$i=1;
		foreach($query as $row): ;?>
			<tr onMouseOver="bgColor='#EEEEEE'" onmouseout="bgColor='#FFFFFF'" id="row__<?php echo $row->id ?>">
				<td class=tbl_list width="5%" align=center><?php echo $i++?>.</td>
				<td class=tbl_list width="30%"><?php echo ucwords($row->filename) ?>&nbsp;</td>
				<td class=tbl_list width="20%"><?php echo ucwords($row->module) ?>&nbsp;</td>
				<td class=tbl_list width="20%"><?php echo ucwords($row->name) ?>&nbsp;</td>
				<td class=tbl_head width="5%" align=center><input type="checkbox" name="all__<?php echo $row->id ?>" <?php if($row->doshow && $row->doadd && $row->doedit && $row->dodel) echo "checked" ?>></td>
				<td class=tbl_list width="5%" align=center><input type="checkbox" value=1 name="show__<?php echo $row->id ?>" <?php if($row->doshow) echo "checked" ?>></td>
				<td class=tbl_list width="5%" align=center><input type="checkbox" value=1 name="add__<?php echo $row->id ?>" <?php if($row->doadd) echo "checked" ?>></td>
				<td class=tbl_list width="5%" align=center><input type="checkbox" value=1 name="edit__<?php echo $row->id ?>" <?php if($row->doedit) echo "checked" ?>></td>
				<td class=tbl_list width="5%" align=center><input type="checkbox" value=1 name="del__<?php echo $row->id ?>" <?php if($row->dodel) echo "checked" ?>></td>
			</tr>
		<?php endforeach;?>
		</tbody>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<button type="button" class=btn onclick="document.location.href='<?php echo base_url()?>index.php/admin_role/';">Kembali</button>
</form>
