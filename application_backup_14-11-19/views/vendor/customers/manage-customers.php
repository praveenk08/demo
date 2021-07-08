
<?php
 $this->load->view('vendor/includes/header');?>

<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
  Manage Customers
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url('vendor-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Manage Customers</li>
  </ol>
</section>
<!-- Main content -->
<section class="content manageProduct">
  <!-- Small boxes (Stat box) -->
  <div class="box box-primary">
    <div class="box-body">
      <!-- Alert -->
      <div id="success_message">
        <?php if($this->session->flashdata('success_message')){ ?>
        <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
        </div><?php } ?>
      </div>
      <!-- Filter Table -->
      <div class="tableTop">
        <form method="post">
          <div class="row">
           
            
            <div class="col-md-4 form-group"><input type="text" class="form-control" id="search" name="search" placeholder="Search Name/Email/Phone"></div>
            
            <div class="col-md-2 form-group">
              <input type="submit" name="export" id="export" class="btn btn-primary" value="Export Files">
              </div>
            </div>
          </div>
        </form>
      </div>
      <!-- Data Table -->
      <div class="managePrdTable">
        <div class="dataTables_wrapper">
          <table class="table table-bordered table-striped" id="customer_list" style="width: 100%;">
            <thead>
            <tr>
               <th>Sr. No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone</th>
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
 
  $this->load->view('vendor/includes/footer');?>
  <script>
 
    $(function () { 
 
  var customer_list_table = $('#customer_list').DataTable({
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
      url :"<?php echo base_url('vendor-manage-customer-ajax')?>", 
      type: "post", 
      data: function (d) {      
          d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'},
      {data: 'email'}, 
      {data: 'phone'}, 
      {data: 'image',"orderable":false,class:'center'}, 
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
            return data;
          },
          
           "targets": 3 
          },
          
          {
            "render": function ( data, type, row ) {
							return '<img src="'+data+'">';
          },
          
           "targets": 4
          },
         
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
					//	html +='<a href="javascript:void(0)" onClick="changecustomerStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='<a href="javascript:void(0)">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 5
          },
          {
            "render": function ( data, type, row ) {
            
            var html=' <a href="<?php echo base_url('vendor-view-customer/');?>'+row['id']+'" title="View customer" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';

           // html +='  <a href="<?php echo base_url('vendor-manage-customer-addresses/');?>'+row['id']+'" title="customer Address List" class="btn btn-success btn-sm">';
            //html +='<i class="glyphicon glyphicon-list"></i></a>';
 
            return html;
          },
          
           "targets": 6 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

   // $('#change_status').change(function(){
     // customer_list_table.ajax.reload();
   // });

    $('#search').on('keyup', function() {
      customer_list_table.search(this.value).draw();
    });
 
    })

  
</script>
 
