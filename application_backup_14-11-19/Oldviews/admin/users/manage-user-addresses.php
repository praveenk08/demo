
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
   <h1>
      Manage User Addresses
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">Manage User Addresses</li>
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
            <form>
               <div class="form-group text-right">
                  <a href="<?php echo base_url('admin-manage-users');?>" class="btn btn-primary" style="margin-top: 1px;margin-left: -592%;" id="checkbox_action">Back</a>
                  <a href="<?php echo base_url('admin-add-user-address/'.$user_id);?>" class="btn btn-primary"  id="add_new" style="display:none;">Add New Address</a>
               </div>
               
               <div class="row">
                  <div class="col-md-3 col-sm-6 form-group">
                     <?php
                        $user_list=getUserList();
                        ?>
                     <select class="form-control" id="change_user">
                        <option value="">Select User</option>
                        <?php if(count($user_list)>0){
                           foreach($user_list as $user){
                             ?>
                        <option value="<?php echo $user['id']?>" <?php if($user['id']==$user_id){ echo "Selected";}?>><?php echo $user['name'];?>   (<?php echo $user['role_name'];?>)</option>
                        <?php
                           }
                           }
                           ?>
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-6 form-group">
                     <?php
                        $countries=getCountryList();
                        ?>
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
                  <div class="col-md-3 col-sm-6 form-group">
                     <select class="form-control" id="change_state">
                        <option value="">Select State</option>
                     </select>
                  </div>
                  <div class="col-md-3 col-sm-6 form-group">
                     <select class="form-control" id="change_city">
                        <option value="">Select City</option>
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
                     <input type="text" class="form-control" id="search" placeholder="Search Name/Email/Phone">
                  </div>
               </div>
            </form>
            <div class="managePrdTable">
               <div class="dataTables_wrapper">
                  <table class="table table-bordered table-striped" id="user_address_list" style="width: 100%;">
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
 var user_address_list_table='';
    $(function () {
      var user_id=$('#change_user').val();
      if(user_id>0){
        $('#add_new').show();
      }
   user_address_list_table = $('#user_address_list').DataTable({
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
      url :"<?php echo base_url('admin-manage-user-address-ajax')?>", 
      type: "post", 
      data: function (d) {      
        d.user_id = $('#change_user').val();
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
            return data;
          },
          
           "targets": 6 
          },
          
          {
            "render": function ( data, type, row ) {
            var html ='<span id="loader'+row['id']+'"></span><span id="status'+row['id']+'">';
						html +='<a href="javascript:void(0)" onClick="changeAddressStatus('+row['id']+','+row['status']+')">'+getStatus(data)+'</a>';
						html +='</span>';
 						return html;
          },
          
           "targets": 7 
          },
          {
            "render": function ( data, type, row ) {
            var html=' <a href="<?php echo base_url('admin-view-user-address/');?>'+row['id']+'" title="View Data" class="btn btn-primary btn-sm">';
            html +='<i class="fa fa-eye"></i></a> ';

            html += '<a href="<?php echo base_url('admin-update-user-address/')?>'+row['id']+'" class="btn btn-success btn-sm">';
            html +='<span class="glyphicon glyphicon-edit"></span></a> ';

            html +='<a href="javascript:void(0);" onClick="deleteRecord('+data+');" class="btn btn-danger btn-sm">';
            html +='<span class="glyphicon glyphicon-trash"></span></a> ';
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

    $('#change_user,#change_country,#change_state,#change_city,#change_status').change(function(){
      user_address_list_table.ajax.reload();
    });

    $('#search').on('keyup', function() {
      user_address_list_table.search(this.value).draw();
    });
    $('#delete_record').click(function(){
			actionPerform('<?php echo base_url('admin-delete-user-address')?>',user_address_list_table);
    });
    $('#change_user').change(function(){
      var CURRENTURL= window.location.href; 
      var new_url='<?php echo base_url('admin-manage-user-addresses')?>';
      if(this.value>0){
        new_url +='/'+this.value;
        //add_new
        $('#add_new').attr("href","<?php echo base_url('admin-add-user-address')?>/"+this.value);
        $('#add_new').show();
      }else{
        $('#add_new').hide();
      }
      ChangeUrl(CURRENTURL,new_url);

    })

    })

    function changeAddressStatus(id,status){
	    if(id>0){
        changeDataStatus('changeAddressStatus',id,status,'<?php echo base_url('admin-change-user-address-status')?>',user_address_list_table);
    }
  } 
</script>