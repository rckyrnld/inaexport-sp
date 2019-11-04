<?php 
					$qwr = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$id2."'");
					foreach($qwr as $r){
					?>
					
					<?php if($r->id_pengirim == Auth::user()->id){?>
						<li class="right clearfix"><span class="chat-img pull-right">
                            <img src="http://placehold.it/50/FA6F57/fff&text=ME" alt="User Avatar" class="img-circle" />
                        </span>
                            <div class="chat-body clearfix pull-right">
                                <div class="header">
                                    <strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
									<small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
                                </div>
                                <p>
                                    <?php echo $r->pesan; ?>
									
                                </p>
								<p>
								<?php if(empty($r->files)){}else{?>
									<br><a target="_BLANK" href="{{asset('uploads/pop/'.$r->files)}}"><font color="green"><?php echo $r->files; ?></font></a>
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
									<strong class=" text-muted"><span class="pull-right primary-font"></span><b><?php echo $r->username_pengirim; ?></b></strong>
									<small class="glyphicon glyphicon-time"> (<?php echo $r->tanggal; ?>)</small>
                                </div>
                                <p>
                                    <?php echo $r->pesan; ?>
									
                                </p>
								<p>
								<?php if(empty($r->files)){}else{?>
									<br><a target="_BLANK" href="{{asset('uploads/pop/'.$r->files)}}"><font color="green"><?php echo $r->files; ?></font></a>
									<?php } ?>
								</p>
                            </div>
                        </li>
					<?php } ?>
                        
                        
					<?php } ?>