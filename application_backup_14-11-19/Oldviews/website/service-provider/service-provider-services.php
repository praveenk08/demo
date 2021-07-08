
			 <?php
			 $this->load->view('website/includes/header');
			 ?>
			<!-- Main body wrapper -->
			<div class="mainBody">
				<div class="msBreadcrumb">
					<div class="container-fluid">
						<ol class="breadcrumb">
							<li class="breadcrumb-item"><a href="#">Home</a></li>
							<li class="breadcrumb-item active">Services</li>
						</ol>
					</div>
				</div>
				<div class="userWrapper">
					<div class="container-fluid">
						<div class="cwContainer">
							<div class="uwBox d-flex flex-wrap">
								<?php $this->load->view('website/service-provider/left-panel');?>
								<div class="profileRt">
									<div class="tab-content">

										<div class="tab-pane active" id="myProfile">
                                        <div   id="serviceList">
											<div class="srvHead d-flex flex-wrap align-items-center">
												<h5>Service Item List</h5>
												<a href="<?php echo base_url('service-provider-add-service')?>" class="btn addBtn">Add Service Item</a>
											</div>
											<div id="success_message" >
                                       <?php if($this->session->flashdata('success_message')){ ?> 
                                       <div class="alert alert-success"><?php echo $this->session->flashdata('success_message');?>
                                          <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span></button>
                                       </div>
                                       <?php } ?>
									</div>
									<div class="row form-group">
													<div class="col-sm-4">
													 <select id="change_service_category" class="form-control change">
														 <option value="">Select category</option>
															<?php
															foreach($service_category as $serv){
															?>
															<option value="<?php echo $serv['id']?>"><?php echo $serv['name'];?></option>
															<?php
															}
															?>
													 </select>
														</div>
														<div class="col-sm-4">
													 <select id="change_status" class="form-control change">
													 <option value="">Select Status</option>
													 <option value="1">Active</option>
													 <option value="0">In-active</option>
													 </select>
														</div>
														<div class="col-sm-4">
															<input type="text" name="change_search" id="change_search" class="form-control change" placeholder="Search name">

														</div>
														</div>
												<div class="srvListTable table-responsive" id="service_list_section">
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
																<a href="javascript:void(0)" onClick="DeleteRecord('<?php echo $service['id'];?>')" class="btn btn-sm removeBtn"><i class="fas fa-trash"></i></a>
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
													?>
													
													</tbody>
													
												</table>
												<div class="msPagination mt-3" id="pagination-section">
														<?php echo $this->ajax_pagination->create_links(); ?>
													</div>
											</div>
										</div>
											 
										</div>

									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		
			<?php
			 $this->load->view('website/includes/footer');
			 ?>
<script>
	$('#deleteRecord').click(function(){
		deleteActionPerform('<?php echo base_url('service-provider-delete-service')?>');
 	})
	$('.change').change(function(){
		searchFilter(0);
	})
	$('#change_search').keyup(function(){
		searchFilter(0);
	})
		function searchFilter(page_num) {
			page_num = page_num?page_num:0;
			$.ajax({
				type: 'POST',
				url: '<?php echo base_url(); ?>Serviceprovider/serviceListAjax/'+page_num,
				data:{
					'page':page_num,
					'change_category':$('#change_service_category').val(),
					'change_status':$('#change_status').val(),
					'change_search':$('#change_search').val(),
				},
				beforeSend: function () {
					$('#srvLoader').html(loader);
					$('#srvLoader').show();
				},
				success: function (html) {
					  $('#service_list_section').html(html);
					  $('#srvLoader').hide();
				}
			});
		}
	</script>