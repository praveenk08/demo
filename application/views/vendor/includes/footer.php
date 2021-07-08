</div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
  <strong>Copyright &copy; <?php echo date('Y');?> <a href="#">MAHASEEL</a>.</strong> All rights
    reserved.
  </footer>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/raphael/raphael.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="<?php echo base_url('assets/backend/');?>plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/moment/min/moment.min.js"></script>
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>

<script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
              
<!-- Bootstrap WYSIHTML5 -->
<script src="<?php echo base_url('assets/backend/');?>plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?php echo base_url('assets/backend/');?>bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url('assets/backend/');?>dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<!--<script src="<?php echo base_url('assets/backend/');?>dist/js/pages/dashboard.js"></script>-->
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url('assets/backend/');?>dist/js/demo.js"></script>
<script src="<?php echo base_url('assets/backend/');?>dist/js/croppie.js"></script>
<script src="<?php echo base_url('assets/backend/');?>dist/js/common.js"></script>
<script src="https://cdn.ckeditor.com/4.11.4/basic/ckeditor.js"></script>
<script src="http://cdn.rawgit.com/davidstutz/bootstrap-multiselect/master/dist/js/bootstrap-multiselect.js"
        type="text/javascript"></script>
 

<div class="modal fade" id="removeProfilePhoteModalPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
          <p><span id="confirmation_message"></p>
        </div>
        <div class="modal-footer">
			<input type="hidden" name="action_id" id="action_id">
          <button type="button" class="btn btn-primary" id="remove_photo">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div> 

  <div class="modal fade" id="deleteModalPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center" style="font-size: 18px;"><strong id="delete_confirmation_message"></strong></div>
        </div>
        <div class="modal-footer">
			<input type="hidden" name="action_id" id="action_id">
          <button type="button" class="btn btn-primary" id="delete_record">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="deleteImageModalPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center" style="font-size: 18px;"><strong id="delete_image_confirmation_message"></strong></div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="deleteImage">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>

  <div class="modal fade" id="deleteSecondaryImageModalPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Confirmation</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="text-center" style="font-size: 18px;"><strong id="delete_secondary_image_confirmation_message"></strong></div>
        </div>
        <div class="modal-footer">
           <input type="hidden" id="secondary_image_id">
          <button type="button" class="btn btn-primary" id="deleteSecondaryImage">Yes</button>&nbsp;&nbsp;&nbsp;
          <button type="button" class="btn btn-danger" data-dismiss="modal">No</button>
        </div>
      </div>
      
    </div>
  </div>


  <script>
var form_error_message='<div class="alert alert-danger">There is error in submitting form!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
var datatable_loader='<div class="datatable_loader"><i class="fa fa-spinner fa-spin"></i></div>';
var small_loader='<div class="small_loader"><img src="<?php echo base_url('/assets/backend/dist/img/preloader1.gif');?>"></div>';
var button_loader='<span class="button_loader"><i class="fa fa-spinner fa-spin"></i></span>';

$.extend( $.fn.dataTable.defaults, {
				language: {
          processing: datatable_loader
				},
      });
  var adminUrls = {
    changeCountryGetState:'<?php echo base_url('change-country-get-state')?>',
    changeStateGetCity:'<?php echo base_url('change-state-get-city')?>',
  };


  </script>

  </body>
</html>