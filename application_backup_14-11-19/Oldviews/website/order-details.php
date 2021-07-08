<html>
   <head>
      <META http-equiv="Content-Type" content="text/html; charset=utf-8">
   </head>
   <body>
      <div style="background-color:#f1f1f1;font-family:roboto,sans-serif;font-size:15px;margin:0;padding:0">
         <table border="0" cellpadding="0" cellspacing="0" width="100%" align="center" style="background:#f1f1f1;font-family:&#39;roboto&#39;,sans-serif;font-size:14px">
            <tr>
               <td align="center">
                  <table border="0" cellpadding="0" cellspacing="0" width="600" align="center">
                     <tr>
                        <td align="center">
                           <table border="0" cellpadding="15" cellspacing="0" width="600">
                              <tr>
                                 <td align="center"><a><img src="http://mahaseel.us.tempcloudsite.com/assets/frontend/images/logo.png" style="max-width:180px"></a></td>
                              </tr>
                           </table>
                           <table border="0" cellpadding="5" cellspacing="0" width="600" style="background:#fff;border:1px solid #ddd">
                              <tr>
                                 <td align="center" style="font-size:24px;font-weight:bold;color:#e8234b;letter-spacing:1px;border-bottom:2px solid #e8234b;padding:10px 15px">Order Detail</td>
                              </tr>
                              <tr>
                                 <td>
                                    <table border="0" cellpadding="10" cellspacing="0" width="570">
                                       <tr>
                                          <td>
                                             <p style="margin-top:0">Hello, <?php echo $this->session->userdata('customer_data')['first_name'].' '.$this->session->userdata('customer_data')['last_name'];?>,</p>
                                             <p>Your Order has been has been generated.</p>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <table border="0" cellpadding="0" cellspacing="0" width="570">
                                                <tr>
                                                   <td align="left" style="font-size:18px;color:#e8234b"><strong>Booking Detail</strong></td>
                                                   <td align="right">Order No: <strong style="text-transform:uppercase"><?php echo $order_no; ?></strong></td>
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <table width="570" cellpadding="10" cellspacing="0" style="border:1px solid #ddd">
                                                <thead style="background-color:#f2f2f2">
                                                   <tr>
                                                      <th style="border:1px solid #ddd">S.No.</th>
                                                      <th style="border:1px solid #ddd">Image</th>
                                                      <th style="border:1px solid #ddd">Name</th>
                                                      <th style="border:1px solid #ddd">Vendor</th>
                                                      <th style="border:1px solid #ddd">Quantity</th>
                                                      <th style="border:1px solid #ddd">Price</th>
                                                      <th style="border:1px solid #ddd">Total Price</th>
                                                   </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      if(count($products)>0){
                                                          $sr=1;
                                                          $total_price=0;
                                                          $total_quantity=0;
                                                          foreach($products as $product){
                                                              ?>
                                                   <tr>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $sr;?></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php if(is_file('./attachments/products/thumb/'.$product['image'])){  ?> <img style="height:50px;width:50px;" src="http://mahaseel.us.tempcloudsite.com/attachments/products/thumb/<?php echo $product['image'];?>"><?php } ?></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php  echo $product['name'];?></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $product['vendor_name'];?></td>
                                                      <td  align="center" style="border:1px solid #ddd"><?php echo $product['quantity'];?></td>
                                                      <td  align="center" style="border:1px solid #ddd">$<?php echo number_format($product['price'],2);?></td>
                                                      <td  align="center" style="border:1px solid #ddd">$<?php echo number_format(($product['price']*$product['quantity']),2);?></td>
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
                                                   <td colspan="4"></td>
                                                   <td class="right"><?php echo $total_quantity;?></td>
                                                   <td class="right">$<?php echo number_format($total_price,2);?></td>
                                                </tr>
                                                <?php
                                                   } 
                                                   ?>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td align="left" style="font-size:18px;color:#e8234b"><strong>Order Address</strong></td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <table width="570" cellpadding="10" cellspacing="0" style="border:1px solid #ddd">
                                                <tbody>
                                                   <tr>
                                                      <td align="center" style="border:1px solid #ddd"><b>Name</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['name'];?></td>
                                                      <td align="center" style="border:1px solid #ddd"><b>Email</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['email'];?></td>
                                                      
                                                   </tr>
                                                   <tr>
                                                   <td align="center" style="border:1px solid #ddd"><b>Phone</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['phone'];?></td>
                                                      <td  align="center" style="border:1px solid #ddd"><b>Address Type</b></td>
                                                      <td  align="center" style="border:1px solid #ddd"><?php echo $address['address_type'];?></td>
                                                   </tr>
                                                   <tr>
                                                      <td  align="center" style="border:1px solid #ddd"><b>Country</b></td>
                                                      <td  align="center" style="border:1px solid #ddd"><?php echo $address['country_name'];?></td>
                                                      <td  align="center" style="border:1px solid #ddd"><b>State</b></td>
                                                      <td  align="center" style="border:1px solid #ddd"><?php echo $address['state_name'];?></td>
                                                      
                                                   </tr>
                                                   <tr>
                                                   <td  align="center" style="border:1px solid #ddd"><b>City</b></td>
                                                      <td  align="center" style="border:1px solid #ddd"><?php echo $address['city_name'];?></td>
                                                      <td align="center" style="border:1px solid #ddd"><b>Address</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['address'];?></td>
                                                      
                                                   </tr>
                                                   <tr>
                                                   <td align="center" style="border:1px solid #ddd"><b>Block</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['block'];?></td>
                                                      <td align="center" style="border:1px solid #ddd"><b>Landmark</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['landmark'];?></td>
                                                       
                                                   </tr>
                                                   <tr>
                                                      <td align="center" style="border:1px solid #ddd"><b>Zip Code</b></td>
                                                      <td align="center" style="border:1px solid #ddd"><?php echo $address['zip'];?></td>
                                                   </tr>
                                                </tbody>
                                             </table>
                                          </td>
                                       </tr>
                                       <tr>
                                          <td>
                                             <table border="0" cellpadding="0" cellspacing="0" width="570">
                                                <tr>
                                                   <td align="right" valign="top">
                                                      <p style="margin-top:0;margin-bottom:0">Team, Mahaseel</p>
                                                     <!--  <p style="margin-top:5px;margin-bottom:0"><a><img src="http://appstore-logo.png" style="width:100px"></a> <a><img src="http://playstore-logo.png" style="width:100px"></a></p>-->
                                                   </td>
                                                   <!--<td align="right" valign="top">
                                                      <p style="margin-top:0;margin-bottom:5px"><a style="margin-right:7px"><i></i></a><a><i></i></a></p>
                                                      <p style="margin-top:0;margin-bottom:5px">+973 66660334</p>
                                                      <p style="margin-top:0;margin-bottom:0"><a href="mailto:info@activeacademy.net" target="_blank">info@activeacademy.net</a></p>
                                                      </td>-->
                                                </tr>
                                             </table>
                                          </td>
                                       </tr>
                                    </table>
                                 </td>
                              </tr>
                           </table>
                        </td>
                     </tr>
                  </table>
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>