
<?php
 $this->load->view('admin/includes/header');?>

    <!-- Content Header (Page header) -->
    <section class="content-header">
    <h1>
   View Faq
</h1>
<ol class="breadcrumb">
   <li><a href="<?php echo base_url('admin-dashboard');?>"><i class="fa fa-dashboard"></i> Home</a></li>
   <li class="active">View Faq</li>
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
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Question(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['question'])){echo $names[$language['abbr']]['question'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                  
                  foreach($languages as $language){
                  ?>
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Answer(<?php echo ucfirst($language['name']);?>)</div>
                     <div class="innerData2"><?php if(isset($names[$language['abbr']]['answer'])){echo $names[$language['abbr']]['answer'];} ?></div>
                  </div>
               </div>
               <?php
                  }
                  
                  ?>
               <div class="col-md-12">
                  <div class="outerData">
                     <div class="innerData1">Status</div>
                     <div class="innerData2"><?php echo $faq['status'] ? "Active" : "In-active";?></div>
                  </div>
               </div>
            </div>
            <div class="box-footer">
               <a href="<?php echo base_url('admin-manage-faqs')?>" class="btn btn-primary">Back</a>
            </div>
         </div>
      </div>
   </div>
</section>
</div>
    

    </section>
    <!-- /.content -->
  <?php  $this->load->view('admin/includes/footer');?>
   
 
