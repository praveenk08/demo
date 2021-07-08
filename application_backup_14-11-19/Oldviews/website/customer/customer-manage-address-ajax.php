<div class="loading text-center" id="srvLoader" style="display:none;"></div>
<?php
if(count($addresses)>0){
   foreach($addresses as $address){
      ?>
   <div class="addressBox">
   <span><?php echo $address['address_type'];?></span>
   <h5><?php echo $address['name']?> <span><?php echo $address['phone'];?></span><span><?php echo $address['email'];?></span></h5>
   <?php $show_address= $address['address'].' '.$address['street'].' '.$address['block'].' '.$address['landmark'].' '.$address['country_name'].' '.$address['state_name'].' '.$address['city_name'].' '.$address['zip'];?>
   <?php if(!empty($show_address)){
    ?>
    <p><?php echo $show_address;?></p>
    <?php
   }?>
   
   <div class="manageAction">
     <a href="javascript:void(0);" ><i class="fas fa-ellipsis-v"></i></a>
     <div class="dropAction">
        <a href="<?php echo base_url('customer-update-address/'.$address['id']);?>" >Edit</a>
        <a  href="javascript:void(0)" onClick="DeleteRecord('<?php echo $address['id'];?>')" >Delete</a>
     </div>
   </div>
   </div>
   <?php
   } 
}else {
?>
 <div class="addressBox"  style="text-align:center;">
 <h5><strong><?php echo $this->config->item('record_not_found_title');?></strong></h5>
 </div>
<?php
}

?>
<div class="msPagination mt-3" id="pagination-section">
<?php 
echo $this->ajax_pagination->create_links(); ?>
</div>