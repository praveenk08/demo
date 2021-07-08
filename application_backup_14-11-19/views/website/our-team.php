			<?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Top Banner scetion -->
			<?php
			if(is_file('attachments/pages/main/'.$page['banner_image'])){
				$image=base_url('attachments/pages/main/'.$page['banner_image']);
			}else{
				$image=base_url('assets/frontend/images/hsbanner.jpg');
			}
			
			?>
				<!-- Top Banner scetion -->
				<div class="topBanner" style="background-image: url('<?php echo $image;?>');">
					<div class="container-fluid">
						<div class="topBContent">
							<h1><?php echo $page['name'];?></h1>
							<p><?php echo $page['banner_title'];?></p>
						</div>
					</div>
				</div>

			<!-- Main body wrapper -->
			<div class="mainBody">
			
			<?php
				if(count($teams)){
				?>
				<div class="teamWrapper">
					<div class="container-fluid">
						<div class="teamContainer">
							<h4 class="mb-4 text-center"><strong>Our Creative Team</strong></h4>
							<div class="row">
							<?php
							foreach($teams as $team){
								?>
								<div class="col-md-4 col-sm-6">
									<div class="teamItem">
										<div class="teamImg" style="background-image:url(<?php echo base_url('attachments/teams/main/'.$team['image'])?>)">
										<?php if(is_file('attachments/teams/main/'.$team['image'])){ ?>
											<img src="<?php echo base_url('attachments/teams/main/'.$team['image'])?>">
  										<?php } ?>
										</div>
										<div class="teamContent">
											<div class="teamInfo">
												<?php echo $team['name'];?><br/>
												<span><?php echo $team['designation'];?></span></div>
												<div class="d-flex flex-wrap align-items-center">
													<a href="javascript:void(0)" class="btn bioBtn"onClick="showDetail('<?php echo $team['id'];?>')">View Bio</a>
													<div class="teamSocial d-flex">
														<div class="d-flex scSocial sharethis-inline-share-buttons"></div>
													</div>
												</div>
											</div>
									</div>

<!-- Modal -->
<div id="bioModal<?php echo $team['id']?>" class="modal fade bioModal" role="dialog">
   <div class="modal-dialog modal-lg">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-body">
					 <div class="teamSocial d-flex">
											<div class="d-flex scSocial sharethis-inline-share-buttons"></div>
										</div>
            <div class="bioModalBody">
               <button type="button" class="close" data-dismiss="modal">&times;</button>
               <div class="teamImg" id="profile_image">
								 <?php if(is_file('attachments/teams/main/'.$team['image'])){ ?>
										<img src="<?php echo base_url('attachments/teams/main/'.$team['image'])?>">
										<?php } ?>
                </div>
               <div class="teamContent">
                  <div class="teamInfo">
							<span><?php echo $team['name'];?></span>
							<br/>
							<span><?php echo $team['designation'];?></span>
				  		</div>
									<p><?php echo $team['description'];?></p>
									
               </div>
            </div>
         </div>
      </div>
   </div>
</div>

								</div>
								<?php
							}

							?>
							 	 
							</div>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				
			</div>




<?php
$this->load->view('website/includes/footer');
?>

<script>
function showDetail(id){

	$('#bioModal'+id).modal('show');
	return false;
	
}


</script>