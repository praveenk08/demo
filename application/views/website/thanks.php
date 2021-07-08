<?php
$this->load->view('website/includes/header');
?>
<div class="thankyou">
  <div class="thankyou-body">
    
    
	<?php  if($order_status==0) { ?>
	<div class="thankyou_message">Thank you for your purchase on Mahaseel</div>
    <div class="tranref">Your Transaction done successfully</div>
	<?php } else { ?>
	<div class="thankyou_message">Sorry</div>
	<div class="tranref">Your Transaction Failed !!! </div>
	<?php } ?>
    <div class="thankyouBtn">
      <a class="postBtn" href="<?=base_url();?>">Go Back Home</a>
    </div>
  </div>
  </div>
  
<?php
$this->load->view('website/includes/footer');
?>  