<?php
if($this->session->userdata('language')=='en'){
   $select_category_place="Select category";
   $add_service_place="Add Service Item";
   $select_service_status_place="Select Status";
   $select_list_place="Service Item List";
   $select_name_place="Search name";
   $active_place="Active";
   $in_active_place="In-active";
   $description_place="Description";
   
}else{
   $select_category_place="اختر الفئة";
   $add_service_place="إضافة عنصر الخدمة";
   $select_service_status_place="اختر الحالة";
   $select_list_place="قائمة عنصر الخدمة";
   $select_name_place="اسم البحث";
   $active_place="نشيط";
   $in_active_place="غير نشط";
   $description_place="وصف";

}
?>

<div class="loading text-center" id="srvLoader" style="display:none;"></div>
<table class="table table-bordered">
													<?php
													if($this->session->userdata('language')=='en'){
														?>
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
														<?php
													}else{
														?>
														<thead class="text-uppercase">
														<tr>
														<th></th>
														<th>صورة</th>
														<th>اسم الخدمة</th>
														<th>فئة الخدمة</th>
														<th>السعر</th>
														<th>الحالة</th>
														<th>عمل</th>
														</tr>
													</thead>
														<?php
													}
													?>
													
												 
													<tbody>
													<?php
													$sr=1;
													foreach($services as $service){
														?>
														<tr>
														<input type="hidden" id="show_hide_status<?php echo $service['id']?>" value="0">	 
														<td style="width:40px;">
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
															if($service['status']==1){ echo "<span class='btn btn-sm btn-success'>".$active_place."</span>"; }else{ echo "<span class='btn btn-sm btn-danger'>".$in_active_place."</span>";}
															?>
 															</td>
 															<td class="text-nowrap">
																<a href="<?php echo base_url('service-provider-update-service/'.$service['id']);?>" class="btn btn-sm editBtn"><i class="fas fa-pencil-alt"></i></a>
																<a href="javascript:void(0)" onClick="DeleteRecord('<?php echo $service['id'];?>')" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></a>
															</td>
														</tr>
														<tr id="discription<?php echo $service['id'];?>" style="display:none;" class="description">
														<td colspan="7"><strong><?php echo $description_place;?>:</strong>
														<?php echo $service['description'];?>
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