<div class="loading text-center" id="srvLoader" style="display:none;"></div>
<table class="table table-bordered">
   <thead class="text-uppercase">
      <tr>
         <th></th>
         <th>Image</th>
         <th>Service Name</th>
         <th>Service category</th>
         <th>Price</th>
         <th>Status</th>
         <th>Action</th>
      </tr>
   </thead>
   <tbody>
      <?php
      if(count($services)>0){
        $sr=1;
        foreach($services as $service){
        ?>
     <tr>
        <input type="hidden" id="show_hide_status<?php echo $service['id']?>" value="0">	 
        <td>
           <a href="javascript:void(0)" class="show_hide_btn" onclick="showHideData('<?php echo $service['id']?>')" id="show_hide_btn<?php echo $service['id'];?>"><img src="<?php echo base_url('assets/frontend/images/details_open.png')?>">
           </a>
        </td>
        
        <td>
           <?php if(is_file('attachments/services/thumb/'.$service['image'])){
              ?>
           <div class="srvImg">
              <img src="<?php echo base_url('attachments/services/thumb/'.$service['image'])?>">
           </div>
           <?php
              }
              ?>
        </td>
        <td><?php echo $service['name'];?></td>
        <td><?php echo $service['category_name'];?></td>
        <td>$<?php echo $service['price'];?></td>
        <td>
           <?php
              if($service['status']==1){ echo "<span class='btn btn-sm btn-success'>Active</span>"; }else{ echo "<span class='btn btn-sm btn-danger'>In-active</span>";}
              ?>
        </td>
        <td class="text-nowrap">
           <a href="<?php echo base_url('service-provider-update-service/'.$service['id']);?>" class="btn btn-sm editBtn"><i class="fas fa-pencil-alt"></i></a>
           <a href="" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></a>
        </td>
     </tr>
     <tr id="discription<?php echo $service['id'];?>" style="display:none;" class="description">
        <td colspan="7"><strong>Description:</strong>
           <?php echo $service['description'];?>
        </td>
     </tr>
     <?php
        $sr++;
        }
      }else{
?>
<tr>
    <td colspan="7" style="text-align:center;"><strong><?php echo $this->config->item('record_not_found_title');?></strong></td>
</tr>
<?php
      }
         
         ?>
   </tbody>
</table>
<div class="msPagination mt-3" id="pagination-section">
   <?php echo $this->ajax_pagination->create_links(); ?>
</div>