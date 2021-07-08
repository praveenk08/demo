<?php
 if($this->session->userdata('language')=='en'){
   $home_label="Home";
   $assigned_orders_label="Dashboard";
   $order_id_label="Order Id";
   $transition_id_label="Transition ID";
   $customer_label="Customer";
   $total_products_label="Total Crops";
   $total_price_label="Total Price";
   $status_label="Status";
   $assign_to_delivery_boy_label="Assign to delivery boy";
   $ready_to_ship_label="Ready to ship";
   $completed_label="Completed";
   $sr_no_label="S.No.";
   $image_label="Image";
   $name_label="Name";
   $vendor_label="Vendor";
   $quantity_label="Quantity";
   $quantity_label="Price";
 }else{
   $home_label="الصفحة الرئيسية";
   $assigned_orders_label="لوحة القيادة";
   $order_id_label="رقم التعريف الخاص بالطلب";
   $transition_id_label="معرف الانتقال";
   $customer_label="زبون";
   $total_products_label="مجموع المحاصيل";
   $total_price_label="السعر الكلي";
   $status_label="الحالة";
   $assign_to_delivery_boy_label="تعيين لصبي التسليم";
   $ready_to_ship_label="على استعداد للسفينة";
   $completed_label="منجز";
   $sr_no_label="S.No.";
   $image_label="صورة";
   $name_label="اسم";
   $vendor_label="بائع";
   $quantity_label="كمية";
   $quantity_label="السعر";
 }
?>
<div class="loading text-center" id="srvLoader" style="display:none;"></div>
                              <table class="table table-bordered">
                              <thead class="text-uppercase">
                                    <tr>
                                       <th></th>
                                       <th><?php echo $order_id_label;?></th>
                                       <th><?php echo $transition_id_label;?></th>
                                       <th><?php echo $customer_label;?></th>
                                       <th><?php echo $total_products_label;?></th>
                                       <th><?php echo $total_price_label;?></th>
                                       <th><?php echo $status_label;?></th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                    <?php
                                       $sr=1;
                                       foreach($orders as $order){
                                       	?>
                                    <tr>
                                       <input type="hidden" id="show_hide_status<?php echo $order['order_id']?>" value="0">	 
                                       <td>
                                          <a href="javascript:void(0)" class="show_hide_btn" onclick="showHideData('<?php echo $order['order_id']?>')" id="show_hide_btn<?php echo $order['order_id'];?>"><img src="<?php echo base_url('assets/frontend/images/details_open.png')?>">
                                          </a>
                                       </td>
                                       <td><?php echo $order['order_id'];?></td>
                                       <td><?php echo $order['transaction_id'];?></td>
                                       <td><?php echo $order['customer_name'];?></td>
                                       <td style="text-align:right;"><?php echo $order['total_product'];?></td>
                                       <td style="text-align:right;">$<?php echo $order['total_amount'];?></td>
                                       <td>
                                       <select id="change_order_status<?php echo $order['order_id'];?>" class="form-control" onClick="changeOrderStatus('<?php echo $order['order_id'];?>')">
                                             <?php
                                                if($order['order_status']==3){
                                                	?>
                                             <option value="3" selected="selected" ><?php echo $assign_to_delivery_boy_label;?></option>
                                             <option value="4"><?php echo $ready_to_ship_label;?></option>
                                             <?php
                                                }else if($order['order_status']==4){
                                                	?>
                                             <option value="4" selected="selected"><?php echo $ready_to_ship_label;?></option>
                                             <option value="5"><?php echo $completed_label;?></option>
                                             <?php
                                                }
                                                ?>
                                          </select>
                                       </td>
                                    </tr>
                                    <tr id="discription<?php echo $order['order_id'];?>" style="display:none;" class="description">
                                       <td colspan="7">
                                          <table class="table table-bordered">
                                          <thead>
                                                <tr>
                                                 <th><?php echo $sr_no_label;?></th>
                                                   <th><?php echo $image_label;?></th>
                                                   <th><?php echo $name_label;?></th>
                                                   <th><?php echo $vendor_label;?></th>
                                                   <th class="center"><?php echo $quantity_label;?></th>
                                                   <th class="center"><?php echo $price_label;?></th>
                                                </tr>
                                             </thead>
                                             <tbody>
                                                <?php
                                                   if(count($order['products'])>0){
                                                       $sr=1;
                                                       $total_price=0;
                                                       $total_quantity=0;
                                                       foreach($order['products'] as $product){
                                                           ?>
                                                <tr>
                                                   <td><?php echo $sr;?></td>
                                                   <td><?php if(is_file('./attachments/products/thumb/'.$product['image'])){  ?>
                                                      <img style="height:50px;width:50px;" src="<?php echo base_url('attachments/products/thumb/'.$product['image']);?>"><?php } ?>
                                                   </td>
                                                   <td><?php  echo $product['name'];?></td>
                                                   <td><?php echo $product['vendor_name'];?></td>
                                                   <td style="text-align:right;"><?php echo $product['quantity'];?></td>
                                                   <td style="text-align:right;">$<?php echo $product['price'];?></td>
                                                </tr>
                                                <?php
                                                   $total_price +=$product['price'];
                                                   $total_quantity +=$product['quantity'];
                                                   $sr++;
                                                   }
                                                   ?>
                                             </tbody>
                                             <tr>
                                                <td><b>Total:</b></td>
                                                <td colspan="3"></td>
                                                <td style="text-align:right;"><?php echo $total_quantity;?></td>
                                                <td style="text-align:right;">$<?php echo number_format($total_price,2);?></td>
                                             </tr>
                                             <?php
                                                }else{
                                                    ?>
                                             <tr>
                                                <td colspan="6">No Record Found</td>
                                             </tr>
                                             <?php
                                                }
                                                ?>
                                          </table>
                                          <table class="table table-bordered">
                                             <tr>
                                                <td><b>Name</b></td>
                                                <td><?php echo $order['address']['name'];?></td>
                                                <td><b>Email</b></td>
                                                <td><?php echo $order['address']['email'];?></td>
                                                <td><b>Phone</b></td>
                                                <td><?php echo $order['address']['phone'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Address Type</b></td>
                                                <td><?php echo $order['address']['address_type'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Country</b></td>
                                                <td><?php echo $order['address']['country_name'];?></td>
                                                <td><b>State</b></td>
                                                <td><?php echo $order['address']['state_name'];?></td>
                                                <td><b>City</b></td>
                                                <td><?php echo $order['address']['city_name'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Address</b></td>
                                                <td><?php echo $order['address']['address'];?></td>
                                                <td><b>Block</b></td>
                                                <td><?php echo $order['address']['block'];?></td>
                                                <td><b>Landmark</b></td>
                                                <td><?php echo $order['address']['landmark'];?></td>
                                             </tr>
                                             <tr>
                                                <td><b>Zip Code</b></td>
                                                <td><?php echo $order['address']['zip'];?></td>
                                             </tr>
                                          </table>
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