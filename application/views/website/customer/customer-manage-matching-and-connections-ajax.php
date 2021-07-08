<?php
if($this->session->userdata('language')=='en'){
   $image_label="Image";
    $category_name_label="Category Name";
    $status_label="Status";
   $active_label="Active";
   $inactive_label="In-active";
   $main_category_name_label="Main Category Name";
   $action_label="Action";

 }else{
   $image_label="صورة";
    $category_name_label="اسم التصنيف";
    $status_label="الحالة";
   $active_label="نشيط";
   $inactive_label="غير نشط";
   $main_category_name_label="اسم الفئة الرئيسية";
   $action_label="عمل";
 }
?>
<div class="loading text-center" id="srvLoader" style="display:none;"></div>
<table class="table table-bordered">
   <thead class="text-uppercase">
      <tr>
      <th><?php echo $image_label;?></th>
      <th><?php echo $category_name_label;?></th>
      <th><?php echo $main_category_name_label;?></th>
      <th><?php echo $status_label;?></th>
      <th><?php echo $action_label;?></th>
      </tr>
   </thead>
   <tbody>
      <?php
         $sr=1;
         foreach($products as $product){
            ?>
      <tr>
         <td>
         <div class="srvImg">
             <?php if(is_file('attachments/products/thumb/'.$product['image'])){
               ?>
            
               <img src="<?php echo base_url('attachments/products/thumb/'.$product['image'])?>">
            
            <?php
               }else{
                  ?>
            <img src="<?php echo base_url();?>/assets/frontend/images/prd1.jpg" style="height:80px;width:80px;">
            <?php
               }
               ?>
               </div>
         </td>
 <td><?php echo $product['category_name'];?></td>
<td><?php echo $product['parent_category_name'];?></td>
<td>
<span id="status<?php echo $product['id'];?>">
<a href="javascript:void(0)" onClick="addUpdateStatus('<?php echo $product['id'];?>','<?php echo $product['status'];?>')"><?php
if($product['status']==1){ ?><span class='btn btn-sm btn-success'><?php echo $active_label;?></span>	
<?php
}else{ ?> <span class='btn btn-sm btn-danger'><?php echo $inactive_label;?></span><?php	} ?></a></span>
 </td>
 <td class="prAction" data-title="Remove"  style="text-align:center">
	 <a href="javascript:void(0)"  onClick="DeleteRecord('<?php echo $product['id'];?>')"><i class="fas fa-trash"></i></a>
</td>
      </tr>
      <?php
         $sr++;
        }
         ?>
   </tbody>
</table>
<div class="msPagination mt-3" id="pagination-section">
   <?php echo $this->ajax_pagination->create_links(); ?>
</div>