 

<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
   <h1>
      View Page
   </h1>
   <ol class="breadcrumb">
      <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
      <li class="active">View Page</li>
   </ol>
</section>
<!-- Main content -->
<section class="content">
   <!-- Small boxes (Stat box) -->
   <div class="row">
      <div class="col-md-12">
         <div class=" box-body boxMain">
            <div class="row">
               <?php
                  $languages=getLanguageList();
                  foreach($languages as $language){
                  ?>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Page Name(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['name'])){echo $names[$language['abbr']]['name'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                  foreach($languages as $language){
                     ?>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Page Title(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['page_title'])){echo $names[$language['abbr']]['page_title'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                 
                  foreach($languages as $language){
                     ?>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Page Keywords(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['banner_title'])){echo $names[$language['abbr']]['banner_title'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                  ?>
               <?php if(is_file('attachments/pages/thumb/'.$page['banner_image'])){ ?>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Banner Images</div>
                     <div class="innerData2"><img src="<?php echo base_url('attachments/pages/thumb/'.$page['banner_image'])?>"  class="img-responsive"></div>
                  </div>
               </div>
               <?php } ?>
               <?php if(is_file('attachments/pages/thumb/'.$page['image'])){ ?>
               <div class="col-md-6">
                  <div class="outerData">
                     <div class="innerData1">Images</div>
                     <div class="innerData2"><img src="<?php echo base_url('attachments/pages/thumb/'.$page['image'])?>"  class="img-responsive"></div>
                  </div>
               </div>
               <?php } ?>
               <?php
                  foreach($languages as $language){
                  ?>
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Meta Description(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['meta_description'])){echo $names[$language['abbr']]['meta_description'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                  
                  foreach($languages as $language){
                     ?>
               <div class="col-md-12">
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
                     <div class="innerData2"><?php echo $page['status'] ? "Active" : "In-active";?></div>
                  </div>
               </div>
            </div>
            <div class="box-footer">
               <a href="<?php echo base_url('admin-manage-pages')?>" class="btn btn-primary">Back</a>
            </div>
         </div>
      </div>
   </div>
</section>
</div>
</section>
<!-- /.content -->
<?php  $this->load->view('admin/includes/footer');?>
