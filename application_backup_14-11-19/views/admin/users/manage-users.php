
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
       Manage Users
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active">Manage Users</li>
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
          <div class="form-group text-right">
            <a href="<?php echo base_url('admin-add-user');?>" class="btn btn-primary">Add New User</a>
            <a href="javascript:void(0)" class="btn btn-primary" style="margin-top: -2px;display:none;" id="checkbox_action">Send Notification</a>
          </div>
          <div class="row">
            <div class="col-md-3 col-sm-6 form-group">
            <select class="form-control" id="change_role" name="role_id">
            <option value="">Select Role</option>
           
             <?php
              $role_list=getRoleList();
             foreach($role_list as $role){
              ?>
              <option value="<?php echo $role['id']?>"><?php echo $role['name'];?></option>
              <?php
            }
            ?>
              </select>
             
          </div>
           <div class="col-md-3 col-sm-6 form-group">
            <select class="form-control" id="change_status" name="change_status">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In-active</option>
            </select>
           </div>
           <div class="col-md-3 col-sm-6 form-group">
            <input type="text" class="form-control" id="search"  name="search" placeholder="Search Name/Email/Phone">
            </div>
        </div>  
        <div class="form-group text-right">
          <input type="submit" class="btn btn-primary" id="export" name="export" value="Export users">
        </div>

      </form>
        <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="user_list" style="width: 100%;">
           <thead class="" style="white-space:nowrap;">
           <tr>
           <th>Sr. No.</th>
               <th><input name="select_all" value="" id="user_checkbox" type="checkbox" class="" /></th>
               <th>Name</th>
               <th>Role</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Total Address</th>
               <th>Image</th>
                <th>Status</th>
               <th>Action</th>
             </tr>
           </thead>
           <tbody>
           </tbody>
         </table>
         <input type="hidden" id="selected_user_string">
       </div>
       </div>

     </div>
            </div>
          </div>
          
        </section>
    <!-- /.content -->



    <div class="modal fade" id="sendNotificationPopup" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content-->
       <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Notification</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
        <div id="notification_message"></div>
        <div class="row">
          <div class="form-group col-md-12">
            <label for="Subject">Subject<span class="mandatory">*</span></label>
            <input type="text" class="form-control" id="subject" name="subject" placeholder="Subject" value="">
            <span id="subject_error" class="error"></span>
          </div>
          <div class="form-group col-md-12">
            <label for="Message">Message<span class="mandatory">*</span></label>
            <textarea name="message"  class="form-control" id="message" name="message" style="margin: 0px -1px 0px 0px; height: 195px; width: 572px;" placeholder="Message" ></textarea>
            <span id="message_error" class="error"></span>
          </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="send_notification">Send <span id="send_notification_loader"></span></button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
       
    </div>
  </div>


  <?php
 
  $this->load->view('admin/includes/footer');?>
 
  <script>
 var user_list_table='';
    $(function () {  
  user_list_table = $('#user_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-user-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.role_id = $('#change_role').val();
        d.status = $('#change_status').val();
        d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'id',"orderable":false},
      {data: 'name'},
      {data: 'role_name'},
      {data: 'email'}, 
      {data: 'phone'}, 
      {data: 'total_address',class:'center'}, 
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
   					'targets':1,
  					"render": function ( data, type, row ) {
              var class_name= " selected_userwt";
              var disable= " ";
              if(row['status']==0){
                disable= " disabled";
                class_name= " disabled";
              }
             
						return '<input name= "selected_userwt"  value="'+data+'" '+ disable +' type="checkbox" class="'+class_name+'" id="check_'+data+'" onclick="check_user(this.checked,'+data+');">';
 				}
   				 
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
          
           "targets":3 
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
            return  '<a href="<?php echo base_url('admin-manage-user-addresses/');?>'+row['id']+'">'+data+'</a>';
          },
          
           "targets": 6 
          },
          {
            "render": function ( data, type, row ) {
							return '<img src="'+data+'">';
          },
          
           "targets": 7
          },
         
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeUserStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 8
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-user/');?>'+row['id']+'" title="View User" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';

            html += '<a href="<?php echo base_url('admin-update-user/')?>'+row['id']+'" title="Update User" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';

            html +='<a href="<?php echo base_url('admin-manage-user-addresses/');?>'+row['id']+'" title="User Address List" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-list"></span></a> ';

            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete User" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets": 9 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        setCheckboxSelected(data);
      }
    });

    $('#change_role,#change_status').change(function(){
      user_list_table.ajax.reload();
    });
    $('#user_checkbox').on('click', function() {
			if ($('#user_checkbox').is(':checked')) {
        $('#checkbox_action').show();
				$('#user_list td .selected_userwt').prop('checked', true);
			} else {
        $('#checkbox_action').hide();
				$('#user_list td .selected_userwt').prop('checked', false);
			}
			select_all_user(status);
		});
    $('#search').on('keyup', function() {
      user_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-user')?>',user_list_table);
    });

    $('#checkbox_action').click(function(){
      $('#notification_message').html('');
      $('.form-control').removeClass('error');
      $('.error').html('');
       $('#sendNotificationPopup').modal('show');
    })

    $('#send_notification').click(function(){
      buttonEnableDisable('send_notification', 1);
      $('#notification_message').html('');
      $('.form-control').removeClass('error');
      $('.error').html('');
      $.ajax({
			type: "POST",
			url: '<?php echo base_url('admin-send-customer-notification');?>',
			data: {
        'user_ids':$('#selected_user_string').val(),
        'subject':$('#subject').val(),
        'message':$('#message').val(),
      },
			success: function(ajaxresponse){
				  response=JSON.parse(ajaxresponse);
				if(!response['status']){
					$.each(response['response'], function(key, value) {
						$('#' + key).addClass('error');
						$('#'+key+'_error').html(value);
					});
					$('#notification_message').html('<div class="alert alert-danger">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          buttonEnableDisable('send_notification', 0);
				}else{
					$('#notification_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
          buttonEnableDisable('send_notification', 0);
					setTimeout(function(){
						location.reload();
						}, 1000);
					   
				}  
			}
		});
    })
    })

    function changeUserStatus(id,status){
      if(id>0){
        if (!$('#check_'+id).is(':checked')) {
          changeDataStatus('changeUserStatus',id,status,'<?php echo base_url('admin-change-user-status')?>',user_list_table);
        }
    }
    } 

  function select_all_user(isChecked){
		var new_string='';
		var selected_user_str=removeDuplicateArrayValue($("#selected_user_string").val());
		var remove_user_arr=[];
		$('.selected_userwt').each(function (index, obj) {
			if (this.checked === true) {
				var user_id=obj.value;
				if(user_id>0){
					selected_user_str += user_id + ',';
				}
			}else{
				remove_user_arr.push(obj.value);
 			}
		});
		var exsiting_user_array=selected_user_str.split(',');
  		if(exsiting_user_array.length>0){
		    var new_array=[]
		    for(i=0;i<exsiting_user_array.length;i++){
				if(exsiting_user_array[i]!=''){
 					var check_exist=remove_user_arr.indexOf(exsiting_user_array[i]);
					if(check_exist==-1){
						var check_exist1=new_array.indexOf(exsiting_user_array[i]);
						if(check_exist1!=-1){
						}else{
							new_array.push(exsiting_user_array[i]);
							new_string +=exsiting_user_array[i]+',';
						}
					}
				}
			}
		}
    if(new_string!=''){
      //$('#checkbox_action').show();
    }else{
      //$('#checkbox_action').hide();
    }
		$("#selected_user_string").val(new_string);		 
		
  }

  function check_user(isChecked,user_id){
		var selected_user_str='';
		var new_string='';
		var existing_user=removeDuplicateArrayValue($("#selected_user_string").val());
		if(existing_user.length>0){
			selected_user_str =existing_user + user_id + ',';
		}else{
			selected_user_str =existing_user +  user_id + ',';
		}
		var exsiting_user_array=selected_user_str.split(',');
		if(exsiting_user_array.length>0){
			var new_array=[]
			for(i=0;i<exsiting_user_array.length;i++){
				if(exsiting_user_array[i]!=''){
					var check_exist=new_array.indexOf(exsiting_user_array[i]);
					if(check_exist!=-1){
						$("#"+exsiting_user_array[i]).remove();
					}else{
						if(!isChecked){
							if(exsiting_user_array[i]!=user_id){
								new_array.push(exsiting_user_array[i]);
								new_string +=exsiting_user_array[i]+',';
							}
						}else{
							new_array.push(exsiting_user_array[i]);
							new_string +=exsiting_user_array[i]+',';
						}
					}
				}
			}
    }
 		if($('.selected_userwt:checked').length == $('.selected_userwt').length){
      $('#user_checkbox').prop('checked',true);
		}else{
      $('#user_checkbox').prop('checked',false);
		}
    if(new_string!=''){
      $('#checkbox_action').show();
     }else{
      $('#checkbox_action').hide();
     }
		$("#selected_user_string").val(new_string);		 
  }

  function removeDuplicateArrayValue(str){
 		if(str!=undefined){
			var str_array=str.split(",");
			var result = [];
			var new_str='';
			$.each(str_array, function(i, e) {
				if ($.inArray(e, result) == -1){
					result.push(e);
					new_str += e +',';
				} 
			});
			return new_str.slice(0, -1);
		}
  }
  
  function checkBoxControl(){
    var existing_user_str=removeDuplicateArrayValue($("#selected_user_string").val());
		if(existing_user_str!=''){
      var exsiting_user_array=existing_user_str.split(',');
 			if(exsiting_user_array.length>0){
 
				for(i=0;i<exsiting_user_array.length;i++){
					$('#check_'+exsiting_user_array[i]).prop('checked',true);
				}
        if($('.selected_userwt:checked').length == $('.selected_userwt').length){
          $('#user_checkbox').prop('checked',true);
 				}else{
					$('#user_checkbox').prop('checked',false);
				}
			}
		}
  }

  
  function setCheckboxSelected(data){
		//var id=$('#serial_no').val();
		setTimeout(function(){
		 checkBoxControl();
 			}, 125);
  }
  

</script>
 
