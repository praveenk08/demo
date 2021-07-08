<?php
 $this->load->view('admin/includes/header');?>

  <!-- Content Header (Page header) -->
  <section class="content-header">
    <h1>
      Manage Team
      </h1>
    <ol class="breadcrumb">
      <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Manage Team</li>
    </ol>
  </section>

  <!-- Main content -->
  <section class="content manageProduct">
    <div class="box box-primary">
      <div class="box-body">

        <div id="success_message" >
          <?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div><?php } ?>
        </div>

        <div class="tableTop"> 
          <form method="post">
            <div class="form-group text-right">
              <a href="<?php echo base_url('admin-add-team');?>" class="btn btn-primary">Add New</a>
            </div>
            <div class="row">
              <div class="col-md-3 col-sm-6 form-group">
                <select class="form-control" id="change_status" name="change_status">
                  <option value="">Select Status</option>
                  <option value="1">Active</option>
                  <option value="0">In-active</option>
                </select>
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <input type="text" class="form-control" id="search" name="search" placeholder="Search Name/Designation">
              </div>
              <div class="col-md-3 col-sm-6 form-group">
                <input type="submit" name="export" id="export" value="Export File" class="btn btn-primary">
              </div>
            </div>
          </form>
        </div>

        <div class="managePrdTable">
          <div class="dataTables_wrapper">
            <table class="table table-bordered table-striped" id="slider_list" style="width: 100%;">
              <thead>
              <tr>
                  <th>Sr. No.</th>
                  <th>Name</th>
                  <th>Designation</th>
                  <th>Image</th>
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
  </section>
  <!-- /.content -->
  
  <?php
 
  $this->load->view('admin/includes/footer');?>

<script>
 var team_list_table='';
    $(function () { 
 
      team_list_table = $('#slider_list').DataTable({
    "processing": true,
    "pageLength": <?php echo getSettings()['total_record_per_page'];?>,
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
      url :"<?php echo base_url('admin-manage-team-ajax')?>", 
      type: "post", 
      data: function (d) {      
           d.status = $('#change_status').val();
          d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'},
      {data: 'designation'},
      {data: 'image',"orderable":false},
      {data: 'status'}, 
      {data: 'id',"orderable":false,class:'center'},
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
              return '<span id="image_'+row['id']+'"><img src="'+data+'"></span>';
          },
          
           "targets": 3 
          },
      
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeTeamStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 4 
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-team/');?>'+row['id']+'" title="View Team" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';
            html += '<a href="<?php echo base_url('admin-update-team/')?>'+row['id']+'" title="Update Team" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';
            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete Slider" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets": 5 
          },
        
      ],
      "dom": "<<'dt-toolbar'<''><''l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_status').change(function(){
      team_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
      team_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-team')?>',team_list_table);
		});
    })

    function changeTeamStatus(id,status){
	    if(id>0){
         changeDataStatus('changeTeamStatus',id,status,'<?php echo base_url('admin-change-team-status')?>',team_list_table);
      }
  } 
</script>
   
 

 
