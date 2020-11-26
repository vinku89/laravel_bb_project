<!doctype html>
<html lang="en">
<head>
   <!-- Required meta tags -->
   <meta charset="utf-8">
   <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
   <!-- To prevent most search engine web crawlers from indexing a page on your site -->
   <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/');?>/public/website/assets/images/favicon.ico" />
   <link rel="shortcut icon" type="image/x-icon" href="<?php echo url('/');?>/public/website/assets/images/favicon.png" />

   <link rel="stylesheet" type="text/css" href="<?php echo url('/');?>/public/website/assets/css/style.css">
   <link rel="stylesheet" type="text/css" href="<?php echo url('/');?>/public/website/assets/css/global.css">
   <link rel="stylesheet" type="text/css" href="<?php echo url('/');?>/public/website/assets/css/bsnav.css">
   <link rel="stylesheet" type="text/css" href="<?php echo url('/');?>/public/website/assets/css/bootstrap.css">
   
   <link rel="stylesheet" type="text/css" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">

   <!--  font-family: 'Nunito Sans', sans-serif; -->
   <title>موقع بست بوكس - البث التلفزيوني المباشر عبر الانترنت</title>
</head>
<body>

  <!-- Header -->
   <div class="navbar navbar-expand-sm bsnav bestbox-nav bsnav-sticky bsnav-scrollspy">
    <div class="container bb_width">
        <a class="navbar-brand" href=""></a>
        <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-sm-end">
            <ul class="navbar-nav navbar-mobile mr-0">
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="content-packages">محتوى حزمة العروض  </a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="tvbox">صندوق التلفاز(تي في بوكس)</a></li>
                <!-- <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="freetrial">Free Trial</a></li> -->
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="subscribe-now">اشترك الآن</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="refer">إقترح لصديقك </a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="<?php echo url('/login');?>"><span class="mr-2"><img src="/public/website/assets/images/reseller.png" class="img-fluid" /></span>الموزع</a></li>
                <li class="nav-item nav-item-fill pr-5"><a class="nav-link font-primary-book" href="<?php echo url('/customerLogin');?>"><span class="mr-2"><img src="/public/website/assets/images/my_acc.png" class="img-fluid" /></span>الزبون /المشتري</a></li>
                <li class="nav-item nav-item-fill mt-2 f12 color-white" >
                  <select class="custom-select select_lang">
                     <option value="english" <?php if($lang=='english'){ echo "selected";} ?>>English</option>
                     <option value="danish" <?php if($lang=='danish'){ echo "selected";} ?>>Danish</option>
                     <option value="french" <?php if($lang=='french'){ echo "selected";} ?>>French</option>
                     <option value="arabic" <?php if($lang=='arabic'){ echo "selected";} ?>>Arabic</option>
                  </select>
                  <!-- <div class="language_select" tabindex="1">
                     <input class="selectopt select_lang" value="english" name="language" type="radio" id="english" <?php //if($lang=='english'){ echo "checked";} ?>>
                     <label for="english" class="option">English</label>
                     <input class="selectopt select_lang" value="danish" name="language" type="radio" id="danish" <?php //if($lang=='danish'){ echo "checked";} ?>>
                     <label for="danish" class="option">Danish</label>
                   </div> -->
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- Header End -->

<div class="bsnav-mobile">
    <div class="bsnav-mobile-overlay"></div>
    <div class="navbar bsnav-scrollspy"></div>
</div>
   <section class="hero" id="hero">
      <div id="bestBoxSlides" class="carousel slide carousel-fade" data-ride="carousel">
      <ol class="carousel-indicators">
         <li data-target="#bestBoxSlides" data-slide-to="0" class="active"></li>
         <li data-target="#bestBoxSlides" data-slide-to="1"></li>
         <li data-target="#bestBoxSlides" data-slide-to="2"></li>
         <li data-target="#bestBoxSlides" data-slide-to="3"></li>
         <!-- <li data-target="#bestBoxSlides" data-slide-to="4"></li> -->
      </ol>
         <div class="carousel-inner">
            <div class="carousel-item active">
               <div class="carousel-item-1 carousel-item-bg">
                  <div class="container bb_width">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="carousel-title font-size-xxxxl font-title">
                           أحدث الأفلام الدولية<br>
                             <a href="https://youtu.be/hFu14bAZYsU" class="youtube_btn"><i class="fas fa-play-circle mr-2"></i>Step by step tutorial</a>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="carousel-title-img">
                                 <!-- Mpney Guarantee icon -->
                              <img src="<?php echo url('/');?>/public/website/assets/images/money-back-guarantee.png" class="img-fluid money_back"/>
                              <img src="/public/website/assets/images/BestBox-banner-title-1.png" class="img-fluid"/>
                           </div>
                        </div>
                     </div>
                  </div>
                  <!-- <img src="assets/images/BestBox-bg-1.png" alt="" class="img-fluid w-100 d-none d-sm-none d-md-block fullvh"> -->
                  <!-- <img src="assets/images/mobile/mobile-banner-1.jpg" alt="" class="img-fluid w-100 d-block d-sm-block d-md-none fullvh"> -->
               </div>
            </div>
            <div class="carousel-item">
               <div class="carousel-item-2 carousel-item-bg">
                  <div class="container bb_width">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="carousel-title font-size-xxxxl font-title">
                           أفلام هندية شعبية<br>
                             <a href="https://youtu.be/hFu14bAZYsU" class="youtube_btn"><i class="fas fa-play-circle mr-2"></i>Step by step tutorial</a>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="carousel-title-img">
                                 <!-- Mpney Guarantee icon -->
                              <img src="<?php echo url('/');?>/public/website/assets/images/money-back-guarantee.png" class="img-fluid money_back"/>
                              <img src="/public/website/assets/images/BestBox-banner-title-2.png" class="img-fluid"/>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="carousel-item carousel-item-3">
               <div class="carousel-item-3 carousel-item-bg">
                  <div class="container bb_width">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="carousel-title font-size-xxxxl font-title">
                           أفضل المسلسلات التلفزيونية الدولية<br>
                             <a href="https://youtu.be/hFu14bAZYsU" class="youtube_btn"><i class="fas fa-play-circle mr-2"></i>Step by step tutorial</a>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="carousel-title-img">
                                 <!-- Mpney Guarantee icon -->
                              <img src="<?php echo url('/');?>/public/website/assets/images/money-back-guarantee.png" class="img-fluid money_back"/>
                              <img src="/public/website/assets/images/BestBox-banner-title-3.png" class="img-fluid"/>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- <div class="carousel-item">
               <div class="carousel-title font-size-xxxxl font-title">
                  The Best Indonesian Movies
               </div>
               <img src="assets/images/banner-4.png" alt="" class="img-fluid w-100 d-none d-sm-none d-md-block">
               <img src="assets/images/mobile/mobile-banner-4.jpg" alt="" class="img-fluid w-100 d-block d-sm-block d-md-none fullvh">
            </div> -->
            <div class="carousel-item carousel-item-5">
               <div class="carousel-item-5 carousel-item-bg">
                  <div class="container bb_width">
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="carousel-title font-size-xxxxl font-title">
                           البث المباشر للرياضة<br>
                             <a href="https://youtu.be/hFu14bAZYsU"  class="youtube_btn"><i class="fas fa-play-circle mr-2"></i>Step by step tutorial</a>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="carousel-title-img">
                                 <!-- Mpney Guarantee icon -->
                              <img src="<?php echo url('/');?>/public/website/assets/images/money-back-guarantee.png" class="img-fluid money_back"/>
                              <img src="/public/website/assets/images/BestBox-banner-title-5.png" class="img-fluid"/>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
             <!--Desktop view-->
            <div class="free_trial_div">
               <a href="<?php echo url('/customerLogin');?>" class="free_trial_click"><img src="<?php echo url('/');?>/public/website/assets/images/go-btn.png"></a>
            </div>
           <!--mobile view-->
           <div class="mbl_free_trial_div">
            <a href="<?php echo url('/customerLogin');?>"><img src="<?php echo url('/');?>/public/website/assets/images/mobile_free_trialbtn.png"></a>
           </div>
      </div>
   </section>
   <div class="text-center bb-width-md container py-5">
      <div class="f30 text-color-primary">
         <!-- <img src="/public/website_danish/assets/images/compatible_android.png" class="img-fluid" /> -->
         متوافق مع نظام الاندرويد 
      </div>
   </div>
   <section>
      <div class="container bb_width-md">
         <h1 class="color-text-dark font-title font-size-xxxl text-center">
         مشاهدة بلا حدود مع أكثر من 9000+ قناة بجودة عالية الوضوح  
         </h1>
         <div class="mt-3 mb-5 font-size-md font-primary-book text-color-primary text-right">
         الوصول إلى أكثر من 9000 قناة في جميع أنحاء العالم ،أكثر من 60 دولة بجودة عالية الوضوح
موقع البست بوكس هو الخيار المفضل لتكنالوجيا ال آي بي تي في (تلفزيون بروتوكول الانترنت) للجميع ، لمشاهدة مقاطع الفيديو عبر الانترنت ، دون الحاجة إلى الأقمار الصناعية التقليدية أو اتصال السلكي.

            <br><br>

            يوفر خادمنا المخصص وقت تشغيل بنسبة 99.9 ٪ مع اتصال سريع بشكل لا يصدق في اتصال 1000 ميغابت في الثانية.
         </div>
         <div class="font-size-md font-primary-book text-color-primary text-right">
         شاهد جميع قنواتك الرياضية والفضائية المفضلة مباشرة دون أي قيود ، وقم ببث أحدث الأفلام والمسلسلات التلفزيونية على الفور من خلال إشتراكك في موقع البست بوكس  
         </div>
         <div class="row mt-5">
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/fullhd.png" class="img-fluid"/></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               كامل جودة عالية الوضوح وجودة فائقة الوضوح
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               شاهد مقاطع الفيديو بدقة عالية (عالية الدقة 1920 × 1،080) أو (الوضوح القياسي) استنادًا على ترجيحك وحجم الشاشة.
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/inst_act.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               التفعيل الفوري
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               احصل على التنشيط و التفعيل الفوري لحسابك مباشرة بعد الاشتراك.
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/recording.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  <!-- 14 Days Live TV Recording -->
                  متابعة آخر 14 يوم 
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               تابع برنامجك التلفزيوني المفضل هنا! يمكنك تسجيل آخر 14 يومًا من برامجك التلفزيونية المفضلة ، حتى تتمكن من مشاهدتها مرة أخرى في أي وقت. 
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/uptime.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               وقت تشغيل وجهوزية بنسبة 99.9 ٪
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               توفر شبكتنا العالمية من الخوادم المخصصة وقت تشغيل سريع وموثوق بنسبة 99،9٪ .
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/worldwide.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               متاح في جميع أنحاء العالم
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               مع عدم وجود قيود إقليمية ، يتوفر  بست بوكس للمستخدمين في جميع أنحاء العالم ، كل ما تحتاجه هو اتصال بالإنترنت.
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/support.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               الدعم الفني 24 ساعة / 7 ايام الاسبوع 
               </div>
               <div class="text-color-primary font-size-sm font-primary-book text-right">
               اتصل بنا كلما واجهت أي مشاكل واحصل على المساعدة من دعم العملاء لدينا.
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="content_packages pb-1" id="content-packages">
      <div class="container bb_width py-5">
         <div class="text-center mb-2">
            <h1 class="font-size-xxxl font-title text-color-dark mb-0">محتوى حزمة عرض الصفقة</h1>
            <img src="/public/website/assets/images/content_packages.png" class="img-fluid" />
         </div>
         <h2 class="text-color-purple font-primary font-size-xl text-center pt-5">
         اكثر من 9000+ من القنوات المباشرة
         </h2>
         <p class="font-primary-book font-size-sm text-color-primary text-center mt-4 mb-5">
         مع القنوات المباشرة المتاحة من أكثر من 60 دولة ، استمتع بالبث في جميع أنحاء العالم خارج منطقتك دون قيود.
         </p>
      </div>
      <div class="container bb_width-md">

         <div class="content_packages_list text-center py-5">
            <img src="/public/website/assets/images/content_packages_list_new.png" class="img-fluid" />
         </div>

         <div class="row pt-3 my-5">
            <div class="col-lg-12 text-center">
               <div class="my-3 " style="height: 70px;"><img src="/public/website/assets/images/movies.svg" class="img-fluid"
                     style="width: 61px; height: 53px;" /></div>
               <div class="font-size-lg text-color-dark font-primary mb-3">اكثر من 15000+ من الأفلام والمسلسلات التلفزيونية</div>
               <div class="font-primary-book font-size-sm text-color-primary">
               استمتع بمشاهدة الأفلام والمسلسلات التلفزيونية المفضلة لديك بلا حدود.<br> الوصول إلى جميع المحتوايات الحديثة مع الاشترك في موقع البست بوكس. 
               </div>
               <div class=" mt-3">
                  <span class="badge badge-bb">افلام قوة الحركة والعنف (الأكشن</span>
                  <span class="badge badge-bb">الافلام الكوميدية</span>
                  <span class="badge badge-bb">الافلام الرومنسية</span>
                  <span class="badge badge-bb">افلام القصص المثيرة</span>
                  <span class="badge badge-bb">افلام الدراما</span>
               </div>
            </div>
            <!-- <div class="col-lg-6 mt-lg-0 mt-5">
                <div class="my-3" style="height: 70px;"><img src="/public/website_danish/assets/images/watch_inst_online.png"
                     class="img-fluid" /></div>
              <div class="font-size-lg text-color-dark font-primary mb-3">Se Straks Online</div>
               <div class="font-primary-book font-size-sm text-color-primary">
                  Stream, se & administrere din konto, når du er på farten med BestBox mobil app eller en hvilken som helst browser!
               </div>
               <div class="row mt-3 d-none">
                  <div class="col-8"><span class="badge badge-bb w-100">Watch up to 3 screens at the same time</span></div>
                  <div class="col-2 px-1"><span class="d-block " style="margin-top: -5px;"><img src="/public/website_danish/assets/images/istore.svg" class="img-fluid"
                        style="width: 98px; height: 40px;" /></span></div>
                  <div class="col-2 px-1"><span class="d-block " style="margin-top: -5px;"><img src="/public/website_danish/assets/images/playstore.svg" class="img-fluid"
                        style="width: 98px; height: 40px;" /></span></div>
               </div> 
            </div>-->
         </div>
      </div>
   </section>
   <section class="mobile-app-bg  pb-1" id="mobile-app">
      <div class="col-sm-12">
          <div class="row">
         <div class="col-lg-6 offset-lg-2 col-md-12 cstm_pt text-right">
             <h3 class="font-size-xl text-color-white font-primary pb-3 text-right">شاهد البث المباشر على الانترنت مع خدمة بست بوكس من تطبيق الجوال</h3>
             <p class="text-justify text-color-primary font-size-md mb-5 font-primary-book text-color-white  text-right">
             بامكانك مشاهدة و ادارة حسابك أثناء التنقل باستخدام بست بوكس لتطبيق الجوال
             </p>
            <div class="display-inline-block">
               <a href="https://play.google.com/store/apps/details?id=net.vodrex" target="_blank"><img src="<?php echo url('/');?>/public/website/assets/images/playstore_btn.png" ></a>
            </div>
             
         </div>
         <div class="col-lg-4 col-md-12 sm-text-center danish" style="position:relative;">
            <img src="<?php echo url('/');?>/public/website/assets/images/mobileapp-view.png" class="mobileapp_show img-fluid" >
            
         </div>
      </div>
      </div>
   </section>
   <section class="pb-3 custom_padding" id="tvbox">
   <div class="col-lg-10 offset-lg-2">
          <div class="row">
            <div class="col-lg-5 col-md-12 sm-text-center" style="position:relative;">
               <img src="<?php echo url('/');?>/public/website/assets/images/tv-app.png" class="img-fluid" >
               </div>
            <div class="col-lg-7 col-md-12 cstm_pt2">
            <div class="col-lg-10">
            <h3 class="font-size-xl text-color-purple font-primary pb-3 text-right">صندوق البث التلفزيوني عبر الانترنت</h3>
               <h3 class="font-size-xl text-color-purple font-primary pb-3 text-right">شاهد على تلفازك</h3>
               <div class="col-lg-12">
               <p class="font-primary-book font-size-md text-color-primary  text-right">
               يمكنك مشاهدة البث المباشر ومشاهدة التلفاز بشاشة كبيرة بجودة عالية الدقة مع صندوق تلفزيون بست بوكس بشكل مريح في منزلك.
<br>مشاهدة التسجيلات الخاصة بك لمدة تصل إلى 14 يوما!
               </p>
               </div>
            </div>
               
               
            </div>
       
      </div>
      </div>

<!-- Free Trial Section Start Here -->
      <section>
         <div class="container bb_width-md pt-5" style="position: relative;">

            <!-- Desktop View -->
            <div class="free_trial_section">
               <div class="col-md-6 offset-md-5">
                  <h1 class="h1_title">ابدأ تجربتك المجانية</h1>
                  <p class="p_text">لبدء الاستمتاع بمجموعة واسعة من المحتوى والقنوات من BestBOX</p>

                  <a href="<?php echo url('/customerLogin');?>" class="request_btn">طلب نسخة تجريبية مجانية</a>
               </div>
            </div>
            <img src="<?php echo url('/');?>/public/website/assets/images/free-trial-bg.png" class="img-fluid small_mblview">

            <!-- Mobile View -->
            <div class="freeTrial_mbl_section">
               <h1 class="h1_title">ابدأ تجربتك المجانية</h1>
                  <p class="p_text">لبدء الاستمتاع بمجموعة واسعة من المحتوى والقنوات من BestBOX</p>

                  <a href="<?php echo url('/customerLogin');?>" class="request_btn">طلب نسخة تجريبية مجانية</a>
            </div>

         </div>
      </section>

 <!-- Free Trial Section End Here -->

      <div class="container bb_width-md pt-5">

         <div class="row">
            <div class="packages">

           <!-- 1 Package  -->
            <div class="box_buy" style="position:relative">
                  <div class="box_buy_title bg-orange">
                     <div class="text-center py-2" style="line-height: 80px;">
                     <i class="fas fa-info-circle info_btn" style="top:38px;" data-toggle="modal" data-target="#imp-note"></i>
                         <img src="/public/website/assets/images/bb_white_logo.png" class="img-fluid" style="height:30px;" /></div>
                  </div>
                  <div class="box_buy_body text-center py-5">
                     <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                     <div class="text-color-purple font-size-sm font-primary mt-3 "> &nbsp</div>
                     <div class="text-color-orange fontSize font-title mt-4">79 دولار أمريكي</div>
                     <div class="content_fontSize text-color-primary pt-3">
                     ما عليك سوى توصيل و تشغيل لشاشة التلفاز الكبيرة مع جهاز (تي في بوكس) والذي يشمل التطبيق المثبت مسبقًا ، والتحكم عن بعد وكابل منفذ
 (  اتش دي ام آي ) و مع خدمة التوصيل الى جميع انحاء العالم  
                        <!-- <br>&nbsp -->
                     </div>
                     <div class="text-center mt-4">
                        <a href="<?php echo url('customerLogin'); ?>" class="btn-rounded btn-orange text-white">اشتري الآن</a>
                     </div>
                  </div>
               </div>
            </div>

            <!-- 2 Package  -->
            <div class="packages" style="position:relative">
               <div class="box_buy buy_1m">
                     <div class="box_buy_title bg-purple">
                        <div class="text-center py-2" style="line-height: 55px;">
                        <i class="fas fa-info-circle info_btn" data-toggle="modal" data-target="#imp-note"></i>
                           <img src="/public/website/assets/images/bb_white_logo.png" class="img-fluid" style="height:30px;" />
                           <p class="text-white font-size-sm font-primary">+ اشتراك لمدة شهر واحد</p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ اشتراك لمدة شهر واحد</div>
                        <div class="text-color-purple fontSize font-title mt-4">99 دولار أمريكي </div>
                        <div class="content_fontSize text-color-primary pt-3">ما عليك سوى توصيل و تشغيل لشاشة التلفاز الكبيرة مع جهاز( تي في بوكس) والذي يشمل التطبيق المثبت مسبقًا
                           <span class="text-color-purple font-primary">مع الاشتراك لمدة شهر واحد </span> و مع خدمة التوصيل الى جميع انحاء العالم
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">اشتري الآن</a>
                        </div>
                     </div>
                  </div>
               </div>

            <!-- 3 Package  -->
            <div class="packages" style="position:relative">
               <div class="box_buy buy_1m">
                     <div class="box_buy_title bg-purple">
                        <div class="text-center py-2" style="line-height: 55px;">
                        <i class="fas fa-info-circle info_btn" data-toggle="modal" data-target="#imp-note"></i>
                           <img src="/public/website/assets/images/bb_white_logo.png" class="img-fluid" style="height:30px;" />
                           <p class="text-white font-size-sm font-primary">+ اشتراك لمدة 3 أشهر </p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ اشتراك لمدة 3 أشهر </div>
                        <div class="text-color-purple fontSize font-title mt-4">149 دولار أمريكي</div>
                        <div class="content_fontSize text-color-primary pt-3">ما عليك سوى توصيل و تشغيل لشاشة التلفاز الكبيرة مع جهاز( تي في بوكس) والذي يشمل التطبيق المثبت مسبقًا
                           <span class="text-color-purple font-primary">مع الاشتراك لمدة 3 أشهر </span>  و مع خدمة التوصيل الى جميع انحاء العالم
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">اشتري الآن</a>
                        </div>
                     </div>
                  </div>
               </div>

            <!-- 4 Package  -->
            <div class="packages" style="position:relative">
               <div class="box_buy buy_1m">
                     <div class="box_buy_title bg-purple">
                        <div class="text-center py-2" style="line-height: 55px;">
                        <i class="fas fa-info-circle info_btn" data-toggle="modal" data-target="#imp-note"></i>
                           <img src="/public/website/assets/images/bb_white_logo.png" class="img-fluid" style="height:30px;" />
                           <p class="text-white font-size-sm font-primary">+ اشتراك لمدة 6 أشهر </p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ اشتراك لمدة 6 أشهر </div>
                        <div class="text-color-purple fontSize font-title mt-4"> 229 دولار أمريكي</div>
                        <div class="content_fontSize text-color-primary pt-3">ما عليك سوى توصيل و تشغيل لشاشة التلفاز الكبيرة مع جهاز( تي في بوكس) والذي يشمل التطبيق المثبت مسبقًا
                           <span class="text-color-purple font-primary">مع الاشتراك لمدة 6 أشهر </span>  و مع خدمة التوصيل الى جميع انحاء العالم
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">اشتري الآن</a>
                        </div>
                     </div>
                  </div>
               </div>

            <!-- 5 Package  -->
            <div class="packages" style="position:relative">
               <div class="box_buy buy_1m">
                  <div class="box_buy_title bg-purple">
                     <div class="text-center py-2" style="line-height: 55px;">
                     <i class="fas fa-info-circle info_btn" data-toggle="modal" data-target="#imp-note"></i>
                        <img src="/public/website/assets/images/bb_white_logo.png"
                           class="img-fluid" style="height:30px;" />
                        <p class="text-white font-size-sm font-primary">+ اشتراك لمدة 12 شهر </p>
                     </div>
                  </div>
                  <div class="box_buy_body text-center py-5">
                     <img src="/public/website/assets/images/bbox_decorder_small.png"
                        class="img-fluid" />
                     <div class="text-color-purple font-size-xs font-primary mt-3">+ اشتراك لمدة 12 شهر </div>
                     <div class="text-color-purple fontSize font-title mt-4">349 دولار أمريكي </div>
                     <div class="content_fontSize text-color-primary pt-3">ما عليك سوى توصيل و تشغيل لشاشة التلفاز الكبيرة مع جهاز( تي في بوكس) والذي يشمل التطبيق المثبت مسبقًا
                        <span class="text-color-purple font-primary">مع الاشتراك لمدة 12 شهر </span>  و مع خدمة التوصيل الى جميع انحاء العالم
                     </div>
                     <div class="text-center mt-4">
                        <a href="<?php echo url('customerLogin'); ?>"
                           class="text-white btn-rounded btn-purple">اشتري الآن</a>
                     </div>
                  </div>
               </div>
            </div>
               
         </div>
      </div>
   </section>
   <section class="subscribe pb-5" id="subscribe-now">
      <div class="container bb_width-md pt-5">
         <div class="text-center mb-3">
            <h1 class="font-size-xxxl font-title text-white mb-3">إشترك الآن</h1>
            <p class="font-size-md pb-4 font-title text-white">الاشتراكات أدناه لا تشمل جهاز (تي في بوكس)</p>
         </div>
         <div class="subscribe_features">
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>جودة عالية الوضوح وجودة فائقة الوضوح</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span> التنشيط الفوري</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>لا توجد قيود إقليمية</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>جهوزية عالية  99.9 %</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>24/7 الدعم التقني</div>
         </div>
         <div class="text-center mt-5 mb-3 text-white font-primary-book font-size-md">
         نحن نقبل العملة بالدولار الامريكي و الفيزا كارد و الماستر كارد و البي بال و العملات المشفرة المذكورة أدناه
         </div>
         <div class="text-center my-4">
            <img src="/public/website/assets/images/payment.png" class="img-fluid"
               style="max-width: 600px; max-height: 56px; width:100%;" />
         </div>
         <div class="row subscription">
            <!-- Hidden -->
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto d-none">
               <div class="subscription_pack subscription_pack_free">
                  <span class="ribbon ribbon-orange f18" style="line-height: 30px;">FREE</span>
                  <div class="text-color-orange font-size-xs font-primary mb-4">1 DAY</div>
                  <img src="/public/website/assets/images/bboxdemo.png" class="img-fluid" />
                  <div class="text-color-orange font-title font-size-xl text-center mt-5 pb-4">FREE<br>TRIAL</div>
               </div>
               <a href=""
                  class="subscription_pack_btn subscription_pack_btn_orange text-center text-white d-block">JOIN</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_1m" style="position:relative">
                  <!-- <span class="ribbon ribbon-purple d-none f14">FREE</span> -->
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">شهر واحد</div>
                  <img src="/public/website/assets/images/bbox1.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        دولار</div>
                     <div class="subscription_pack_offer_actual_price">&nbsp</div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-lg text-center text-color-purple mt-2">
                        دولار$34.99</div>
                     <div class="subscription_pack_offer_saving pb-2">&nbsp</div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">أشترك</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_3m">
                  <!-- <span class="ribbon ribbon-purple d-none f14">FREE</span> -->
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">3 شهور</div>
                  <img src="/public/website/assets/images/bbox3.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        دولار</div>
                     <div class="subscription_pack_offer_actual_price">$103.97<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-lg text-center text-color-purple mt-2">
                        دولار$89.99</div>
                     <div class="subscription_pack_offer_saving mb-2"> وفر 14.98$ دولار </div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">أشترك</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_6m">
                  <span class="ribbon ribbon-purple f14">الأكثر<br> طلبا</span>
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">6 شهور</div>
                  <img src="/public/website/assets/images/bbox6.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        دولار</div>
                     <div class="subscription_pack_offer_actual_price">$209.94<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-lg text-center text-color-purple mt-2">
                        دولار$169.99</div>
                     <div class="subscription_pack_offer_saving"> وفر 39.95$ دولار </div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">أشترك</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_12m">
                  <span class="ribbon ribbon-purple f14">قيمة<br>أفضل</span>
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">12 شهر</div>
                  <img src="/public/website/assets/images/bbox12.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        USD</div>
                     <div class="subscription_pack_offer_actual_price">$419.88<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-lg text-center text-color-purple mt-2">
                        دولار$299.99 </div>
                     <div class="subscription_pack_offer_saving">  وفر 39.95$ دولار</div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">أشترك</a>
            </div>
         </div>
      </div>
   </section>
   <section class="refer pt-0 pb-5" id="refer">
      <div class="container bb_width pt-4">
         <div class="row mb-3">
            <div class="col-md-8 offset-md-2 col-sm-12  col-xl-6 offset-xl-6 refer_mobile_padding">
               <h1 class="font-size-xxl font-title text-color-dark mt-5 mb-3 pt-5 text-right">إقترح  لأصدقائك</h1>
               <p class="text-justify text-color-primary font-size-md mb-5 pb-5 font-primary-book text-right">المشاركة تعنى الاهتمام! قم بإحالة أصدقائك إلى اشتراك في موقع بست بوكس حتى يتمكنوا من الاستمتاع بالمشاهدة أيضًا! ستحصل على مكافأة الإحالة بعد اشتراكهم بنجاح.
               </p>
               <div class="referral_card text-center mt-5 w80 mx-auto">
                  <div class="referral_card_head font-size-xl font-title text-white">
                  10 دولار 
                  </div>
                  <div class="referral_card_body font-size-md w80 mx-auto">
                  لكل صديق تم احالته وتم الاشتراك بالخدمة.                  </div>
                  <a class="referral_card_btn" href="<?php echo url('customerLogin'); ?>" >
                  إقترح لأصدقائك الآن!
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="referal_table">
      <div class="container referal_table_wrap">
         <div class="referal_table_wrap_head">
            <div class="referal_cell_body referal_table_wrap_head_blank w40">
            </div>
            <div class="referal_cell_body referal_table_wrap_head_1 w30 text-right">
            مكافأة الاحالة            </div>
            <div class=" referal_cell_body referal_table_wrap_head_2 w30 text-right">
            الرصيد
            </div>
         </div>
         <!-- body -->
         <div class="referal_border">
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
               إقتراح لأول صديقك 
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
               10 دولار
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
               10 دولار
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
               إقتراح لثاني صديقك
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
               10 دولار
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
               20 دولار
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
               إقتراح لثالث صديقك
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
               10 دولار
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
               30 دولار
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
               إقتراح لرابع صديقك
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
               10 دولار
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
               40 دولار
               </div>
            </div>
         </div>
         <!-- footer -->
         <div class="referal_table_wrap_footer">
            <div class="referal_cell_footer referal_table_wrap_footer_blank w40">
            </div>
            <div class="referal_cell_footer referal_table_wrap_footer_1 w30 text-right">
            المبلغ الكلي
            </div>
            <div class=" referal_cell_footer referal_table_wrap_footer_2 w30 text-right font-size-md text-color-orange">
            40 دولار
            </div>
         </div>
         <div class="text-right mt-3 font-size-sm"><span class="text-color-orange font-primary"> على استرداد اشتراك شهر واحد</span>ستكون قادرًا!</div>
         <div class="mt-5 pt-5 text-center font-secondary font-size-lg">
         الخاصة بك <span class="text-color-purple">استرداد مكافأة الإحالة </span>
         الخاصة بك مع صديقك أو<span class="text-color-purple font-secondary-bold">مشاركة مكافأة الإحالة</span>الإقتراح الخاصة بك مع صديقك أو
للاشتراك في</div>
         <div class="font-primary-book font-size-md text-center mt-4">
         سيتم إضافة المزيد من شركاء الاسترداد قريبًا.
         </div>
         <div class="row">
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                  دولار$34.99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                  من الاشتراك بخدمة البست بوكس<span class="text-color-purple font-primary"> 1 شهر</span> استرداد لمدة
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>"  >
                  استرد الآن

                  </a>
               </div>
            </div>
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                  دولار$89.99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                  من الاشتراك بخدمة البست بوكس<span class="text-color-purple font-primary"> 3 أشهر</span> استرداد لمدة
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>" >
                  استرد الآن 
                  </a>
               </div>
            </div>
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                  دولار$169.99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                  من الاشتراك بخدمة البست بوكس <span class="text-color-purple font-primary">6 أشهر</span> استرداد لمدة
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>" >
                  استرد الآن
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="pb-5 mb-5" id="join-reseller">
      <div class="container bb_width-md pt-5">
         <h1 class="font-size-xxxl text-color-dark text-center font-title pb-4">انضم لبرنامج الموزع الخاص بنا</h1>
         <div class="font-primary-book font-size-md text-color-primary text-left">
         <p class="pb-3 text-right">
         يهدف برنامج موزع البست بوكس لدينا إلى مساعدتك في الحصول على أكبر عدد ممكن من المبيعات. إنه سهل الاستخدام مع معلومات بديهية من لوحة عرض الموزع ولوحة معلومات للمستخدم النهائي لمراجعتك اليومية
            </p>
            <p class="pb-3 text-right">
            كرائد في السوق ، نحن نتفهم حاجة عملائنا ومتطلباتهم ، ونحن هنا لمساعدتك على أن تكون ناجحًا قدر الإمكان لأن نجاحك يعادل نجاحنا.

            </p>
            <p class="pb-3 text-right">
            سنتعامل مع كل شيء لك بما في ذلك معالجة المبيعات ودفع تعويضات العمولة - كل ما عليك فعله هو البيع فقط! لا توجد رسوم استثمار أو بدء تشغيل أولية ، لا يوجد سوى ربح فوري.

            </p>
            <p class=" text-right">
            ما عليك سوى فتح حساب موزع مجاني ومراجعة برنامج موزع البست بوكس الجذاب وامنح لنفسك فرصة الحصول على دخل شهري, اتصل بنا عبر الدردشة المباشرة لأي استفسار.            
            </p>
         </div>
         <!-- <div class="pt-5">
            <img src="/public/website_danish/assets/images/agent-commission-rate.svg" class="img-fluid">
         </div>

         <div class="mt-4 d-block d-sm-block d-md-none text-center">
            <a class="btn-purple btn-rounded text-white text-center mx-auto" href="/public/website_danish/assets/images/agent-commission-rate.jpg" data-lightbox="example-1">View full image</a>
         </div> -->

         <div class="pt-5 d-none">
            <div class="contact_form_wrp">
               <div class="row">
                  <div class="col-xl-4 col-lg-4 left_box">
                     <div class="play_bg">
                        <div class="form_title_wrp">
                           <h1 class="text-white font-title">
                              Live Chat with us to join our Reseller Program
                           </h1>
                        </div>
                     </div>
                  </div>
                  <div class="col-xl-8 col-lg-8">
                     <div class="form_wrp">
                        <form action="">
                           <div class="form-group">
                              <input type="email" class="form-control custom_form-controle" id="exampleInputEmail1"
                                 aria-describedby="emailHelp" placeholder="Name">
                              <small id="emailHelp" class="form-text text-muted"></small>
                           </div>
                           <div class="form-group">
                              <input type="email" class="form-control custom_form-controle" id="exampleInputEmail1"
                                 aria-describedby="emailHelp" placeholder="Email">
                              <small id="emailHelp" class="form-text text-muted"></small>
                           </div>
                           <div class="form-group">
                              <input type="email" class="form-control custom_form-controle" id="exampleInputEmail1"
                                 aria-describedby="emailHelp" placeholder="Mobile Number">
                              <small id="emailHelp" class="form-text text-muted"></small>
                           </div>
                           <div class="form-group">
                              <textarea class="form-control custom_form-controle resize-none"
                                 id="exampleFormControlTextarea1" rows="2" placeholder="Message"></textarea>
                              <small id="emailHelp" class="form-text text-muted"></small>
                           </div>
                           <div class="form_btn_wrp">
                              <a href="" class="form_btn">Join as a Reseller</a>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   @include('inc.message_icons')
@include('website_arabic.inc.footer')

   <!-- The Modal -->
<div class="modal fade imp-note" id="imp-note">
  <div class="modal-dialog modal-lg">
    <div class="modal-content modal_bg">

      <!-- Modal Header -->
      <div class="modal-header" style="padding:15px 50px;    border-bottom-color: #ff903f;">
        <h4 class="modal-title font-primary-book" style="font-weight:bold;">Important Note</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body font-primary-book" style="padding:30px 50px 50px 50px">
        <p>Please note as AliExpress only sells products and not services. When buying a subscription it may appear at first that you are purchasing a product, 
        in fact you are purchasing the BESTBOX streaming service, which you will receive access to shortly after your transaction has been completed. 
        When you purchase the subscription with a BESTBOX TV box, the item will be shipped to your shipping address and you will receive a 
        tracking number within 1-2 days upon purchase.</p>

        <p>
        During the purchase you will be asked to open an AliExpress account, just requires your email address and a password 
        of your choice and will be valid for future purchases. After purchase you will receive an email with your code details, 
        generally this will take a couple of hours so hold tight you will be up and running in no time. All of this may seem heavy 
        but have a go, it is very easy and secure for card payment.  
        </p>

         <p>
         If you have any questions please dont hesitate to contact us.
         </p>

      </div>

      <!-- Modal footer -->
      <!-- <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div> -->

    </div>
  </div>
</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.min.js"></script>
<script src="<?php echo url('/');?>/public/website/assets/js/popper.min.js"></script>
<script src="<?php echo url('/');?>/public/website/assets/js/bootstrap.min.js"></script>
<script src="https://rawgit.com/fitodac/bsnav/master/dist/bsnav.min.js"></script>
<!-- Start of LiveChat (www.livechatinc.com) code -->
<!-- End of LiveChat code -->
<?php 
   if(Session::has('lang')){}else{
?>
<script type="text/javascript">
   location.reload();
</script>
<?php
   }
?>
<script>
   $('.carousel').carousel({
      interval: 3000,
      pause: false
   });
   $(document.body).on('change','.select_lang',function(){
      var lang=$(this).val();
      var csrf_Value = "<?php echo csrf_token(); ?>";
      $.ajax({
         url: "<?php echo url('/');?>/change_lang",
         method: 'POST',
         async:"false",
         dataType: "json",
         data:{'_token':csrf_Value, 'lang' : lang},
         success: function(data) {
            location.reload();
         }
      })
   });
</script>
<script type="text/javascript">
   window.__lc = window.__lc || {};
   window.__lc.license = 10948082;
   (function () {
      var lc = document.createElement('script');
      lc.type = 'text/javascript';
      lc.async = true;
      lc.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'cdn.livechatinc.com/tracking.js';
      var s = document.getElementsByTagName('script')[0];
      s.parentNode.insertBefore(lc, s);
   })();
</script>
<noscript>
   <a href="https://www.livechatinc.com/chat-with/10948082/" rel="nofollow">Chat with us</a>,
   powered by <a href="https://www.livechatinc.com/?welcome" rel="noopener nofollow" target="_blank">LiveChat</a>
</noscript>
</body>
</html>
