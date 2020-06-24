<?php 
					foreach($messages as $msg){
					?>
					
					<?php if($msg->sender == $id_user){?>
						<li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix pull-right">
                                <div class="header">
                                    <strong class=" text-muted"><span class="pull-right primary-font"></span><b>You</b></strong>
									<small class="glyphicon glyphicon-time"> (<?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
                                     echo $datenya; ?>)</small>
                                </div>
                                  <p>
                                    {{$msg->messages}}
									
                                </p>
								<p>
								<?php if(empty($msg->file)){}else{?>
									<br><a target="_BLANK" href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}"><font color="green"><?php echo $msg->file; ?></font></a>
									<?php } ?>
								</p>
                            </div>
                        </li>
					<?php }else{ ?>
						<li class="left clearfix"><span class="chat-img pull-left">
                            <img src="http://placehold.it/50/55C1E7/fff&text=H" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix">
                                <div class="header">
									<strong class=" text-muted"><span class="pull-right primary-font"></span><b>@if($inquiry->type == "importir")
                                                                    {{getCompanyNameImportir($msg->sender)}}
                                                                @elseif($inquiry->type == "perwakilan")
                                                                    {{getPerwakilanName($msg->sender)}}
                                                                @elseif($inquiry->type == "admin")
                                                                    {{getAdminName($msg->sender)}}
                                                                @endif</b></strong>
									<small class="glyphicon glyphicon-time"> (<?php
                                        $datenya = date('d-m-Y', strtotime($msg->created_at));
                                     echo $datenya; ?>)</small>
                                </div>
                                  <p>
                                    {{$msg->messages}}
									
                                </p>
								<p>
								<?php if(empty($msg->file)){}else{?>
									<br><a target="_BLANK" href="{{ url('/').'/uploads/ChatFileInquiry/'.$msg->id }}/{{ $msg->file }}"><font color="green"><?php echo $msg->file; ?></font></a>
									<?php } ?>
								</p>
                            </div>
                        </li>
					<?php } ?>
                        
                        
					<?php }  ?>
                        