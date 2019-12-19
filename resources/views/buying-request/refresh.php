<?php
                          $datenya = NULL;
						  $messages2 = DB::select("select * from csc_buying_request_chat where id_br='".$id."' and id_join='".$id2."'");
                        ?>
                      
                        <?php foreach($messages2 as $msg){ ?>
                          <?php if($msg->id_pengirim == Auth::guard('eksmp')->user()->id){ ?>
                          <div class="col-md-12">
                            <?php if($datenya == NULL){ ?>
                                <?php
                                   $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                ?>
                                <center>
                                    <i>
										<?php echo $fix; ?>
                                    </i>
                                </center><br>
						<?php }else{ ?>
                                <?php if($datenya != date('d-m-Y', strtotime($msg->tanggal))) { ?>
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                           <?php echo $fix; ?>
                                        </i>
                                    </center><br>
                                <?php } ?>
						<?php } ?>
                            <div class="row pull-right">
                              <div class="col-md-10">
                                <label class="label chat-me">
                                    <?php if($msg->files == NULL){ ?>
                                        <?php echo $msg->pesan; ?><br>
                                    <?php }else{ ?>
                                        <a href="{{ url('uploads/pop/') }}/<?php echo $msg->files; ?>" target="_blank" class="atag" style="color: white;"><?php echo $msg->files; ?></a><br><br>
                                         <?php echo $msg->pesan; ?><br>
                                    <?php } ?>
                                    <span style="float: right;"><?php echo date('H:i',strtotime($msg->tanggal)); ?></span>
                                </label>
                              </div>
                            </div>
                          </div><br>
						<?php }else{ ?>
                          <!-- <div class="col-md-1"></div> -->
                          <div class="col-md-12">
                            <?php if($datenya == NULL){ ?>
                                <?php
                                    $datenya = date('d-m-Y', strtotime($msg->tanggal));
									$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
									
                                ?>
                                <center>
                                    <i>
                                        <?php echo $fix; ?>
                                    </i>
                                </center><br>
                            <?php }else{ ?>
                                <?php if($datenya != date('d-m-Y', strtotime($msg->tanggal))){ ?>
                                    <?php
                                        $datenya = date('d-m-Y', strtotime($msg->tanggal));
										$pecah = (explode("-",$datenya));
									$hari = $pecah[0];
									if($pecah[1] == 1){ $bulan = "Januari";}else if($pecah[1] == 2){ $bulan = "Februari";}else if($pecah[1] == 3){ $bulan = "Maret";}
									else if($pecah[1] == 4){ $bulan = "April";}else if($pecah[1] == 5){ $bulan = "Mei";}else if($pecah[1] == 6){ $bulan = "Juni";}
									else if($pecah[1] == 7){ $bulan = "Juli";}else if($pecah[1] == 8){ $bulan = "Agustus";}else if($pecah[1] == 9){ $bulan = "September";}
									else if($pecah[1] == 10){ $bulan = "Oktober";}else if($pecah[1] == 11){ $bulan = "November";}else if($pecah[1] == 12){ $bulan = "Desember";}
									else { $bulan=""; }
									$thnn = $pecah[2];
									 $fix = $bulan." ".$hari.",".$thnn;
                                    ?>
                                    <center>
                                        <i>
                                            <?php echo $fix; ?>
                                        </i>
                                    </center><br>
                                <?php } ?>
                            <?php } ?>
                            <div class="row">
                              <div class="col-md-10">
                                <label class="label chat-other">
                                    <?php if($msg->files == NULL){ ?>
                                        <?php echo $msg->pesan; ?><br>
                                    <?php }else{ ?>
                                        <a href="{{ url('uploads/pop/') }}/<?php echo $msg->files; ?>" target="_blank" class="atag" style="color: white;"><?php echo $msg->files; ?></a><br><br>
                                        <?php echo $msg->pesan; ?><br>
                                    <?php } ?>
                                    <span style="color: #555; float: right;"><?php echo date('H:i',strtotime($msg->tanggal)); ?></span>
                                </label>
                              </div>
                            </div>
                          </div><br>
                          <!-- <div class="col-md-1"></div> -->
						<?php } ?>
                        <?php } ?>