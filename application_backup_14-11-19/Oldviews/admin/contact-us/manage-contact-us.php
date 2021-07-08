
<?php
 $this->load->view('admin/includes/header');?>
 

    <section class="content-header">
      <h1>
      Manage Contact Us
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Manage Contact Us</li>
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
            <select class="form-control" id="change_status">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In-active</option>
            </select>
           </div>
           <div class="col-md-3 col-sm-6 form-group">
           <input type="text" class="form-control" id="search" placeholder="Search Customer Name/Email/Phone">
            </div>

        </div>
         <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="contact_list" style="width: 100%;">
           <thead>
           <tr>
             <th style="width:7%;">Sr. No.</th>
                <th style="width:10%;">Name</th>
               <th style="width:10%;">Email</th>
               <th style="width:10%;">Phone</th>
               <th style="width:18%;">Subject</th>
               <th style="width:25%;">Message</th>
               <th style="width:10%;">Status</th>
              <th  style="text-align:center;width:10%;">Action</th>
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
 var contact_list_table='';
    $(function () { 
   contact_list_table = $('#contact_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-contact-us-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.status = $('#change_status').val();
         d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'}, 
      {data: 'email'}, 
      {data: 'phone'}, 
      {data: 'subject'}, 
      {data: 'message'}, 
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
              return data
           },
          
           "targets":1 
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
              
              
								var main_message = '';
										var more = '';
                    main_message += '<input type="hidden" id="show_hide' + row['id'] + '" value="0"/>';
                    main_message +='<span id="max_part' + row['id'] + '" style="display:none;">' + data;
										main_message += '<a href="javascript:void(0)" onClick="showMore(' + row['id'] + ')"> Less..</a>';
										main_message += '</span>';
										if (data.length > 50) {
												more += ' <a href="javascript:void(0)" onClick="showMore(' + row['id'] + ')"> More..</a>';
										}
										main_message += '<span id="min_part' + row['id'] + '">';
										main_message += message = data.substr(0, 50) + more;
										main_message += '</span>';
                    return main_message;


					
           
           },
          
           "targets": 5 
          },
          
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeContactUsStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets":6 
          },
          {
            "render": function ( data, type, row ) {
             
           var html ='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete contact" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets":7 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });
 
    $('#change_status').change(function(){
      contact_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
 			contact_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-contact-us')?>',contact_list_table);
    });
 
     
    })
   
   
     function changeContactUsStatus(id,status){
	    if(id>0){
        changeDataStatus('changeContactUsStatus',id,status,'<?php echo base_url('admin-change-contact-status')?>',contact_list_table);
    }
  } 
 
 
  function showMore(id){
	var show_hide_status=$('#show_hide'+id).val();
	if(show_hide_status==0){
  	$('#max_part'+id).show();
		$('#min_part'+id).hide();
		$('#show_hide'+id).val(1);
	}else{
 		$('#max_part'+id).hide();
		$('#min_part'+id).show();
		$('#show_hide'+id).val(0);
	}
 }
 
  
 
</script>
 
