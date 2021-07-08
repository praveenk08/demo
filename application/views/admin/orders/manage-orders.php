
<?php
 $this->load->view('admin/includes/header');?>

<section class="content-header">
   <h1>
      Manage Orders
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Manage Orders</li>
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
            </div>
            <?php } ?>
         </div>

         <div class="tableTop">
            <form method="post">
               <div class="row">
                  <div class="col-md-2 col-sm-4 form-group">
                     <select class="form-control" id="change_customer" name="change_customer">
                        <option value="">Select Customer</option>
                        <?php
                           foreach($customers as $customer){
                           ?>
                        <option value="<?php echo $customer['id'];?>"><?php  echo $customer['name'];?></option>
                        <?php
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-4 form-group">
                     <select class="form-control" id="change_status" name="change_status">
                     <?php
                     $order_status_list=getOrderStatus();
                     ?>
                        <option value="">Select Status</option>
                        <?php
                        foreach($order_status_list  as $order_status_list){
                        ?>
                           <option value="<?php echo $order_status_list['id'];?>"><?php echo $order_status_list['name'];?></option>
                        <?php
                        }
                        ?>
                     </select>
                  </div>
                  <div class="col-md-2 col-sm-4 form-group">
                     <select class="form-control" id="change_date" name="change_date">
                        <option value="">Select Date</option>
                        <option value="0">Today</option>
                        <option value="1">Yesterday</option>
                        <option value="2">Last 7 Days</option>
                        <option value="3">Last 15 Days</option>
                        <option value="4">This Month</option>
                        <option value="5">Last Month</option>
                        <option value="6">Last 6 Months</option>
                        <option value="7">This Year</option>
                        <option value="8">Last Year</option>
                        <option value="9">Select Custom Date</option>
                     </select>
                  </div>
                  <div id="calender_part" class="col-md-4 col-sm-8" style="display:none;"></div>
                  <div class="col-md-2 col-sm-4 form-group">
                     <input type="text" class="form-control" id="search" name="search" placeholder="Search Order ID">
                  </div>
                  <div class="col-md-2 col-sm-4 form-group">
                     <input type="submit" name="export" id="export" value="Export File" class="btn btn-primary">
                  </div>
               </div>
            </form>
         </div>

         <div class="managePrdTable">
            <div class="dataTables_wrapper">
               <table class="table table-bordered table-striped" id="order_list" style="width: 100%;">
                  <thead>
                     <tr>
                        <th>Sr. No.</th>
                        <th></th>
                        <th>Order ID</th>
                        <th>Transition ID</th>
                        <th>Customer</th>
                        <th>Total Product</th>
                        <th>Total Amount</th>
                        <th>Order Datetime</th>
                        <th>Payment Status</th>
                        <th>Order Status</th>
                     </tr>
                  </thead>
                  <tbody>
                  </tbody>
               </table>
            </div>
         </div>

      </div>
   </div>

   <div class="modal fade" id="delivery-boy-popup" role="dialog">
      <div class="modal-dialog">
         <!-- Modal content-->
         <div class="modal-content">
            <div class="modal-body">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <h2>Assign Order to Delivery Boy</h2>
               <div class="table-responsive">
                  <table class="table">
                     <thead>
                        <tr>
                        <th>Sr.No.</th>
                        <th>&nbsp;</th>
                        <th>Delivery Boy Name</th>
                        <th>Email</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        $sr=1;
                        $delivery_boys=getSingleTableData('users',array('role_id'=>4,'status'=>1,'is_deleted'=>0),array('key'=>'id','value'=>'ASC'));
                        foreach($delivery_boys as $delivery_boy){
                           ?>
                           <tr>
                           <td><?php echo $sr;?></td>
                           <td><input type="radio"  class="select_delivery_boy" name="selectdeliveryboy" value="<?php echo $delivery_boy['id'];?>"></td>
                           <td><?php echo $delivery_boy['first_name'].' '.$delivery_boy['last_name'];?></td>
                           <td><?php echo $delivery_boy['email'];?></td>
                        </tr>
                           <?php
                           $sr++;
                        }
                     ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <div class="modal-footer">
               <input type="hidden" id="select_order_id" value="0">
               <button type="button" class="btn btn-primary" id="SelectDeliveryBoy" disabled>Assign Order<span id="SelectDeliveryBoy_loader"></span></button>&nbsp;&nbsp;&nbsp;
               <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
            </div>
         </div>
      </div>
   </div>

</section>

<?php
$this->load->view('admin/includes/footer');?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>
<script>
 var order_list_table='';
    $(function(){ 
      $('.select_delivery_boy').click(function(){
         thisRadio = $(this);
         if (thisRadio.hasClass("imChecked")) {
            thisRadio.removeClass("imChecked");
            thisRadio.prop('checked', false);
               $('#SelectDeliveryBoy').prop('disabled', true);
            }
         else { 
            thisRadio.prop('checked', true);
            thisRadio.addClass("imChecked");
            $('#SelectDeliveryBoy').prop('disabled', false);
         };
      })
      $('#SelectDeliveryBoy').click(function(){
         $('#delivery-boy-popup').modal('hide');
         var selected_delivery_boy = $("input[name='selectdeliveryboy']:checked").val();
          if(selected_delivery_boy){
            $('#selected_delivery_boy').val(selected_delivery_boy);
            var id=$('#select_order_id').val();
            $('#success_message').html('<div class="alert alert-success">Order assigned to delivery boy successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            updateOrderStatus(id,3,'<?php echo base_url('admin-change-order-status')?>',order_list_table);
         }
       })

   order_list_table = $('#order_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-orders-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.status = $('#change_status').val();
        d.customer_id = $('#change_customer').val();
        d.change_date=$('#change_date').val();
        if(d.change_date==9){
          d.from_date=$('#from_date').val();
          d.to_date=$('#to_date').val();
        }else{
          d.from_date='';
          d.to_date='';
        }
        d.search = $('#search').val();
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {
			"class":'details-control',
			"orderable": false,
			"sortable" : false,
			"data"     : null,
			"defaultContent": ''
		},
       {data: 'order_id'}, 
      {data: 'transaction_id'}, 
      {data: 'customer_name'}, 
      {data: 'total_product',class:'right-align'}, 
      {data: 'total_amount',class:'right-align'},
      {data: 'order_date'}, 
      {data: 'payment_status'}, 
      {data: 'order_status'}, 
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
          
           "targets":2 
          },
          {
            "render": function ( data, type, row ) {
               return data;
           },
          
           "targets": 3 
          },
          {
            "render": function ( data, type, row ) {
              return data

              },
          
           "targets":4 
          },
          {
            "render": function ( data, type, row ) {
              
              return data
           },
          
           "targets":5 
          },
          {
            "render": function ( data, type, row ) {
              return '$'+data

           },
          
           "targets": 6 
          },
          
          {
            "render": function ( data, type, row ) {
              return data

          },
          
           "targets": 7 
          },
          {
            "render": function ( data, type, row ) {
              if(data==1){
               return '<span class="label label-success">PAID</span>';
              }else{
                 return '<span class="label label-danger">UNPAID</span>';
              }

          },
          
           "targets":8 
          },
          {
            "render": function ( data, type, row ) {
               var html='';
               if(row['transaction_id']!=''){
                  html +='<select class="form-control" id="change_order_status'+row['order_id']+'" name="change_order_status" onChange="changeOrderStatus('+row['order_id']+')">';
                  if(data==1){
                     html +='<option value="1" selected>Pending</option>';
                     html +='<option value="2">Processing</option>';
                  }else if(data==2){
                     html +='<option value="2" selected>Processing</option>';
                     html +='<option value="3">Assign Delivery Boy</option>';
                  }else if(data==3){
                     html +='<option value="3" selected>Assign Delivery Boy</option>';
                     html +='<option value="4">Ready to ship</option>';
                  }else if(data==4){
                     html +='<option value="4" selected>Ready to ship</option>';
                     html +='<option value="5">Completed</option>';
                  }
                  else if(data==5){
                     html +='<option value="5" selected>Completed</option>';
                  }
               html +='</select>';
               }
              return html;// "<span class='"+row['class']+"'>"+data+"</span>";
          },
          
           "targets":9 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });
    $('#order_checkbox').on('click', function() {
			if ($('#order_checkbox').is(':checked')) {
				$('#order_list td input[type="checkbox"]').prop('checked', true);
			} else {
				$('#order_list td input[type="checkbox"]').prop('checked', false);
			}
			select_all_order(status);
		});
    $('#change_status,#change_customer,#to_date').change(function(){
      order_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
      order_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-order')?>',order_list_table);
    });
    
    $('#order_list tbody').on( 'click', 'tr td.details-control', function () {
		var tr = $(this).closest('tr');
		var row = order_list_table.row( tr );
				  if ( row.child.isShown() ) {
			tr.removeClass( 'details' );
			row.child.hide();
		}
		else {
			tr.addClass( 'details' );
      orderDetails(row);
      var id = row.data()['order_id'];
      $(tr).attr('row_id', id);
      close_existing_module(id,order_list_table);
				}
	} );
     
  $('#change_date').change(function(){
    var id=this.value;
    $('#calender_part').hide();
    $('#calender_part').html('');
    var html='';
    if(id==9){
      html +='<div class="row"><div class="col-sm-6"><input type="text" class="form-control date" autocomplete="off" id="from_date"></div>';
      html +='<div class="col-sm-6"><input type="text" class="form-control date" autocomplete="off" id="to_date"></div></div>';
      $('#calender_part').html(html);
      $('#calender_part').show();
    $('.date').datepicker({
    format: 'dd-mm-yyyy',
    }).on('changeDate', function(e) {
      order_list_table.ajax.reload();
  });
    }else{
      order_list_table.ajax.reload();
    }
  })
  
     })
 
    function changeOrderStatus(id){
	    if(id>0){
          var status=$('#change_order_status'+id).val();
           if(status==3){
            $('#delivery-boy-popup').modal('show');
            $('#select_order_id').val(id);
          }else{
            $('#success_message').html('<div class="alert alert-success">Order status updated successfully!<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>');
            updateOrderStatus(id,status,'<?php echo base_url('admin-change-order-status')?>',order_list_table);
         }
      }
  } 
  function orderDetails(row){
    var id = row.data().order_id;	
    var html='<table class="table table-dark table-striped"  id="order_details_table">';
    row.child(datatable_loader).show();
     $.ajax({
			type: "POST",
			url: '<?php echo base_url('admin-order-details')?>',
			data: {'id':id},
			success: function(ajaxresponse){
		  response=JSON.parse(ajaxresponse);
      html +=response['order_products'];
      html +='</table>';
      html +='<table class="table table-dark table-striped"  id="order_address_table">';
      html +=response['order_address'];
      html +='</table>';
			row.child(html).show();
			}
		});
  }

 //function changeOrderStatus(id){
  //var order_status=$('#change_order_status'+id).val();
 // if(order_status==3){
    //  $('#delivery-boy-popup').modal('show');
  //}
 //}
  function close_existing_module(main_id,order_list_table){
	$('#order_list >tbody >tr').each(function() {
		var tr = $(this).closest('tr');
		var row = order_list_table.row( tr );
		var id=$(tr).attr("row_id");
		if (typeof(id) == "undefined") {
			id=0;
		 }
		if ($(this).hasClass('details') && main_id!=id) {
			row.child.hide();
			tr.removeClass('details');
		}
	});	
} 

</script>