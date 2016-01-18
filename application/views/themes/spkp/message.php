<?php
$query_count_msg = $this->db->get_where('app_user_msgs_read', array('username'=>$this->session->userdata('username'),'dtime_seen'=>'0'));
$query_msg = $this->db->query("SELECT a.*, b.msubject FROM app_user_msgs_read a
                                INNER JOIN app_user_msgs b ON a.mid = b.mid
                                WHERE a.username = '".$this->session->userdata('username')."' AND a.dtime_seen = '0' 
                                GROUP BY a.mid ORDER BY a.dtime DESC LIMIT 0,3");
?>

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                               <i class="icon-envelope-alt"></i>
                               <span class="badge badge-important"><?php echo ($query_count_msg->num_rows()>0 ? $query_count_msg->num_rows() : "") ?></span>
                           </a>
                           <ul class="dropdown-menu extended inbox">
                           <?php
                           if($query_count_msg->num_rows()>0){
                           ?>
                               <li>
                                   <p>Anda memiliki <?php echo $query_count_msg->num_rows(); ?> Pesan</p>
                               </li>
                            <?php
                            }
                            ?>
                            
                            <?php
                            $data_msg = $query_msg->result();
                            foreach($data_msg as $row){
                                $get_user = $this->db->query("SELECT a.*, b.image, c.msubject FROM app_user_msgs_reply a
                                                            INNER JOIN app_users_profile b ON a.username = b.username 
                                                            INNER JOIN app_user_msgs c ON a.mid = c.mid
                                                            WHERE a.mid = '".$row->mid."' GROUP BY a.username
                                                            ORDER BY a.dtime DESC LIMIT 0,2");
                                                            
                                $data_user = $get_user->result();
                                foreach($data_user as $row_user){
                            ?>
                                <li>
                                   <a href="<?php echo base_url(); ?>msg/index/2">
                                   <table width='100%' border='0' cellpadding='0'>
                                    <tr height='22px'>
                                        <td rowspan="2" width='20px'>
                                            <span style="margin: 0;border-radius: 2px;">
                                            <?php
                                            if($row_user->image==""){
                                                ?>
                                                <img src="<?php echo base_url(); ?>media/images/smily-user-icon.jpg" alt="" class="avatar" width="50" height="55"/>
                                                <?php
                                            }else{
                                                ?>
                                                <img src="<?php echo base_url(); ?>media/images/user/<?php echo $row_user->image; ?>" alt="" class="avatar" width="50" height="55"/>
                                                <?php
                                            }
                                            ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span style="font-weight: bold;font-size: 12px;">
        									   <span class="from" style="padding: 2px;color: black;"><?php echo $row_user->username; ?></span>
    									   </span>
                                        </td>
                                        <td>
                                            <span style="font-weight: bold;font-size: 10px;float: right;color: black">
                                                <span class="time">
                                                    <i>
                                                        <abbr class="timeago" title="<?php echo date('Y-m-d',$row_user->dtime); ?>"></abbr>
                                                    </i>
                                                </span>
                                            </span>
                                        </td>
                                    </tr>
                                    <tr height='25px'>
                                        <td colspan="2">
                                            <span style="font-size: 11px;text-align: left;padding: 2px;background: white;color: black">
        									    <?php
                                                    echo $row_user->msubject;
                                                ?>
        									</span>
                                        </td>
                                    </tr>
                                   </table>
                                   </a>
                               </li>
                              <?php
                                }
                              }
                              ?>
                               <li>
                                   <a href="<?php echo base_url(); ?>msg/index/1">Kirim Pesan</a>
                               </li> 
                               <li>
                                   <a href="<?php echo base_url(); ?>msg/index/2">Lihat Semua Pesan</a>
                               </li>
                           </ul>
<script type="text/javascript">
    $(document).ready(function(){
       jQuery("abbr.timeago").timeago();
    });
</script>