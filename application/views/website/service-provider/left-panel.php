<?php
if($this->session->userdata('language')=='en'){
	$home_label="Home";
	$dashboard_label="Dashboard";
	$profile_label="Profile";
	$edit_profile_label="Edit Profile";
	$services_label="Services";
	$logout_label="Logout";	
}else{
	$home_label="الصفحة الرئيسية";
	$dashboard_label="لوحة القيادة";
	$profile_label="الملف الشخصي";
	$edit_profile_label="تعديل الملف الشخصي";
	$services_label="خدمات";
	$logout_label="الخروج";	
}
?>

	<div class="profileLt">
	<div class="profileNav">
	<a href="" class="profileNavToggle">ProfileMenu</a>
	<ul class="nav nav-tabs flex-column">
	<li class="nav-item"><a href="<?php echo base_url('service-provider-dashboard');?>" class="nav-link active"><?php echo $profile_label;?></a></li>
	<li class="nav-item"><a  href="<?php echo base_url('service-provider-update-profile');?>" class="nav-link"><?php echo $edit_profile_label;?></a></li>
	<li class="nav-item"><a href="<?php echo base_url('service-provider-services');?>" class="nav-link"><?php echo $services_label;?></a></li>
	<li class="nav-item"><a href="<?php echo base_url('logout');?>" class="nav-link"><?php echo $logout_label;?></a></li>
	</ul>
	</div>
	</div>