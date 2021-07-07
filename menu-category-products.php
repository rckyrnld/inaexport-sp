<!--menu & category start-->
<section class="slider_section mb-50" style="margin-bottom: 0px;">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-12">
                    <div class="categories_menu">
                        <div class="categories_title">
                            <p class="categori_toggle" style="color: #fff; text-transform: uppercase;">@lang('frontend.home.popcategory')</p>
                        </div>
                        <div class="categories_menu_toggle" style="padding: 0px 0 0px!important;">
                            <ul>
                                @foreach($categoryutama2 as $key => $cu)
                                    <?php
                                        $catprod1 = getCategoryLevel(1, $cu->id, "");
                                        $nk = "nama_kategori_".$lct; 
                                        if($cu->$nk == NULL){
                                            $nk = "nama_kategori_en";
                                        }

                                        $textkat = $cu->$nk;
                                        if(strlen($textkat) > 31){
                                            $cut_text = substr($textkat, 0, 31);
                                            if ($textkat{31 - 1} != ' ') { // jika huruf ke 50 (50 - 1 karena index dimulai dari 0) buka  spasi
                                                $new_pos = strrpos($cut_text, ' '); // cari posisi spasi, pencarian dari huruf terakhir
                                                $cut_text = substr($textkat, 0, $new_pos);
                                            }
                                            $kategorinya = $cut_text . '...';
                                        }else{
                                            $kategorinya = $textkat;
                                        }
                                        if($cu->logo != null){
                                            $imagenya = asset('uploads/Product/Icon').'/'.$cu->logo;
                                        } else {
                                            $imagenya = asset('front/assets/img/kategori/').'/'.$imgarray[$key].'.png';
                                        }
                                    ?>
                                    @if(count($catprod1) == 0)
                                        <li><a href="{{url('/front_end/list_product/category/'.$cu->id)}}" title="{{$textkat}}" style="font-size: 13.5px;"><!--<img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">-->{{$kategorinya}}</a></li>
                                    @else
                                        <li class="menu_item_children categorie_list"><a href="{{url('/front_end/list_product/category/'.$cu->id)}}" title="{{$textkat}}" ><!--<img src="{{$imagenya}}" style="width: 25px; vertical-align: middle;">-->{{$kategorinya}} <i class="fa fa-angle-right"></i></a>
                                            <ul class="categories_mega_menu" style="width: 160%; margin: 0px; padding: 15px  0px 0px 15px ">
                                                @foreach($catprod1 as $key => $c1)
                                                  @if($key < 19)
                                                    <?php
                                                        $catprod2 = getCategoryLevel(2, $cu->id, $c1->id);
                                                        $nk = "nama_kategori_".$lct;
                                                        if($c1->$nk == NULL){
                                                            $nk = "nama_kategori_en";
                                                        }
                                                    ?>
                                                    <li class="menu_item_children next" style="margin-bottom: 0px; width: 50%;"><a href="{{url('/front_end/list_product/category/'.$c1->id)}}" style="text-transform: capitalize !important; font-weight: lighter;font-size: 13.5px;line-height: 1.5; padding-right: 10px!important;">{{$c1->$nk}}</a></li>
                                                  @endif
                                                @endforeach
                                                @if(count($catprod1) > 19)
                                                <li class="menu_item_children"><a href="{{url('/front_end/list_product')}}" style="text-transform: capitalize !important;font-weight: lighter;font-size: 13.5px!important;line-height: 0.5;padding-top: 5px;"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                                                @endif
                                            </ul>
                                        </li>
                                    @endif
                                @endforeach
                                <li id="cat_toggle"><a href="{{url('/front_end/list_product')}}"><i class="fa fa-plus-circle" aria-hidden="true"></i>&nbsp;&nbsp;@lang('frontend.home.morecategory')</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-12">
                    <div id="myCarousel" style="margin-left:-3.5%!important; width:104%!important;" class="carousel slide" data-ride="carousel">
                    <!-- Indicators -->
                        <ol class="carousel-indicators">
							<?php
						$dasa = DB::select("select file_img from mst_slide where publish='1' order by id desc");
						$ndy = 0;
						foreach($dasa as $ds){
						
						?>
						<li data-target="#myCarousel" data-slide-to="<?php echo $ndy ?>" <?php if($ndy == 0){?>class="active" <?php }?>></li>
						<?php $ndy++; } ?>
			
                        </ol>

                    <!-- Wrapper for slides -->
                        <div class="carousel-inner" style="height: 356px!Important;">
						<?php
						$dasa = DB::select("select file_img from mst_slide where publish='1' order by id desc");
						$nds = 1;
						foreach($dasa as $ds){
						
						?>
							<div class="carousel-item <?php if($nds == 1){ echo "active";} ?>" style="height: 372px!Important;">
                                <img src="{{asset('uploads/slider')}}<?php echo "/".$ds->file_img; ?>"  style="width:100%;height:100%;">
                            </div>
						<?php $nds++; }  ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!--menu & category end-->