@if(!empty(Auth::guard('eksmp')->user()))
                                    @if(Auth::guard('eksmp')->user()->status == 1)
                                    <div class="list-group" id="kurslist">
                                        <a onclick="openKurs('kurs')" href="#kurs" class="list-group-item" data-toggle="collapse" data-parent="#MainMenus" style="color: black; border: none; text-align: right"><span class="badge badge-secondary">$</span>&nbsp;&nbsp;USD&nbsp;&nbsp;<i class="fa fa-chevron-down" aria-hidden="true" id="icon-kurs"></i></a>
                                        
                                        <div class="collapse" id="kurs">
                                            <div class="row" style="border: 1px solid silver; border-radius: 3px; background-color: #efefef;">
                                                @if($usd != NULL)
                                                    <?php
                                                        for ($n=0; $n < count($imgarr); $n++) { 
                                                    ?>
                                                    @if($n == 0 || $n == 6)
                                                    <div class="col-md-6" style="padding-left: 0px; padding-right: 0px;">
                                                    @endif
                                                        <div class="list-group-item kurs-coll">
                                                            <table border="0" style="width: 100%; font-size: 12px;" cellspacing="5" cellpadding="5">
                                                                <tr>
                                                                    <td width="15%"><img src="{{asset('front/assets/icon/negara/'.$imgarr[$n])}}"></td>
                                                                    <td width="55%">{{$smtarr[$n]}} {{$nmtarr[$n]}}</td>
                                                                    <td width="30%" style="text-align: right;">
                                                                        <?php
                                                                            $mtuang = $smtarr[$n];
                                                                            $konver = $rates->$mtuang;
                                                                            $convert = round($usd * $konver, 2);
                                                                            echo number_format($convert,2,",",".");
                                                                        ?>
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    @if($n == 5 || $n == 11)
                                                    </div>
                                                    @endif
                                                    <?php
                                                        }
                                                    ?>
                                                @else
                                                    <div class="col-md-12" style="padding-left: 0px; padding-right: 0px;">
                                                        <div class="list-group-item kurs-coll">
                                                            <table border="0" style="width: 100%; font-size: 15px;" cellspacing="5" cellpadding="5">
                                                                <tr>
                                                                    <td width="100%" style="vertical-align: middle; text-align: center;">
                                                                            @if($loc == "ch")
                                                                            - 无法使用 -
                                                                            @elseif($loc == "in")
                                                                            - Tidak Tersedia -
                                                                            @else
                                                                            - Not Available -
                                                                            @endif
                                                                    </td>
                                                                </tr>
                                                            </table>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                @endif