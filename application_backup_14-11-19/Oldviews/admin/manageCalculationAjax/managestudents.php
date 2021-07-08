<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Students
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage students</li>
      </ol>
    </section>
     <!-- Main content -->
     <section class="content manageProduct">
      <!-- Small boxes (Stat box) -->
      <div class="box box-primary">
      
       <div class="box-body">
       <div id="success_message" >
          <?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div><?php } ?></div>
       <div class="tableTop"> 
       <form>
          <div class="form-group text-right">
            <a href="<?php echo base_url('admin-add-student');?>" class="btn btn-primary">Add New Record</a>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6 form-group">
            <select class="form-control" id="change_status">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In-active</option>
            </select>
           </div>
           <div class="col-md-3 col-sm-6 form-group">
            <input type="text" class="form-control" id="search" placeholder="Search Name">
            </div>
        </div>

      </form>
        <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="student_list" style="width: 100%;">
           <thead>
           <tr>
               <th>Sr.No.</th>
                <th>Registration no</th>
                <th>Name</th>
                <th>Class</th>
                <th>Roll no</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Address</th>
               <th>Status</th>

             </tr>
           </thead>
           <tbody>
           </tbody>
         </table>
       </div>
       </div>

     </div>
            </div>
          </div>
          
        </section>
    <!-- /.content -->
  <?php
 
  $this->load->view('admin/includes/footer');?>

<script>
 var student_list_table='';
    $(function () { 
 
    calculation_list_table = $('#student_list').DataTable({
    "processing": true,
    "pageLength": <?php echo $this->config->item('record_per_page');?>,
    "serverSide": true,
"scrollX": true,
    "sortable": true,
    "lengthMenu": [[10,20, 30, 50,100], [10,20, 30, 50,100]],
    "language": {
    "emptyTable": "<?php echo $this->config->item('record_not_found_title');?>"
    },
     "order": [
      [0, "desc"]
    ],
    "ajax":{
      url :"<?php echo base_url('admin-manage-student-ajax')?>", 
      type: "post", 
      data: function (d) {      
           d.status = $('#change_status').val();
          d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
       {data: 'registrationno',"orderable":false},
       {data: 'name'},
       {data: 'class'},
       {data: 'rollno'}, 
       {data: 'email'}, 
       {data: 'phone'},
       {data: 'address'},
       {daata: 'status'},
      
    ],
      
      "columnDefs": [
        {
          "render": function (data, type, row, meta) {
              return meta.row + meta.settings._iDisplayStart + 1+'.';
          },
          
           "targets": 0 
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 1 
          },

           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 2
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 3
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 4
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 5
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 6
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 7
          },
           {
            "render": function ( data, type, row ) {
              return data;
          },
          
           "targets": 8 
          },
           
          {
            "render": function ( data, type, row ) {
            return data;

          },
              
          ],
      "dom": "<<'dt-toolbar'<''><''l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_status').change(function(){
     // calculation_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
   //   calculation_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
		//	actionPerform('<?php echo base_url('admin-delete-calculation')?>',calculation_list_table);
		});
    })

    function changeCalculationStatus(id,status){
	    if(id>0){
         changeDataStatus('changeCalculationStatus',id,status,'<?php echo base_url('admin-change-calculation-status')?>',calculation_list_table);
    }
  } 
</script>
   
 

 
