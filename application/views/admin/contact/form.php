<div style="padding:10px">
<div class="title">{title_form}</div>
<div class="clear">&nbsp;</div>
<?php if($this->session->flashdata('alert_form')!=""){ ?>
<div class="alert" id="alert">
<div align=right onClick="$('#alert').hide('fold',1000);" style="color:red;font-weight:bold">X</div>
<?php echo $this->session->flashdata('alert_form')?>
</div>
<?php } ?>
<div class="clear">&nbsp;</div>
<form action="<?php echo base_url()?>index.php/admin_contact/doupdate" method="POST" name="frmUsers">
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
	<br />
	<br />
	<table border="0" cellpadding="0" cellspacing="8" class="panel">
		<tr>
			<td>

				<table border="0" cellpadding="3" cellspacing="2">
					<tr>
						<td>Address</td>
						<td>:</td>
						<td><input class=input type="text" size="100" name="address" value="<?php echo $address?>" /></td>
					</tr>
					<tr>
						<td>Phone</td>
						<td>:</td>
						<td><input class=input type="text" size="20" name="phone" value="<?php echo $phone?>" /></td>
					</tr>
					<tr>
						<td>Fax</td>
						<td>:</td>
						<td><input class=input type="text" size="20" name="fax" value="<?php echo $fax?>" /></td>
					</tr>
					<tr>
						<td>YM 1</td>
						<td>:</td>
						<td><input class=input type="text" size="40" name="ym1" value="<?php echo $ym1?>" /></td>
					</tr>
					<tr>
						<td>YM 2</td>
						<td>:</td>
						<td><input class=input type="text" size="40" name="ym2" value="<?php echo $ym2?>" /></td>
					</tr>
					<tr>
						<td>Email 1</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="email1" value="<?php echo $email1?>" /></td>
					</tr>
					<tr>
						<td>Email 2</td>
						<td>:</td>
						<td><input class=input type="text" size="50" name="email2" value="<?php echo $email2?>" /></td>
					</tr>
				</table>

			</td>
		</tr>
	</table>
	<br />
	<button type="submit" class=btn>Simpan</button>
	<button type="reset" class=btn>Ulang</button>
</form>
</div>