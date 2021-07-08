
<?php
 $this->load->view('vendor/includes/header');?>

    <!-- Content Header (Page header) -->

<section class="content-header">
  <h1>
  Manage customer Addresses
  </h1>
  <ol class="breadcrumb">
    <li><a href="<?php echo base_url('vendor-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
    <li class="active">Manage customer Addresses</li>
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
        <form>
          <div class="row">
          <?php
          $customer_list=getVenodrCustomerList(array('ua.is_deleted'=>0,'u.is_deleted'=>0,'u.role_id'=>3,'od.vendor_id'=>$this->session->userdata('vendor_data')['id']));
          $countries=getCountryList();
          ?>  

            <div class="col-md-2 col-sm-4 form-group">
            <select class="form-control" id="change_customer">
              <option value="">Select customer</option>
              <?php if(count($customer_list)>0){
                  foreach($customer_list as $customer){
                    ?>
                    <option value="<?php echo $customer['id']?>" <?php if($customer['id']==$customer_id){ echo "Selected";}?>><?php echo $customer['name'];?></option>
                    <?php
                  }
              }
              ?>
 
            </select>
            </div>


            <div class="col-md-2 col-sm-4 form-group">
            <select class="form-control" id="change_country">
              <option value="">Select Country</option>
              <?php if(count($countries)>0){
                  foreach($countries as $country){
                    ?>
                    <option value="<?php echo $country['id']?>"><?php echo $country['name'];?></option>
                    <?php
                  }
              }
              ?>
            </select>
            </div>

            <div class="col-md-2 col-sm-4 form-group">
            <select class="form-control" id="change_state">
              <option value="">Select State</option>
            </select>
            </div>

            <div class="col-md-2 col-sm-4 form-group">
            <select class="form-control" id="change_city">
              <option value="">Select City</option>
            </select>
            </div>
           

            <div class="col-md-2 col-sm-4 form-group">
              <select class="form-control" id="change_status">
              <option value="">Select Status</option>
              <option value="1">Active</option>
              <option value="0">In-active</option>
            </select>
            </div>

            <div class="col-md-2 col-sm-4 form-group">
              <input type="text" class="form-control" id="search" placeholder="Search Name/Email/Phone">
            </div>
            
          </div>
        </form>
      </div>
      <!-- Data Table -->
      <div class="managePrdTable">
        <div class="dataTables_wrapper">
          <table class="table table-bordered table-striped" id="customer_address_list" style="width: 100%;">
            <thead>
            <tr>
               <th>Sr. No.</th>
               <th>Name</th>
               <th>Email</th>
               <th>Phone</th>
               <th>Country</th>
               <th>State</th>
               <th>City</th>
              <th>Status</th>
              <th>Action</th>
             </tr>
            </thead>
            <tbody>
            </tbody>
          </table>
          <input type="hidden" name="customer_id" id="customer_id" value="<?php echo $customer_id;?>">
 
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
      var customer_id=$('#change_customer').val();
      if(customer_id>0){
        $('#add_new').show();
      }
   var customer_address_list_table = $('#customer_address_list').DataTable({
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
      url :"<?php echo base_url('vendor-manage-customer-address-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.customer_id = $('#change_customer').val();
        d.country_id = $('#change_country').val();
        d.state_id = $('#change_state').val();
        d.city_id = $('#change_city').val();
        d.status = $('#change_status').val();
        d.search = $('#search').val();
          
      } 
    } ,
    "columns": [ 
      {data: 'id',"orderable":false},
      {data: 'name'},
      {data: 'email'}, 
      {data: 'phone'}, 
      {data: 'country_name'}, 
      {data: 'state_name'}, 
      {data: 'city_name'}, 
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
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						//html +='<a href="javascript:void(0)" onClick="changeAddressStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='<a href="javascript:void(0)">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 7 
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('vendor-view-customer-address/');?>'+row['id']+'" title="View Address" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';
            return html;
          },
          
           "targets": 8 
          },
        
      ],
      "dom": "<<'dt-toolbar'<'col-xs-12 col-sm-6'><'col-sm-6 col-xs-12'l>>"+
      "t"+"<'dt-toolbar-footer row'<'col-md-5'i><'col-md-7'p>>r","autoWidth" : true,
      "footerCallback": function ( row, data, start, end, display ) {
        //setCheckboxSelected(data);
      }
    });

    $('#change_customer,#change_country,#change_state,#change_city,#change_status').change(function(){
    customer_address_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
      customer_address_list_table.search(this.value).draw();
    });
 

    })
  
</script>
 
