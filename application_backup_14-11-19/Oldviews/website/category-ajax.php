<ul class="dropdown-menu">
   <?php
      foreach($category as $cat){
      ?>
   <?php
      if(count($cat['sub_category'])){
      ?>
   <li class="nav-item dropdown">
      <a href="#" class="nav-link"><?php echo $cat['name'];?></a>
      <span class="dropIcon"><i class="fa fa-angle-right"></i></span>
      <ul class="dropdown-menu">
         <?php
            foreach($cat['sub_category'] as $sub_category){
            ?>
         <li class="nav-item"><a href="#" class="nav-link"><?php echo $sub_category['name'];?></a></li>
         <?php
            }
            ?>
      </ul>
   </li>
   <?php
      }else{
      ?>
   <li class="nav-item"><a href="#" class="nav-link"><?php echo $cat['name'];?></a></li>
   <?php
      }
      
      }
      ?>
</ul>