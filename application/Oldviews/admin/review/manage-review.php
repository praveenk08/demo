
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (review header) -->
     
    <section class="content-header">
      <h1>
      Manage Review
       </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"> Manage Review</li>
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
          
            
          <?php
                $vendor_list=getUserList(array('u.is_deleted'=>0,'u.role_id'=>2));
          ?>

           <div class="col-md-3 col-sm-6 form-group">
           <select class="form-control" id="change_vendor">
              <option value="">Select Vendor</option>
              <?php if(count($vendor_list)>0){
                  foreach($vendor_list as $vendor){
                    ?>
                    <option value="<?php echo $vendor['id']?>"><?php echo $vendor['name'];?></option>
                    <?php
                  }
              }
              ?>
            </select>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
            <select class="form-control" id="change_rating">
            <option value="">Select Rating</option>
            <?php
            for($i=1;$i<=5;$i++){
              ?>
              <option value="<?php echo $i;?>"><?php echo str_repeat('&#9733;',$i);?></option>
              <?php
            }
            ?>
            </select>
            </div>
            <div class="col-md-3 col-sm-6 form-group">
            <select class="form-control" id="change_status">
            <option value="">Select Status</option>
            <option value="1">Active</option>
            <option value="0">In-active</option>
            </select>
           </div>
           <div class="col-md-3 col-sm-6 form-group">
           <input type="text" class="form-control" id="search" placeholder="Search Customer Name/Title/Review">
            </div>

        </div>
         <div class="managePrdTable">
       <div class="dataTables_wrapper">
       <table class="table table-bordered table-striped" id="review_list" style="width: 100%;">
           <thead>
           <tr>
             <th>Sr. No.</th>
            <!-- <th><input name="select_all" value="" id="review_checkbox" type="checkbox" class="" /></th>-->
               <th>Customer</th>
               <th>Vendor</th>
               <th>Title</th>
               <th>Review</th>
               <th>Rating</th>
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
 var review_list_table='';
    $(function () { 
   review_list_table = $('#review_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-review-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.status = $('#change_status').val();
        d.rating = $('#change_rating').val();
        d.vendor_id = $('#change_vendor').val();
        d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      //{data: 'id',"orderable":false},
      {data: 'customer_name'}, 
      {data: 'vendor_name'}, 
      {data: 'title'}, 
      {data: 'review'}, 
      {data: 'rating'},
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
        //  {
   				//	'targets':1,
  				//	"render": function ( data, type, row ) {
					//	return '<input name= "selected_reviewt"  value="'+data+'" type="checkbox" class="selected_reviewt" id="check_'+data+'" onclick="check_review(this.checked,'+data+');">';
 				//	}
   				 
          // },
           
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
             var  html= data+' <!--<a href="javascript:void(0);" onClick="updateTitle('+row['id']+')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>';
             html +='<input type="hidden" id="title_show_status'+row['id']+'" value="0"><div style="display:none;" class="update_data" id="update_title'+row['id']+'"><input  class="form-control" type="text" id="title'+row['id']+'" value="'+row['title']+'" onblur="updateReviewData('+row['id']+')"></div>';
             return html;
              },
          
           "targets": 3 
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
										main_message += data.substr(0, 50) + more;
										main_message += '</span><!--<a href="javascript:void(0);" onClick="updateReview('+row['id']+')"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>-->';
                    main_message += '<div style="display:none;" class="update_data" id="update_review'+row['id']+'"><input type="hidden" id="review_show_status'+row['id']+'" value="0"><textarea  style="min-width: 200px;" class="form-control" id="review'+row['id']+'" onblur="updateReviewData('+row['id']+')">'+row['review']+'</textarea></div>';
                    return main_message;


					
           },
          
           "targets":4 
          },
          {
            "render": function ( data, type, row ) {
              return claculateReview(row);
           },
          
           "targets": 5 
          },
          
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeReviewtatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 6 
          },
          {
            "render": function ( data, type, row ) {
             
           var html ='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" title="Delete review" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a>';
     
            return html;
          },
          
           "targets":7 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        setCheckboxSelected(data);
      }
    });
    $('#review_checkbox').on('click', function() {
			if ($('#review_checkbox').is(':checked')) {
				$('#review_list td input[type="checkbox"]').prop('checked', true);
			} else {
				$('#review_list td input[type="checkbox"]').prop('checked', false);
			}
			select_all_review(status);
		});
    $('#change_status,#change_rating,#change_vendor').change(function(){
      review_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
 			review_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-review')?>',review_list_table);
    });
    
    //$('.rating').click(function(){
      //alert(this);
   // })
     
    })
    function select_all_review(isChecked){
		var new_string='';
		var selected_review_str=removeDuplicateArrayValue($("#selected_review_string").val());
		var remove_review_arr=[];
		$('.selected_reviewt').each(function (index, obj) {
			if (this.checked === true) {
				var review_id=obj.value;
				if(review_id>0){
					selected_review_str += review_id + ',';
				}
			}else{
				remove_review_arr.push(obj.value);
 			}
		});
		var exsiting_review_array=selected_review_str.split(',');
  		if(exsiting_review_array.length>0){
		    var new_array=[]
		    for(i=0;i<exsiting_review_array.length;i++){
				if(exsiting_review_array[i]!=''){
 					var check_exist=remove_review_arr.indexOf(exsiting_review_array[i]);
					if(check_exist==-1){
						var check_exist1=new_array.indexOf(exsiting_review_array[i]);
						if(check_exist1!=-1){
						}else{
							new_array.push(exsiting_review_array[i]);
							new_string +=exsiting_review_array[i]+',';
						}
					}
				}
			}
		}
    if(new_string!=''){
      $('#checkbox_action').show();
    }else{
      $('#checkbox_action').hide();
    }
		$("#selected_review_string").val(new_string);		 
		
  }
  
  function check_review(isChecked,review_id){
		var selected_review_str='';
		var new_string='';
		var existing_review=removeDuplicateArrayValue($("#selected_review_string").val());
		if(existing_review.length>0){
			selected_review_str =existing_review + review_id + ',';
		}else{
			selected_review_str =existing_review +  review_id + ',';
		}
		var exsiting_review_array=selected_review_str.split(',');
		if(exsiting_review_array.length>0){
			var new_array=[]
			for(i=0;i<exsiting_review_array.length;i++){
				if(exsiting_review_array[i]!=''){
					var check_exist=new_array.indexOf(exsiting_review_array[i]);
					if(check_exist!=-1){
						$("#"+exsiting_review_array[i]).remove();
					}else{
						if(!isChecked){
							if(exsiting_review_array[i]!=review_id){
								new_array.push(exsiting_review_array[i]);
								new_string +=exsiting_review_array[i]+',';
							}
						}else{
							new_array.push(exsiting_review_array[i]);
							new_string +=exsiting_review_array[i]+',';
						}
					}
				}
			}
		}
		if($('.selected_reviewt:checked').length == $('.selected_reviewt').length){
			$('#review_checkbox').prop('checked',true);
		}else{
			$('#review_checkbox').prop('checked',false);
		}
    if(new_string!=''){
      $('#checkbox_action').show();
    }else{
      $('#checkbox_action').hide();
    }
		$("#selected_review_string").val(new_string);		 
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
function updateTitle(id){
  var title_show_status=$('#title_show_status'+id).val();
  $('.update_data').hide();
  if(title_show_status==0){
    $('#update_title'+id).show();
    $('#title_show_status'+id).val(1);
  }else{
    $('#title_show_status'+id).val(0);
  }
  
}
function updateReview(id){
  var review_show_status=$('#review_show_status'+id).val();
  $('.update_data').hide();
  if(review_show_status==0){
    $('#update_review'+id).show();
    $('#review_show_status'+id).val(1);
  }else{
    $('#review_show_status'+id).val(0);
  }
  
  
}
    function changeReviewtatus(id,status){
	    if(id>0){
        changeDataStatus('changeReviewtatus',id,status,'<?php echo base_url('admin-change-review-status')?>',review_list_table);
    }
  } 
  function claculateReview(row){
    var response='';
    for(i=1;i<=5;i++){
      var classname=' fa fa-star-o';
      if(i<=row['rating']){
        var classname=' fa fa-star';
      }
      response +='<span style="white-space:nowrap;"><i class="'+row['id']+ classname+'"  id="'+i+row['id']+'" onclick="setRating('+i+','+row['id']+')"></i></span>';
    }
    return response;
  }
  function setRating(rating,id){
    $('#success_message').html('');
    $('.'+id).removeClass();
    for(i=1;i<=5;i++){
      if(i<=rating){
        $('#'+i+id).addClass(id+' fa fa-star');
      }else{
        $('#'+i+id).addClass(id+' fa fa-star-o');
      }
    }
    $.ajax({
      url: '<?php echo base_url('admin-change-rating');?>',
      type: "POST",
      data: {"id":id,"rating":rating,},
      success: function (ajaxresponse) { 
        response=JSON.parse(ajaxresponse);
        var response_status=response['status'];
        $('#success_message').show();
        $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        review_list_table.ajax.reload();
        closePopup('success_message');
      }
    }) 
  }

  function updateReviewData(id){
    $('#success_message').html('');
    var title=$('#title'+id).val();
    var review=$('#review'+id).val();
    $.ajax({
      url: '<?php echo base_url('admin-update-rating');?>',
      type: "POST",
      data: {"id":id,"title":title,"review":review,},
      success: function (ajaxresponse) { 
        response=JSON.parse(ajaxresponse);
        var response_status=response['status'];
        $('#success_message').show();
        $('#success_message').html('<div class="alert alert-success">'+response['message']+'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
        review_list_table.ajax.reload();
        closePopup('success_message');
      }
    })
  }
	function checkBoxControl(){
		var existing_review_str=removeDuplicateArrayValue($("#selected_review_string").val());
		if(existing_review_str!=undefined){
			var exsiting_review_array=existing_review_str.split(',');
			if(exsiting_review_array.length>0){
				for(i=0;i<exsiting_review_array.length;i++){
					$('#check_'+exsiting_review_array[i]).prop('checked',true);
				}
				if($('.selected_reviewt:checked').length == $('.selected_reviewt').length){
					$('#review_checkbox').prop('checked',true);
				}else{
					$('#review_checkbox').prop('checked',false);
				}
			}
		}
	}
	function setCheckboxSelected(data){
		//var id=$('#serial_no').val();
		setTimeout(function(){
		 checkBoxControl();
 			}, 250);
	}
 $(document).ready(function(){

  /**
   $(document).on('click','i.fa.fa-star',function(){
      //$(this).parent().parent().parent().parent().parent().css('background','red');
      $(this).nextAll().removeClass('fa-star');
      $(this).nextAll().addClass('fa-star-o');
   });

   $(document).on('click','i.fa.fa-star-o',function(){
      $(this).removeClass('fa-star-o');
      $(this).addClass('fa-star');
      $(this).prevAll().removeClass('fa-star-o');
      $(this).prevAll().addClass('fa-star');
   });
   */

 })
 
</script>
 
