
<?php
 $this->load->view('admin/includes/header');?>
 

    <section class="content-header">
      <h1>
      Manage Matching and Connections
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Manage Matching and Connections</li>
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
        <form method="post"> 
       
          <div class="row">
          

              <div class="col-md-3 col-sm-6 form-group">
              <?php
              $categories=categoryList(array('c.parent_id'=>0,'c.status'=>1,'ct.abbr'=>'en'));
              ?>
              <select id="change_category" class="form-control">
              <option value="">Select category</option>
              <?php
              foreach($categories as $category){
              ?>
              <option value="<?php echo $category['id']?>"><?php echo $category['name'];?></option>
              <?php
              }
              ?>
              </select>
              </div>
              <div class="col-md-3 col-sm-6 form-group">
              <select id="change_child_category" class="form-control change">
                <option value="">Select Sub Category</option>
                </select>
                </div>
               <div class="col-md-3 col-sm-6 form-group">
                     <?php
                        $user_list=getUserList($where=array('u.is_deleted'=>0,'u.role_id'=>3));
                        ?>
                     <select class="form-control" id="change_customer" name="change_customer">
                         <?php if(count($user_list)>0){
                           foreach($user_list as $user){
                             ?>
                        <option value="<?php echo $user['id']?>" <?php if($user['id']==$customer_id){ echo "Selected";}?>><?php echo $user['name'];?></option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
           
         
            <!--<div class="col-md-2 form-group">
              <input type="submit" class="btn btn-primary" id="export" name="export" value="Export">
            </div>-->            
        </div>
      </form>
         <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="matching_and_connections_list" style="width: 100%;">
           <thead>
           <tr>
           <th>S.No.</th>
              <th>Image</th>
              <th>Sub Category</th>
              <th>Main Category</th>
              <th>Customer</th>
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
          <input type="hidden" id="category_id" value="">

        </section>


    <!-- /.content -->
  <?php
 
  $this->load->view('admin/includes/footer');?>
  <script>
 var matching_and_connections_list_table='';
    $(function () { 
   matching_and_connections_list_table = $('#matching_and_connections_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-matching-and-connections-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.change_customer = $('#change_customer').val();
        d.category_id = $('#category_id').val();
        d.change_type = $('#change_type').val();
         d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
        {data: 'id',"orderable":false},
        {data: 'image'}, 
        {data: 'category_name'}, 
        {data: 'parent_category_name'}, 
        {data: 'customer_name'}, 
        {data: 'status'}, 
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
              return '<span id="image_'+row['id']+'"><img src="'+data+'" style="height:80px;width:80px"></span>';
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
               var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="addUpdateStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
 
           },
          
           "targets": 5 
          },
         
          
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });
 
    $('#change_status,#change_customer,#change_type').change(function(){
      matching_and_connections_list_table.ajax.reload();
    });
    $('.change').change(function(){
				var change_child_category=$('#change_child_category').val();
 				if(change_child_category==null || change_child_category==''){
					$('#category_id').val($('#change_category').val());
          $('#change_category').trigger('change');
				}else{
					$('#category_id').val($('#change_child_category').val());
          matching_and_connections_list_table.ajax.reload();
				}
       
			})

    $('#search').on('keyup', function() {
 			matching_and_connections_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-matching_and_connections')?>',matching_and_connections_list_table);
    });
 

    $('#change_category').change(function(){
				var category_id=this.value;
				if(category_id!=''){
					$('#change_child_category').html('');
					var change_child_category_html="<option value=''>Select Sub Category</option>";
					$.ajax({
						type: "POST",
						url: '<?php echo base_url(); ?>common/Common/getChildCategories/',
						data: {'id':category_id},
						success: function (ajaxresponse) {
							response = JSON.parse(ajaxresponse);
							if(response.length){
								for(i=0;i<response.length;i++){
									change_child_category_html +='<option value="'+response[i]['id']+'">'+response[i]['name']+'</option>';
								}
							}
							$('#change_child_category').html(change_child_category_html);
						}
					});
          $('#category_id').val(category_id);

				}else{
					$('#change_child_category').html(change_child_category_html);
          $('#change_child_category').val('');
          $('#category_id').val('');
				}
        matching_and_connections_list_table.ajax.reload();
			})


      $('#change_customer').change(function(){
      var CURRENTURL= window.location.href; 
      var new_url='<?php echo base_url('admin-manage-matching-and-connections')?>';
      if(this.value>0){
        new_url +='/'+this.value;
        ChangeUrl(CURRENTURL,new_url);     
      }
    })
     
    })
   
   
  

  function addUpdateStatus(id,status){
			$('#status'+id).html('');
  			if(status==1){
				var set_status=0;
			}else{
				var set_status=1;
			}
 			$.ajax({
				type: "POST",
        url :"<?php echo base_url('admin-change-manage-matching-and-connections-status')?>", 
				data: {'id':id,'status':set_status},
				success: function(ajaxresponse){
					response=JSON.parse(ajaxresponse);
					if(response['status']){ 
						if(set_status){
							var html='<a href="javascript:void(0)" onClick="addUpdateStatus('+id+','+set_status+')"><span class="btn btn-sm btn-success">Active</span></a>';
						}else{
							var html='<a href="javascript:void(0)" onClick="addUpdateStatus('+id+','+set_status+')"><span class="btn btn-sm btn-danger">In-active</span></a>';
						}
						$('#status'+id).html(html);
					}
				}
		});	
 		}
 
 
  
 
</script>
 
