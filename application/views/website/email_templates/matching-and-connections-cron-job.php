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
                                 <td align="center"><a><img src="<?php echo base_url();?>/assets/frontend/images/logo.png" style="max-width:180px"></a></td>
                              </tr>
                           </table>
                           <table border="0" cellpadding="5" cellspacing="0" width="600" style="background:#fff;border:1px solid #ddd">
                              <tr>
                                 <td align="center" style="font-size:24px;font-weight:bold;color:#e8234b;letter-spacing:1px;border-bottom:2px solid #e8234b;padding:10px 15px">Product List</td>
                              </tr>
                              <tr>
                                 <td>
                                    <table border="0" cellpadding="10" cellspacing="0" width="570">
                                       <tr>
                                          <td>
                                             <p style="margin-top:0">Hello, <?php echo $customer_info['customer_name'];?></p>
                                             <p>Message Heading</p>
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
                                                       <th style="border:1px solid #ddd">Price</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                   <?php
                                                      if(count($products)>0){
                                                        $sr=1;
                                                        foreach($products as $product){
                                                     ?>
                                                   <tr>
                                                      <td style="border:1px solid #ddd"><?php echo $sr;?></td>
                                                      <td align="center" style="border:1px solid #ddd"><a href="<?php echo base_url('product-details/'.$product['slug']);?>"><?php if(is_file('./attachments/products/thumb/'.$product['image'])){  ?> <img style="height:50px;width:50px;" src="<?php echo base_url('attachments/products/thumb/'.$product['image'])?>"><?php }else{ ?><img style="height:50px;width:50px;" src="<?php echo base_url('assets/frontend/images/prd1.jpg')?>"><?php }  ?></a></td>
                                                      <td style="border:1px solid #ddd"><a href="<?php echo base_url('product-details/'.$product['slug']);?>"><?php  echo $product['name'];?></a></td>
                                                       <td  align="right" style="border:1px solid #ddd">$<?php echo number_format($product['price'],2);?></td>
                                                    </tr>
                                                   <?php
                                                      $sr++;
                                                      }
                                                      ?>
                                                </tbody>
                                                
                                                <?php
                                                   } 
                                                   ?>
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
               </td>
            </tr>
         </table>
      </div>
   </body>
</html>