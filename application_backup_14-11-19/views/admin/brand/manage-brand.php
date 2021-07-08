
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Brands
       </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Brands</li>
      </ol>
    </section>
     <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
      
       <div class="col-md-12 ">
       <div id="success_message" >
          <?php if($this->session->flashdata('success_message')){ ?> 
					<div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div><?php } ?></div>
       <div class="tableInner"> 
       <form>
          <div class="row">
        
           <div class="col-md-2">
            <select class="form-control" id="change_status">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In-active</option>
            </select>
           </div>
           <div class="col-md-4"><input type="text" class="form-control" id="search" placeholder="Search Name"></div>
        </div>

         <div class="row">
         <div class="col-md-10"></div>
          <div class="col-md-2">
            <a href="<?php echo base_url('admin-add-brand');?>" class="btn btn-primary" style="margin-top: 9px;">Add New</a>
          </div>
        </div>
      </form>
 
       <div class="table-responsive ">
         <table class="table table-bordered" id="brand_list">
           <thead>
             <tr>
               <th>Sr. No.</th>
               <th>Name</th>
               <th>Added Date</th>
                <th>Status</th>
               <th  style="text-align:center;">Action</th>
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
        
      </div>
    

    </section>
    <!-- /.content -->
  <?php
 
  $this->load->view('admin/includes/footer');?>
  <script>
 var brand_list_table='';
    $(function () { 
      
 
  brand_list_table = $('#brand_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-brand-ajax')?>", 
      type: "post", 
      data: function (d) {      
          d.status = $('#change_status').val();
          d.search = $('#search').val();
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'},
      {data: 'added_date'},
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
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeBrandStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 3 
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-brand/');?>'+row['id']+'" title="View Brand" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';
            html += '<a href="<?php echo base_url('admin-update-brand/')?>'+row['id']+'" title="Update Brand" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';
            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete Brand" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets": 4 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_status').change(function(){
      brand_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
 			brand_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-brand')?>',brand_list_table);
		});
    })

    function changeBrandStatus(id,status){
	    if(id>0){
         changeDataStatus('changeBrandStatus',id,status,'<?php echo base_url('admin-change-brand-status')?>',brand_list_table);
    }
  } 
</script>
 
