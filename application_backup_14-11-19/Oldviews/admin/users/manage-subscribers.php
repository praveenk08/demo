<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Subscribers
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Subscribers</li>
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
          <div class="row">
           <div class="col-md-3 col-sm-6 form-group">
            <input type="text" class="form-control" id="search" placeholder="Search Email">
            </div>
        </div>
         <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="subscribers_list" style="width: 100%;">
           <thead>
           <tr>
               <th>Sr. No.</th>
               <th>Email</th>
                <th>Added Date</th>
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
 var subscribers_list_table='';
    $(function () { 
 
  subscribers_list_table = $('#subscribers_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-subscribers-ajax')?>", 
      type: "post", 
      data: function (d) {      
         d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
       {data: 'email'}, 
       {data: 'added_date'}, 
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
          }         
           ,
          {
            "render": function ( data, type, row ) {
            var html ='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete User" class="btn btn-danger btn-sm">';
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

    $('#search').on('keyup', function() {
      subscribers_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-subscribers')?>',subscribers_list_table);
		});
    })

</script>
 
 
 

 
