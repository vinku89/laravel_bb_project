<div class="navbar navbar-expand-sm bsnav bestbox-nav bsnav-sticky bsnav-scrollspy">
    <div class="container bb_width">
        <a class="navbar-brand" href="<?php echo url('/');?>"></a>
        <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-sm-end">
            <ul class="navbar-nav navbar-mobile mr-0">
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="content-packages">Content Packages</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="tvbox">TV Box</a></li>
                <!-- <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="freetrial">Free Trial</a></li> -->
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="subscribe-now">Subcribe Now</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="refer">Refer your friend</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="<?php echo url('/login');?>"><span class="mr-2"><img src="<?php echo url('/');?>/public/website/assets/images/reseller.png" class="img-fluid" /></span>Reseller/Agent</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="<?php echo url('/customerLogin');?>"><span class="mr-2"><img src="<?php echo url('/');?>/public/website/assets/images/my_acc.png" class="img-fluid" /></span>Customer</a></li>
                <li class="nav-item nav-item-fill mt-2 f12 color-white" >
                    <?php //echo $lang;?>
                  <select class="custom-select select_lang">
                     <option value="english" <?php if($lang=='english'){ echo "selected";} ?>>English</option>
                     <option value="danish" <?php if($lang=='danish'){ echo "selected";} ?>>Danish</option>
                     <option value="french" <?php if($lang=='french'){ echo "selected";} ?>>French</option>
                     <option value="arabic" <?php if($lang=='arabic'){ echo "selected";} ?>>Arabic</option>
                  </select>
                   
                </li>
                
            </ul>
        </div>
    </div>
</div>

<div class="bsnav-mobile">
    <div class="bsnav-mobile-overlay"></div>
    <div class="navbar bsnav-scrollspy"></div>
</div>

