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
   <title>BestBox - Online streaming IPTV</title>
</head>
<body>

  <!-- Header -->
   <div class="navbar navbar-expand-sm bsnav bestbox-nav bsnav-sticky bsnav-scrollspy">
    <div class="container bb_width">
        <a class="navbar-brand" href=""></a>
        <button class="navbar-toggler toggler-spring"><span class="navbar-toggler-icon"></span></button>
        <div class="collapse navbar-collapse justify-content-sm-end">
            <ul class="navbar-nav navbar-mobile mr-0">
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="content-packages">Indholds pakker</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="tvbox">TV Box</a></li>
                <!-- <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="freetrial">Free Trial</a></li> -->
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="subscribe-now">Abonner nu</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="#" data-scrollspy="refer">Henvis en ven</a></li>
                <li class="nav-item nav-item-fill"><a class="nav-link font-primary-book" href="<?php echo url('/login');?>" ><span class="mr-2"><img src="/public/website/assets/images/reseller.png" class="img-fluid" /></span>Forhandler</a></li>
                <li class="nav-item nav-item-fill pr-5"><a class="nav-link font-primary-book" href="<?php echo url('/customerLogin');?>"><span class="mr-2"><img src="/public/website/assets/images/my_acc.png" class="img-fluid" /></span>Min konto</a></li>
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
                              Nyeste Internationale Film<br>
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
                              Populære Hindi Film<br>
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
                              Top Internationale TV-serier<br>
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
                           Live Sport Streaming<br>
                             <a href="https://youtu.be/hFu14bAZYsU" class="youtube_btn"><i class="fas fa-play-circle mr-2"></i>Step by step tutorial</a>
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
         <img src="/public/website/assets/images/compatible_android.png" class="img-fluid" />
      </div>
   </div>
   <section>
      <div class="container bb_width-md">
         <h1 class="color-text-dark font-title font-size-xxl text-center">
            Se uden begrænsning 9,000+ HD kanaler
         </h1>
         <div class="mt-3 mb-5 font-size-md font-primary-book text-color-primary">
            Få adgang til mere end 9.000 kanaler på verdensplan fra over 60 lande i HD-kvalitet. BestBox er det foretrukne valg af IPTV (Internet Protocol Television) streaming. 
            Se alle film og serier på dit TV, computer eller tablet, uden behov for en traditionel satellit- eller kabelforbindelse.

            <br><br>

            Vores dedikerede servere giver 99,9% oppetid med en utrolig hurtig forbindelse på 1.000 Mbps.
         </div>
         <div class="font-size-md font-primary-book text-color-primary">
            Se alle dine foretrukne Sport og direkte tv-kanaler uden regionale restriktioner, og streame de nyeste Film & TV-serier med dit BestBox abonnement. 
         </div>
         <div class="row mt-5">
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/fullhd.png" class="img-fluid"/></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  Full HD & SD Kvalitet
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
                  Se videoer i Full HD (high definition 1920 x 1080) eller SD (standard definition) baseret på dine præferencer og skærmstørrelse.
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/inst_act.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  Øjeblikkelig aktivering
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
               Få øjeblikkelig aktivering af din konto. Vi aktiverer straks efter betaling
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/recording.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  <!-- 14 Days Live TV Recording -->
                  14 Dage catchup
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
                  Catch op på de mest populære tv-kanaler lige her! Bestbox optager de sidste 14 <span class="font-weight-bold">dage af dine foretrukne tv-programmer, så du kan se det igen når som helst.</span>
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/uptime.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  99,9% Oppetid
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
                  Vores globale netværk af dedikerede servere giver en hurtig og pålidelig 99,9% oppetid.
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/worldwide.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
               Tilgængelig I hele verden
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
                  Med ingen regionale restriktioner, er BestBox tilgængelig for brugere over hele verden. Alt hvad du behøver, er en internetforbindelse.
               
               </div>
            </div>
            <div class="col-md-4 my-5">
               <div class="text-center mb-4"><img src="/public/website/assets/images/support.png" class="img-fluid" /></div>
               <div class="text-color-dark font-size-lg font-primary pb-4 text-center">
                  24/7 Support
               </div>
               <div class="text-color-primary font-size-sm font-primary-book">
                  Kontakt os, når du støder på problemer & få hjælp fra vores kundesupport.
               </div>
            </div>
         </div>
      </div>
   </section>
   <section class="content_packages pb-1" id="content-packages">
      <div class="container bb_width py-5">
         <div class="text-center mb-2">
            <h1 class="font-size-xxxl font-title text-color-dark mb-0">Indholds pakker</h1>
            <img src="/public/website/assets/images/content_packages.png" class="img-fluid" />
         </div>
         <h2 class="text-color-purple font-primary font-size-xl text-center pt-5">
            9,000+ Live-Kanaler
         </h2>
         <p class="font-primary-book font-size-sm text-color-primary text-center mt-4 mb-5">
            Med Live-kanaler til rådighed fra mere end 60 lande, kan du nyde verdensomspændende streaming uden for dit område uden restriktioner.
         </p>
      </div>
      <div class="container bb_width-md">

         <div class="content_packages_list text-center py-5">
            <img src="/public/website/assets/images/content_packages_list_new.png" class="img-fluid" />
         </div>

         <div class=" my-5">
            <div class="col-lg-12 text-center">
               <div class="my-3" style="height: 70px;"><img src="/public/website/assets/images/movies.svg" class="img-fluid"
                     style="width: 61px; height: 53px;" /></div>
               <div class="font-size-lg text-color-dark font-primary mb-3">15,000 Film & TV-serier</div>
               <div class="font-primary-book font-size-sm text-color-primary">
                  Se dine yndlingsfilm og TV-serie uden grænser. <br>Få adgang til alt det nyeste indhold med BestBox abonnement.
               </div>
               <div class=" mt-3">
                  <span class="badge badge-bb">Action</span>
                  <span class="badge badge-bb">Komedie</span>
                  <span class="badge badge-bb">Erotik</span>
                  <span class="badge badge-bb">Thriller</span>
                  <span class="badge badge-bb">Drama</span>
               </div>
            </div>
       
         </div>
      </div>
   </section>
   <section class="mobile-app-bg  pb-1" id="mobile-app">
      <div class="col-sm-12">
          <div class="row">
         <div class="col-lg-6 offset-lg-2 col-md-12 cstm_pt sm-text-center">
             <h3 class="font-size-xl text-color-white font-primary pb-3">Se Straks Online</h3>
             <p class="text-justify text-color-primary font-size-md mb-5 font-primary-book text-color-white ">
             Stream, se & administrer din konto, når du er på farten <br>med BestBox mobil app!
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
            <div class="col-lg-7 col-md-12 cstm_pt2 sm-text-center">
               <h1 class="font-size-xxxl text-color-dark font-title pb-4">IPTV BOX</h1>
               <h3 class="font-size-xl text-color-purple font-primary pb-3">Se på dit TV</h3>
               <div class="col-lg-8">
               <p class="font-primary-book font-size-md text-color-primary ">
               Stream & se TV i HD-kvalitet med BestBox TV Box komfortabelt i dit hjem.
               </p>
               </div>
               
            </div>
       
      </div>
      </div>


<!-- Free Trial Section Start Here -->
      <section>
         <div class="container bb_width-md pt-5" style="position: relative;">

            <!-- Desktop View -->
            <div class="free_trial_section danish">
               <div class="col-md-6 offset-md-5">
                  <h1 class="h1_title">Start din gratis prøveperiode</h1>
                  <p class="p_text">For at begynde at nyde en lang række indhold og kanaler fra BestBOX</p>

                  <a href="<?php echo url('/customerLogin');?>" class="request_btn">Anmod om gratis prøveperiode</a>
               </div>
            </div>
            <img src="<?php echo url('/');?>/public/website/assets/images/free-trial-bg.png" class="img-fluid small_mblview">

            <!-- Mobile View -->
            <div class="freeTrial_mbl_section">
               <h1 class="h1_title">Start din gratis prøveperiode</h1>
                  <p class="p_text">For at begynde at nyde en lang række indhold og kanaler fra BestBOX</p>

                  <a href="<?php echo url('/customerLogin');?>" class="request_btn">Anmod om gratis prøveperiode</a>
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
                     <div class="text-color-purple font-size-sm font-primary mt-3 empty_space"> &nbsp</div>
                     <div class="text-color-orange fontSize font-title mt-4">USD$79.99</div>
                     <div class="content_fontSize text-color-primary pt-3">
                     Bare plug & play til dit TV, inkluderer forudinstalleret app, fjernbetjening & HDMI- kabel + Verdensomspændende levering.
                        <!-- <br>&nbsp -->
                     </div>
                     <div class="text-center mt-4">
                        <a href="<?php echo url('customerLogin'); ?>" class="btn-rounded btn-orange text-white">Køb nu</a>
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
                           <p class="text-white font-size-sm font-primary">+ 1 måneders abonnement</p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ 1 måneders abonnement</div>
                        <div class="text-color-purple fontSize font-title mt-4">USD$99.99</div>
                        <div class="content_fontSize text-color-primary pt-3">Bare plug & play til dit TV, inkluderer forudinstalleret app & 
                           <span class="text-color-purple font-primary">1 måneders abonnement</span> + Verdensomspændende levering.
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">Køb nu</a>
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
                           <p class="text-white font-size-sm font-primary">+ 3 måneder abonnement</p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ 3 måneder abonnement</div>
                        <div class="text-color-purple fontSize font-title mt-4">USD$149.99</div>
                        <div class="content_fontSize text-color-primary pt-3">Bare plug & play til dit TV, inkluderer forudinstalleret app &  
                           <span class="text-color-purple font-primary">3 måneder abonnement</span> + Verdensomspændende levering.
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">Køb nu</a>
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
                           <p class="text-white font-size-sm font-primary">+ 6 måneder abonnement</p>
                        </div>
                     </div>
                     <div class="box_buy_body text-center py-5">
                        <img src="/public/website/assets/images/bbox_decorder_small.png" class="img-fluid" />
                        <div class="text-color-purple font-size-xs font-primary mt-3">+ 6 måneder abonnement</div>
                        <div class="text-color-purple fontSize font-title mt-4">USD$229.99</div>
                        <div class="content_fontSize text-color-primary pt-3">Bare plug & play til dit TV , inkluderer forudinstalleret app &  
                           <span class="text-color-purple font-primary">6 måneder abonnement</span> + Verdensomspændende levering.
                        </div>
                        <div class="text-center mt-4">
                           <a href="<?php echo url('customerLogin'); ?>" class="text-white btn-rounded btn-purple">Køb nu</a>
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
                        <p class="text-white font-size-sm font-primary">+ 12 måneder abonnement</p>
                     </div>
                  </div>
                  <div class="box_buy_body text-center py-5">
                     <img src="/public/website/assets/images/bbox_decorder_small.png"
                        class="img-fluid" />
                     <div class="text-color-purple font-size-xs font-primary mt-3">+ 12 måneder abonnement</div>
                     <div class="text-color-purple fontSize font-title mt-4">USD$349.99</div>
                     <div class="content_fontSize text-color-primary pt-3">Bare plug & play til dit TV , inkluderer forudinstalleret app &
                        <span class="text-color-purple font-primary">12 måneder abonnement</span> + Verdensomspændende levering.
                     </div>
                     <div class="text-center mt-4">
                        <a href="<?php echo url('customerLogin'); ?>"
                           class="text-white btn-rounded btn-purple">Køb nu</a>
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
            <h1 class="font-size-xxxl font-title text-white mb-3">Tilmeld nu</h1>
            <p class="font-size-md pb-4 font-title text-white">Abonnementerne nedenfor inkluderer ikke TV Box.</p>
         </div>
         <div class="subscribe_features">
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>Full HD & SD Kvalitet</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>Øjeblikkelig aktivering</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>Ingen regionale restriktioner</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>99,9% Uptime</div>
            <div class="subscribe_features_list"><span class="mr-3"><img src="/public/website/assets/images/tick.png"
                     class="img-fluid" style="width: 41px; height: 37px;" /></span>24/7 Support</div>
         </div>
         <div class="text-center mt-5 mb-3 text-white font-primary-book font-size-md">
            Vi accepterer <span class="font-primary"> USD $ & valgte cryptocurrency!</span>
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
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">1 måned</div>
                  <img src="/public/website/assets/images/bbox1.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        USD</div>
                     <div class="subscription_pack_offer_actual_price">&nbsp</div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-xl text-center text-color-purple mt-2">
                        $34.99</div>
                     <div class="subscription_pack_offer_saving pb-2">&nbsp</div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">Tilmeld</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_3m">
                  <!-- <span class="ribbon ribbon-purple d-none f14">FREE</span> -->
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">3 måneder</div>
                  <img src="/public/website/assets/images/bbox3.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        USD</div>
                     <div class="subscription_pack_offer_actual_price">$103.97<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-xl text-center text-color-purple mt-2">
                        $89.99</div>
                     <div class="subscription_pack_offer_saving mb-2">SAVE <span>$14.98</span></div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">Tilmeld</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_6m">
                  <span class="ribbon ribbon-purple f14">Mest <br> populære</span>
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">6 måneder</div>
                  <img src="/public/website/assets/images/bbox6.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        USD</div>
                     <div class="subscription_pack_offer_actual_price">$209.94<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-xl text-center text-color-purple mt-2">
                        $169.99</div>
                     <div class="subscription_pack_offer_saving">SPAR <span>$39.95</span></div>
                  </div>
               </div>
               <a  href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">Tilmeld</a>
            </div>
            <div class="w-xl-20 col-9 col-sm-6 col-md-4 mb-3 mx-auto">
               <div class="subscription_pack subscription_pack_12m">
                  <span class="ribbon ribbon-purple f14">Best<br>Value</span>
                  <i class="fas fa-info-circle info_btn info_btn_align" data-toggle="modal" data-target="#imp-note"></i>
                  <div class="text-color-purple font-size-xs font-primary mb-4 text-center">12 måneder</div>
                  <img src="/public/website/assets/images/bbox12.png" class="img-fluid" />
                  <div class="subscription_pack_offer mt-4">
                     <div
                        class="subscription_pack_offer_currency font-size-xs font-primary text-color-purple text-center">
                        USD</div>
                     <div class="subscription_pack_offer_actual_price">$419.88<span class="cancel-line"></span></div>
                     <div
                        class="subscription_pack_offer_final_price font-title font-size-xl text-center text-color-purple mt-2">
                        $299.99</div>
                     <div class="subscription_pack_offer_saving">SPAR <span>$119.89</span></div>
                  </div>
               </div>
               <a href="<?php echo url('customerLogin'); ?>" class="subscription_pack_btn subscription_pack_btn_purple text-center text-white d-block">Tilmeld</a>
            </div>
         </div>
      </div>
   </section>
   <section class="refer pt-0 pb-5" id="refer">
      <div class="container bb_width pt-4">
         <div class="row mb-3">
            <div class="col-md-8 offset-md-2 col-sm-12  col-xl-6 offset-xl-6 refer_mobile_padding">
               <h1 class="font-size-xxl font-title text-color-dark mt-5 mb-3 pt-5 text-center">Henvis til dine venner</h1>
               <p class="text-justify text-color-primary font-size-md mb-5 pb-5 font-primary-book">Henvis Bestbox til dine venner. Du vil blive belønnet med Formidlingsbonus efter at de med succes har abonneret.
               </p>
               <div class="referral_card text-center mt-5 w80 mx-auto">
                  <div class="referral_card_head font-size-xl font-title text-white">
                     USD $10.00
                  </div>
                  <div class="referral_card_body font-size-md w80 mx-auto">
                        For hver ven du henviser, der abonnerer på BestBox.
                  </div>
                  <a class="referral_card_btn" href="<?php echo url('customerLogin'); ?>">
                  Henvis din ven!
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
               Referral Bonus
            </div>
            <div class=" referal_cell_body referal_table_wrap_head_2 w30 text-right">
               Balance
            </div>
         </div>
         <!-- body -->
         <div class="referal_border">
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
                     Henvist 1 ven
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
                  $10.00
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
                  $10.00
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
                     Henvist 2 ven
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
                  $10.00
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
                  $20.00
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
                     Henvist 3 ven
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
                  $10.00
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
                  $30.00
               </div>
            </div>
            <div class="referal_table_wrap_body">
               <div class="referal_cell_body referal_table_wrap_body_1 w40 bordered-right">
                     Henvist 4 ven
               </div>
               <div class="referal_cell_body referal_table_wrap_body_2 w30 text-right bordered-right">
                  $10.00
               </div>
               <div class=" referal_cell_body referal_table_wrap_body_3 w30 text-right">
                  $40.00
               </div>
            </div>
         </div>
         <!-- footer -->
         <div class="referal_table_wrap_footer">
            <div class="referal_cell_footer referal_table_wrap_footer_blank w40">
            </div>
            <div class="referal_cell_footer referal_table_wrap_footer_1 w30 text-right">
               Total
            </div>
            <div class=" referal_cell_footer referal_table_wrap_footer_2 w30 text-right font-size-md text-color-orange">
               $40.00
            </div>
         </div>
         <div class="text-right mt-3 font-size-sm">You’ll be able to <span class="text-color-orange font-primary">Indløs for 1
               month abonnement!</span></div>
         <div class="mt-5 pt-5 text-center font-secondary font-size-lg">
               Du kan vælge at dele dine <span class="text-color-purple">Henvisning Bonus</span>
               med din ven eller indløse din <span class="text-color-purple font-secondary-bold">Henvisning Bonus</span> til dit BestBox abonnement.
         </div>
         <!-- <div class="font-primary-book font-size-md text-center mt-4">
               Flere indløsning partnere vil blive tilføjet snart
         </div> -->
         <div class="row">
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                     USD $34, 99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                        Indløs til <span class="text-color-purple font-primary">1 måned</span> af BestBox abonnement 
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>">
                        Indløs
                  </a>
               </div>
            </div>
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                     USD $89, 99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                     Indløs til <span class="text-color-purple font-primary">3 måneder</span> af BestBox abonnement
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>">
                     Indløs
                  </a>
               </div>
            </div>
            <div class="col-md-4 col-9 mx-auto">
               <div class="referral_card_purple text-center mt-5 mx-auto">
                  <div class="referral_card_purple_head font-title text-white">
                     USD $169, 99
                  </div>
                  <div class="referral_card_purple_body w80 mx-auto">
                     Indløs til <span class="text-color-purple font-primary">6 måneder</span> af BestBox abonnement
                  </div>
                  <a class="referral_card_purple_btn" href="<?php echo url('customerLogin'); ?>">
                     Indløs
                  </a>
               </div>
            </div>
         </div>
      </div>
   </section>

   <section class="pb-5 mb-5" id="join-reseller">
      <div class="container bb_width-md pt-5">
         <h1 class="font-size-xxxl text-color-dark text-center font-title pb-4">Tilmeld dig vores forhandler program</h1>
         <div class="font-primary-book font-size-md text-color-primary text-left">
         <p class="pb-3">
               Vores BestBox forhandler program sigter mod at hjælpe dig med at få så mange salg som muligt. 
               Det er let at bruge et online intuitiv forhandler-panel, hvor du har live adgang til alle oplysninger.
            </p>
            <p class="pb-3">
                  Som pioner inden for markedet, forstår vi vores kunders behov & krav, og vi er her for at hjælpe dig til at 
                  være så vellykket som muligt, fordi din succes er lig med vores succes.
            </p>
            <p class="pb-3">
                  Vi håndterer alt for dig, herunder salgsprocessen, levering, support og provision udbetaling - 
                  alt du skal gøre er bare at sælge! Ingen opstarts investering eller opstarts gebyr kun en øjeblikkelig gevinst.
            </p>
            <p>
                  Du skal blot åbne en gratis forhandler konto og se det overbevisende BestBox forhandler program så åbner muligheden sig for en månedlig indkomst. Kontakt os via reseller@bestbox.net for henvedelse af enhver karakter.
            
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
@include('website_danish.inc.footer')

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