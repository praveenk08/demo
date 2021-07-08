
<?php
 $this->load->view('vendor/includes/header');?>
  <section class="content-header">
   <h1>
      Manage Orders
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('vendor-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active"> Manage Orders</li>
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
            </div>
            <?php } ?>
         </div>
         <div class="tableTop">
            <div class="row">
               <div class="col-md-2 col-sm-4 form-group">
                  <select class="form-control" id="change_customer">
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
                  <select class="form-control" id="change_status">
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
                  <select class="form-control" id="change_date">
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
                    <input type="text" class="form-control" id="search" placeholder="Search Order ID">
                </div>
 
                
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
</section>
  <?php
 
  $this->load->view('vendor/includes/footer');?>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/js/bootstrap-datetimepicker.min.js"></script>

  <script>
 var order_list_table='';
    $(function () { 
      order_list_table = $('#order_list').DataTable({
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
      url :"<?php echo base_url('vendor-manage-orders-ajax')?>", 
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
              return "<span class='"+row['class']+"'>"+data+"</span>";
          },
          
           "targets":8 
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
			actionPerform('<?php echo base_url('vendor-delete-order')?>',order_list_table);
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
      var id = row.data().order_id;	
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
 
    function changeOrderStatus(id,status){
	    if(id>0){
        changeDataStatus('changeOrderStatus',id,status,'<?php echo base_url('vendor-change-order-status')?>',order_list_table);
    }
  } 
  function orderDetails(row){
    var id = row.data().order_id;	
    row.child(datatable_loader).show();
     $.ajax({
			type: "POST",
			url: '<?php echo base_url('vendor-order-details')?>',
			data: {'id':id},
			success: function(ajaxresponse){
      response=JSON.parse(ajaxresponse);
      var html='<table class="table table-dark table-striped"  id="order_details_table">';
      html +=response['order_products'];
      html +='</table>';
      html +='<table class="table table-dark table-striped"  id="order_address_table">';
      html +=response['order_address'];
      html +='</table>';
			row.child(html).show();
			}
		});
  }

 
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