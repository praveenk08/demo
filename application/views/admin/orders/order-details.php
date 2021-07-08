
    <thead>
        <tr>
            <th>S.No.</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Sub Category</th>
             <th>Vendor</th>
            <th class="center">Quantity</th>
            <th class="center">Item Price</th>
            <th class="center">Quantity Price</th>
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
                    <td><?php echo $sr;?></td> 
                    <td><?php if(is_file('./attachments/products/thumb/'.$product['image'])){  ?>
                    <img style="height:50px;width:50px;" src="<?php echo base_url('attachments/products/thumb/'.$product['image']);?>"><?php } ?>
                    </td> 
                     <td><?php  echo $product['name'];?></td> 
                    <td><?php  echo $product['parent_category_name'];?></td> 
                     <td><?php  echo $product['category_name'];?></td> 
                      <td><?php echo $product['vendor_name'];?></td> 
                    <td  class="center"><?php echo $product['quantity'];?></td> 
                    <td  class="center">$<?php echo $product['price'];?></td> 
                    <td  class="center">$<?php echo number_format($product['price']*$product['quantity'],2);?></td> 
                 </tr>
            <?php
                $total_price +=$product['quantity']*$product['price'];
                $total_quantity +=$product['quantity'];
                $sr++;
            }
            ?>
            </tbody>
            <tr>
            <td><b>Total:</b></td>
            <td colspan="5"></td>
            <td class="center"><?php echo $total_quantity;?></td>
            <td class="center"></td>
            <td class="center">$<?php echo number_format($total_price,2);?></td>

            </tr>
            <?php

        }else{
            ?>
        <tr><td colspan="9">No Record Found</td></tr>
            <?php
        }
        ?>
    
 