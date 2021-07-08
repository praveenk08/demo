
<?php
 $this->load->view('admin/includes/header');?>
 
  <section class="content-header">
    <h1>
    Manage Service Category
      </h1>
    <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Manage Service Category</li>
    </ol>
  </section>
  
  <!-- Main content -->
  <section class="content manageCategory">
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
              <a href="<?php echo base_url('admin-add-service-category');?>" class="btn btn-primary">Add New</a>
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
                <input type="text" class="form-control" id="search" name="search" placeholder="Search Name">
              </div>
              <div class="text-right">
                <input type="submit" class="btn btn-primary" id="export" name="export" value="Export files ">
              </div>
            </div>
          </form>
        </div>

        <div class="managePrdTable">
          <div class="dataTables_wrapper">
            <table class="table table-bordered table-striped" id="service_category_list" style="width: 100%;">
              <thead>
                <tr>  
                  <th>Sr. No.</th>
                  <th>Name</th>
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
 var service_category_list_table='';
    $(function () { 
      
  service_category_list_table = $('#service_category_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-service-category-ajax')?>", 
      type: "post", 
      data: function (d) {      
          d.status = $('#change_status').val();
          d.search = $('#search').val();
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'},
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
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeServiceCategoryStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 2 
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-service-category/');?>'+row['id']+'" title="View Service Category" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';
            html += '<a href="<?php echo base_url('admin-update-service-category/')?>'+row['id']+'" title="Update Service Category" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';
            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete Faq" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets": 3 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_status').change(function(){
      service_category_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
 			service_category_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-service-category')?>',service_category_list_table);
		});
    })

    function changeServiceCategoryStatus(id,status){
	    if(id>0){
         changeDataStatus('changeServiceCategoryStatus',id,status,'<?php echo base_url('admin-change-service-category-status')?>',service_category_list_table);
    }
  } 
</script>
 
