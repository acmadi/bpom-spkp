<script type="text/javascript" language="javascript">
/* <![CDATA[ */
$(function() {
	$('#btn_pendaftaran').click(function(){
		window.location.href="<?php echo base_url()?>ske/pendaftaran.bpom";
	});

	$('#login_email').focus(function() {
		if($(this).val()=="username")$(this).val("");
	});

	$('#login_password').focus(function() {
		if($(this).val()=="password")$(this).val("");
	});

	$('#login_email').blur(function() {
		if($(this).val()=="")$(this).val("username");
	});

	$('#login_password').blur(function() {
		if($(this).val()=="")$(this).val("password");
	});
    
    $("#clock").MyDigitClock({
        		fontSize:50, 
        		fontFamily:"Arial", 
        		fontColor: "#FFFFFF", 
        		fontWeight:false, 
        		bAmPm:true,
        		background:false,
        		timeFormat: '{HH}:{MM}',
                bShowHeartBeat:true
        		});
});
/* ]]> */
</script>
<div class="login">
	<div id="login_box">
        <table style="" border="0" cellpadding="1" cellspacing="1" width="100%">
            <tr>
            	<td colspan="2" style="border: none;" width="29%"><img style="border: none;" src="<?php echo base_url()?>public/themes/ske/images/logo.png"/>
				<img style="border: none;" src="<?php echo base_url()?>public/themes/ske/images/title-logo.png" align="abs-middle"/></td>
				
            </tr>
            <tr height="250px">
            	<td colspan="2">
                    <table border="0" cellpadding="1" cellspacing="1" width="100%" height="90%">
                        <tr>
                        	<td valign="middle" width="5%" style="padding-top:53px"><img src="<?php echo base_url() ?>public/themes/ske/images/key.png"/></td>
                        	<td align="left">
                                <table border="0" cellpadding="1" cellspacing="1" width="100%" height="100%">
                                    <tr>
                                    	<td valign="bottom" align="left" height="33%" class="title4">Login</td>
                                    </tr>
                                    <tr>
                                    	<td valign="top" align="left" >
                                           <table border="0" cellpadding="1" cellspacing="0" width="100%" >
                                                <tr>
                                                	<td valign="top" align="left" width="21%" style="">
                                                        <form action="<?php echo base_url()?>ske/login.bpom" method=post>
                                                            <table border="0" cellpadding="2" cellspacing="0" width="100%">
                                                                <tr>
                                                                	<td><label class="label">username</label></td>
                                                                </tr>
                                                                <tr>
                                                                	<td valign="top">
                                                                        <div id="login_email_div"><input type="text" name="email" id="login_email" value="username"></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                	<td><label class="label">password</label></td>
                                                                </tr>
                                                                <tr>
                                                                	<td valign="top">
                                                                        <div id="login_password_div"><input type="password" name="password" id="login_password" value="password"></div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                	<td align="right" style="padding-top: 3px;">
                                                                        <div>
                                                                            <input type='button' id="btn_pendaftaran" value='pendaftaran' class="btn_login" style="width:110px;cursor:pointer">
                                                                            <input type='submit' value='login' class="btn_login" style="cursor:pointer">
                                                            			</div>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                		</form>	
                                                    </td>
                                                	<td>&nbsp;</td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>    
                </td>
            </tr>
            <tr>
            	<td colspan="2">
                    <div id="clock"></div>
                    <div id="date"><?php echo date("l, d F Y");?></div>
                </td>
            	
            </tr>
			
			<tr>
				<td class="td-menu-login">
				<img height="30" align="center" style="border: none;" src="<?php echo base_url()?>public/themes/ske/images/user32.png"/>
				<a href="">Tentang</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img height="30" align="center" style="border: none;" src="<?php echo base_url()?>public/themes/ske/images/linedpaperpencil32.png"/>
				<a href="">Panduan Aplikasi</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<img height="30" align="center" style="border: none;" src="<?php echo base_url()?>public/themes/ske/images/questionbook32.png"/>
				<a href="">FAQ</a></td>
			</tr>
        </table>
	</div>
	<br><br>

</div>