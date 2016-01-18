<input type="hidden" id="location" value="{location}">
<input type="hidden" id="stack">
<link rel="stylesheet" href="<?php echo base_url()?>plugins/js/fcbkcomplete/style.css" type="text/css" media="screen" charset="utf-8" />
<script type="text/javascript" src="<?php echo base_url()?>plugins/js/fcbkcomplete/jquery.fcbkcomplete.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>plugins/js/tiny_mce/tiny_mce.js"></script>
<script>
	$(function() {
	    $("#btn_users").jqxInput({ theme: 'fresh', height: '29px', width: '60px' });
        $("#btn_save").jqxInput({ theme: 'fresh', height: '29px', width: '90px' });
        $("#btn_reply").jqxInput({ theme: 'fresh', height: '29px', width: '90px' });
        
		$("#message-list").niceScroll({touchbehavior:false,cursorcolor:"#999",cursoropacitymax:0.6,cursorwidth:8});		
		setInterval("get_message_list($('#location').val());",10000);
		setInterval("get_message_recent();",10000);
        
        if('{act}'=='compose'){
            $("#content-leave-message").css('display','none');
        }else{
            $("#btn_save").hide();
            $("#message-compose").hide();
            $("#content-leave-message").css('display','none');
        }
         
		$('.btn_users').click(function(){
		   	$('#popup').jqxWindow({
				theme: theme, resizable: true, position: { x: 420, y: 200},
    			width: 400,
    			height: 300,
    			isModal: true, autoOpen: false, modalOpacity: 0.2
			});
            $("#popup").jqxWindow('open');
        });

		$('#compose').click(function(){
			 $('#title').html("Kirim Pesan Baru");
			 $(".btn_users").hide();
			 $(".btn_reply").hide();
             $("#btn_save").show();
             $("#message-compose").show();
             $("#content-leave-message").css('display','none');
             $("#leave-message").css('display','none');
             
			$.ajax({ 
				type: "GET",
				url: "<?php echo base_url()?>index.php/msg/compose/",
				success: function(response){
					 if(response==0){}
					 else{
						 $('#message-content').html(response);
						 $(".btn_save").show();
					 }
				}
			}); 		
		});

		$('.btn_reply').click(function(){
			var mid = $(this).attr('id').split("__");
			$.ajax({ 
				type: "POST",
				url: "<?php echo base_url()?>index.php/msg/doreply/"+mid[1],
				data: "mmessage="+tinyMCE.get('mmessage').getContent(),
				success: function(response){
					 if(response>0){
						 $.notific8('Notification', {
						  life: 3000,
						  message: 'Save data succesfully.',
						  heading: 'Saving data',
						  theme: 'lime2'
						});
						
						$.ajax({ 
							type: "GET",
							url: "<?php echo base_url()?>index.php/msg/get_message_row/"+mid[1]+"/"+response,
							success: function(response_reply){
								$('#reply').append(response_reply);
								 var scrollheight = $('#reply')[0].scrollHeight < 230 ? 230 : $('#reply')[0].scrollHeight;
								 $('#message-contentx').animate({ scrollTop:scrollheight}, 1000);
							}
						});
						$('#frmMsg')[0].reset();
						$(".btn_users").show("fade");

					 }else{
						 $.notific8('Notification', {
						  life: 5000,
						  message: response,
						  heading: 'Saving data FAIL',
						  theme: 'red2'
						});
					 }
				}
			 }); 		
        });
        
		$(".div_location").click(function(){
			$('#location').val($(this).attr("id"));
			get_message_list($(this).attr("id"));
		});
        
        $("#inbox").click();
	});

	function get_message_recent(){
	    var mid = $("#stack").val().split("__");
	    if($("#stack").val()!=""){
			$.ajax({ 
                type: "GET",
            	url: "<?php echo base_url()?>index.php/msg/get_message_recent/"+mid[0]+"/"+mid[1],
            	success: function(response){
            	  if(response==0){
            					   
            	  }else{
            		 $('#reply').append(response);
            		 var scrollheight = $('#reply')[0].scrollHeight < 230 ? 230 : $('#reply')[0].scrollHeight;
            		 $('#message-contentx').animate({ scrollTop:scrollheight}, 1000);
            	  }
            	}
            });
        }
        
        $.ajax({
           type: "GET",
           url: "<?php echo base_url(); ?>index.php/msg/cek_msg/"+mid[0],
           dataType: "json",
           success: function(response){
                var data = eval(response);
                if(data.count>0){
                    $("#leave-message").css('display','block');
                    $("#leave-message").html("");
                    
                    for(var i=0;i<data.count;i++){
                         var id = "span_"+i;
                         $("#leave-message").append("<span id='"+id+"'>"+data.user[i].username+" leave chat ("+data.user[i].dtime+")</span><br>");
                    }
                }else{
                    /* nothing happened */
                }
           } 
        });
	}

	function get_message(mid){
		$.ajax({ 
			type: "GET",
			url: "<?php echo base_url()?>index.php/msg/get_subject/"+mid,
			success: function(response){
				 $('#title').html(response);
			}
		}); 		

		$.ajax({ 
			type: "GET",
			url: "<?php echo base_url()?>index.php/msg/get_message/"+mid,
			success: function(response){
				 $('#message-content').html(response);
			}
		}); 		
		$.ajax({ 
			type: "GET",
			url: "<?php echo base_url()?>index.php/msg/get_users_list/"+mid,
			success: function(response){
				$("#popup").html(response);
			}
		}); 		
		$.ajax({ 
			type: "GET",
			url: "<?php echo base_url()?>index.php/msg/get_users_count/"+mid,
			success: function(response){
				$(".btn_users").html(response);
				$(".btn_users").show("fade");
			}
		}); 		
		$("#btn_save").hide();
		$(".btn_reply").attr('id','btn_reply__'+mid);
		$(".btn_reply").show();
		$('#frmMsg')[0].reset();
		get_message_list($('#location').val());
        
        $("#message-compose").show();
        $("#content-leave-message").css('display','block');
        $("#leave-message").css('display','none');
        
        $("input[name='mid']").val(mid);
        
        load_leave(mid);
    }

	function get_message_list(location){
	   $.ajax({ 
			type: "GET",
			url: "<?php echo base_url()?>index.php/msg/get_message_list/"+location,
			success: function(response){
				 $('#message-content-list').html(response);
				 $('#message-content-list').height($('#message-content-list')[0].scrollHeight);
                 
                 $.ajax({
                    type: "GET",
                    url: "<?php echo base_url(); ?>index.php/msg/load_count_msg",
                    success: function(response){
                        $("#header_inbox_bar").html(response);
                    }
                 });
			}
		 }); 	

		$(".div_location").css('font-weight','normal');
		$(".div_location[id='"+location+"']").css('font-weight','bold');
    }
    
	function init_mce(elm,heig,widt){
		tinyMCE.init({
			mode : "exact",
			elements : elm,
			theme : "simple",
			height: heig,
			width:widt
		});
	}
    
    function load_leave(mid){
        $.ajax({
           type: "GET",
           url: "<?php echo base_url(); ?>index.php/msg/cek_msg/"+mid,
           dataType: "json",
           success: function(response){
                var data = eval(response);
                if(data.count>0){
                    $("#leave-message").css('display','block');
                    $("#leave-message").html("");
                    
                    for(var i=0;i<data.count;i++){
                         var id = "span_"+i;
                         $("#leave-message").append("<span id='"+id+"'>"+data.user[i].username+" leave chat ("+data.user[i].dtime+")</span><br>");
                    }
                }else{
                    /* nothing happened */
                }
           } 
        });
    }
    
	init_mce("mmessage",170,'100%');
    get_message_list($('#location').val());
</script>
<style>
.input2 {
    border: 0 none;
    border-radius: 2px;
    color: #2E3548;
    cursor: pointer;
    font-family: Verdana,Arial,Helvetica,sans-serif;
    font-size: 11px;
    padding: 6px;
    width: 515px;
}
.input2:focus {
    background: none repeat scroll 0 0 #F4F4F4;
    border: 0 none;
}
.input2:hover {
    background: none repeat scroll 0 0 #FCFCFC;
    border: 0 none;
}
.div_del {
    opacity: 0.5;
}
.div_del:hover {
    opacity: 1;
}
.div_arc {
    opacity: 0.5;
}
.div_arc:hover {
    opacity: 1;
}
.div_location {
    color: #666666;
    cursor: pointer;
    float: left;
    font-size: 13px;
    opacity: 0.6;
    padding: 15px;
    position: relative;
}
.div_location:hover {
    opacity: 1;
}
.compose {
    color: #666666;
    cursor: pointer;
    float: left;
    font-size: 13px;
    opacity: 0.6;
    padding: 15px;
}
.compose:hover {
    opacity: 1;
}
</style>
<div id="popup" style="display:none"><div>Users</div><div></div></div>
<div style="width:99%;background-color:#FFFFFF;-moz-border-radius:5px;border-radius:5px;border:4px solid #ebebeb;position:relative;float:left">
	<form id="frmMsg" method="post">
	<table cellspacing="0" cellpadding="0" width="100%" border='0'>
		<tr height="40">
			<td width="45%" style="border-bottom:1px solid #DDDDDD;border-right:1px solid #DDDDDD;height:30px;">
				<div class="compose" id="compose">
                    <i class="icon-envelope-alt"></i>
                    <span>Compose</span>
                </div>
                <div style="font-weight:bold" class="div_location" id="inbox">
					<i class="icon-download-alt"></i>
                    <span>Inbox</span> 
				</div>
				<div class="div_location" id="trash">
					 <i class="icon-trash"></i>
                     <span>Trash</span> 
				</div>
            </td>
			<td width='55%' style="border-bottom:1px solid #DDDDDD;border-right:1px solid #DDDDDD;">
				<div style="position:relative;float:left;font-size:15px;font-weight:bold;color:#666;padding:15px" id="title">
					{title}
				</div>
			</td>
		</tr>
		<tr>
			<td style="border-bottom:1px solid #DDDDDD;border-right:1px solid #DDDDDD;">
				<div style="width:100%;height:467px;font-size:11px;color:#666;" id="message-list">
					<div id="message-content-list" class="message-content-list" style="height:451px"></div>
				</div>
			</td>
			<td  style="border-bottom:1px solid #DDDDDD;border-right:1px solid #DDDDDD;">
                <input type="text" size="10" name="mid" style="display: none;"/>
				<div style="width:100%;height:250px;font-size:11px;color:#666;padding-bottom:5px;background:#EFEFEF" id="message-content">
    				<div id="message-content-content">
    					{message-content}   
    				</div>
                </div>
                <div id="content-leave-message" style="display: block">
                    <div id="leave-message" style="font-size: 10px;color: red;margin-bottom: 7px;text-align: right;padding: 5px;display: none;"></div>
                </div>
                <div style="border-top:1px solid #DDDDDD;width:100%;height:200px;font-size:11px;color:#666;background:#EFEFEF;" id="message-compose">
					<div style="padding:10px;position:relative;float:left;width:97%">
						<textarea id="mmessage" name="mmessage" oninput=""></textarea>
                    </div>
				</div>
            </td>
		</tr>
        <tr height='20'>
            <td>&nbsp;</td>
            <td valign='middle' align='right' style="padding: 7px;">
                	<button type="button" id="btn_users" class="btn_users" style="display:none">{users} Users</button>
                    <button type="button" id="btn_save">Kirim</button>
					<button type="button" class="btn_reply" id="btn_reply" style="display:none">Kirim</button>
            </td>
        </tr>
	</table>
	</form>
</div>
