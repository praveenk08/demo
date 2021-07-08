 
<?php
 $this->load->view('admin/includes/header');?>
	<!-- Content Header (Page header) -->
	<section class="content-header">
   <h1>
      View Team
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Team</li>
   </ol>
</section>
<!-- Main content -->
<section class="content ViewProduct">
   <!-- Small boxes (Stat box) -->
   <div class="box box-primary">
       <div class="box-body">
         <div class="row">

         <?php
					$languages=getLanguageList();
					foreach($languages as $language){
			?>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Service Name(<?php echo ucfirst($language['name']);?>)</div>
                  <div class="innerData2"><?php if(isset($names[$language['abbr']]['name'])){echo $names[$language['abbr']]['name'];} ?></div>
               </div>
            </div>
            <?php
						}
					 

            foreach($languages as $language){
			?>
            <div class="col-md-6">
               <div class="outerData">
                  <div class="innerData1">Description(<?php echo ucfirst($language['name']);?>)</div>
                  <div class="innerData2"><?php if(isset($names[$language['abbr']]['description'])){echo $names[$language['abbr']]['description'];} ?></div>
               </div>
            </div>
            <?php
						}
					?>

            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Status</div>
                  <div class="innerData2"><?php echo $service['status'] ? "Active" : "In-active";?></div>
               </div>
            </div>
            <div class="col-md-12">
               <div class="outerData">
                  <div class="innerData1">Image</div>
                  <div class="innerData2">
                     <div class="prdImg">
                        <?php if(is_file('attachments/our-services/thumb/'.$service['image'])){ ?><img src="<?php echo base_url('attachments/our-services/thumb/'.$service['image'])?>"  class="img-responsive"><?php } ?>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="box-footer">
         <a href="<?php echo base_url('admin-manage-our-services')?>" class="btn btn-primary">Back</a>
      </div>
   </div>
</section>

	<!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 

   
 
