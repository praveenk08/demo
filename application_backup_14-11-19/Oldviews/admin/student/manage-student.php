<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Student
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Student</li>
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
            <a href="<?php echo base_url('admin-add-student');?>" class="btn btn-primary">Add New Records</a>
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
               <th>Sr. No.</th>
                <th>Image</th>
                <th>Registration No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Rollno</th>
                <th>Status</th>
                <th>Action</th>
                 
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
 
    student_list_table = $('#student_list').DataTable({
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
      {data: 'image',"orderable":false},
       {data: 'registrationno'}, 
       {data: 'name'}, 
       {data: 'email'}, 
       {data: 'phone'}, 
       {data:'rollno'},
       {data: 'status'}, 
      {data: 'id',"orderable":false},
      
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
             return '<span id="image_'+row['id']+'"><img src="'+data+'"></span>';
          },
          
           "targets": 1 
          },{
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
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
            html +='<a href="javascript:void(0)" onClick="changeStudentStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
            html +='</span>';
            return html;
          },
          
           "targets": 7
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-student/');?>'+row['id']+'" title="View Student" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';
            html += '<a href="<?php echo base_url('admin-update-student/')?>'+row['id']+'" title="Update Student Details" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';
            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete Records" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets": 8 
          },
           
           
        
      ],
      "dom": "<<'dt-toolbar'<''><''l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_status').change(function(){
     student_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
     student_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
   actionPerform('<?php echo base_url('admin-delete-student')?>',student_list_table);
    });
    })

    function changeStudentStatus(id,status){
      if(id>0){
         changeDataStatus('changeStudentStatus',id,status,'<?php echo base_url('admin-change-student-status')?>',student_list_table);
    }
  } 
</script>
   
 

 
