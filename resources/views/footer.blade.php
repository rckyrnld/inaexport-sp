<!-- ############ Main END-->

        </div>
        <!-- Footer -->
        <div class="content-footer white " id="content-footer">
            <div class="d-flex p-3">
                
            </div>
        </div>
    </div>
    <!-- ############ Content END-->

<!-- ############ LAYOUT END-->
</div>
<script>
Pace.on("done", function() {
    $('#page_overlay').delay(300).fadeOut(600);
 });
function closenotif(x){
	var token = $('meta[name="csrf-token"]').attr('content');
		$.get('{{URL::to("bacanotif/")}}/'+x,{_token:token},function(data){
			
		 });
}
</script>

<!-- ############ SWITHCHER START-->
<!--
<div id="setting">
  <div class="setting dark-white rounded-bottom" id="theme">
    <a href="#" data-toggle-class="active" data-target="#theme" class="dark-white toggle">
      <i class="fa fa-gear text-primary fa-spin"></i>
    </a>
    <div class="box-header">
      <a href="https://themeforest.net/item/apply-web-application-admin-template/21072584?ref=flatfull" class="btn btn-xs rounded danger float-right">BUY</a>
      <strong>Theme Switcher</strong>
    </div>
    <div class="box-divider"></div>
    <div class="box-body">
      <p id="settingLayout">
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedAside">
          <i></i>
          <span>Fixed Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="fixedContent">
          <i></i>
          <span>Fixed Content</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="folded">
          <i></i>
          <span>Folded Aside</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="container">
          <i></i>
          <span>Boxed Layout</span>
        </label>
        <label class="md-check my-1 d-block">
          <input type="checkbox" name="ajax">
          <i></i>
          <span>Ajax load page</span>
        </label>
        <label class="pointer my-1 d-block" data-toggle="fullscreen" data-plugin="screenfull" data-target="fullscreen">
          <span class="ml-1 mr-2 auto">
            <i class="fa fa-expand d-inline"></i>
            <i class="fa fa-compress d-none"></i>
          </span>
          <span>Fullscreen mode</span>
        </label>
      </p>
    
      <div class="row no-gutters">
        <div class="col">
          <p>Brand</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="brand" value="dark-white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="brand" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col mx-2">
          <p>Aside</p>
          <p>
            <label class="radio radio-inline m-0 mr-1 ui-check">
              <input type="radio" name="aside" value="white">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline m-0 mr-1 ui-check ui-check-color">
              <input type="radio" name="aside" value="dark">
              <i class="dark"></i>
            </label>
          </p>
        </div>
        <div class="col">
          <p>Themes</p>
          <div class="clearfix">
            <label class="radio radio-inline ui-check">
              <input type="radio" name="bg" value="">
              <i class="light"></i>
            </label>
            <label class="radio radio-inline ui-check ui-check-color">
              <input type="radio" name="bg" value="dark">
              <i class="dark"></i>
            </label>
          </div>
        </div>
      </div>
      
      
    </div>
  </div>
</div>
-->
<!-- ############ SWITHCHER END-->


</body>
</html>
