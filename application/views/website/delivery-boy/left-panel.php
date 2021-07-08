<?php
if($this->session->userdata('language')=='en'){
	$profile_label="Profile";
	$edit_profile_label="Edit Profile";
	$assigned_order_label="Assigned Orders";
	$logout_label="Logout";	
}else{
	$profile_label="الملف الشخصي";
	$edit_profile_label="تعديل الملف الشخصي";
	$assigned_order_label="أوامر المعينة";
	$logout_label="الخروج";	
}
?>
<div class="profileLt">
<div class="profileNav">
<a href="" class="profileNavToggle">ProfileMenu</a>
<ul class="nav nav-tabs flex-column">
<li class="nav-item"><a href="<?php echo base_url('delivery-boy-dashboard');?>" class="nav-link active"><?php echo $profile_label;?></a></li>
<li class="nav-item"><a  href="<?php echo base_url('delivery-boy-update-profile');?>" class="nav-link"><?php echo $edit_profile_label;?></a></li>
<li class="nav-item"><a  href="<?php echo base_url('delivery-boy-assigned-orders');?>" class="nav-link"><?php echo $assigned_order_label;?></a></li>
<li class="nav-item"><a href="<?php echo base_url('logout');?>" class="nav-link"><?php echo $logout_label;?></a></li>
</ul>
</div>
</div>