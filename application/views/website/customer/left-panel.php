<?php
if($this->session->userdata('language')=='en'){
	$home_label="Home";
	$dashboard_label="Dashboard";
	$profile_label="Profile";
	$edit_profile_label="Edit Profile";
	$matching_and_connection_label="Matching and connection";
	$new_product_request_label="New Crop Request";
	$matching_and_connection_Products_label="Matching and connection Crops";
	$manage_address_label="Manage Address";
	$order_history_label="Order History";
	$wishlist_label="Wishlist";
	$logout_label="Logout";	
}else{
	$home_label="الصفحة الرئيسية";
	$dashboard_label="لوحة القيادة";
	$profile_label="الملف الشخصي";
	$edit_profile_label="تعديل الملف الشخصي";
	$matching_and_connection_label="مطابقة والاتصال";
	$new_product_request_label="طلب محصول جديد";
	$matching_and_connection_Products_label="مطابقة المنتجات والاتصال";
	$manage_address_label="إدارة العنوان";
	$order_history_label="تاريخ الطلب";
	$wishlist_label="الأماني";
	$logout_label="الخروج";	
}
?>

<div class="profileLt">
<div class="profileNav">
	<a href="" class="profileNavToggle">ProfileMenu</a>
	<ul class="nav nav-tabs flex-column">
		<li class="nav-item"><a href="<?php echo base_url('customer-dashboard');?>" class="nav-link active"><?php echo $profile_label;?></a></li>
		<li class="nav-item"><a  href="<?php echo base_url('customer-update-profile');?>" class="nav-link"><?php echo $edit_profile_label;?></a></li>
		<li class="nav-item"><a  href="<?php echo base_url('customer-matching-and-connections');?>" class="nav-link"><?php echo $matching_and_connection_label;?></a></li>
		<li class="nav-item"><a  href="<?php echo base_url('customer-new-product-request');?>" class="nav-link"><?php echo $new_product_request_label;?></a></li>
		<li class="nav-item"><a  href="<?php echo base_url('matching-and-connections');?>" class="nav-link"><?php echo $matching_and_connection_Products_label;?></a></li>
		<li class="nav-item"><a  href="<?php echo base_url('customer-manage-addresses');?>" class="nav-link"><?php echo $manage_address_label;?></a></li>
		<li class="nav-item"><a href="<?php echo base_url('customer-orders');?>" class="nav-link"><?php echo $order_history_label;?></a></li> 
		<li class="nav-item"><a  href="<?php echo base_url('customer-wishlist');?>" class="nav-link"><?php echo $wishlist_label;?></a></li>
		<li class="nav-item"><a href="<?php echo base_url('logout');?>" class="nav-link"><?php echo $logout_label;?></a></li>
	</ul>
</div>
</div>