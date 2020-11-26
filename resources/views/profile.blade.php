<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Profile</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->

        @if($userInfo['user_role'] == 4)
           @include("customer.inc.all-styles")
        @else
            @include("inc.styles.all-styles")
        @endIf


    <!-- Croppie css -->
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.2/croppie.min.css">
    <style type="text/css">

    .select2-container--default .select2-selection--single{
            background-color:transparent !important;
            border:none !important;
            border-bottom: solid 3px #7f868b !important;
            border-radius: 0;
        }
        .select2-container .select2-selection--single{
            height:33px !important;
        }
        .select2-selection__rendered[title="Select Country"]{
            font-size:14px !important;
            color: #737a82 !important;
        }

        .select2-container[dir="ltr"]{
            width:100% !important;
        }

    .main_body_section{
        background: #F7FBFF;
    }
    .nounderline, .violet{
        color: #7c4dff !important;
    }
    .btn-dark {
        /* background-color: #7c4dff !important;
        border-color: #7c4dff !important; */
    }
    .btn-dark .file-upload {
        width: 100%;
        padding: 10px 0px;
        position: absolute;
        left: 0;
        opacity: 0;
        cursor: pointer;
    }
    .profile-img {
        width: 150px !important;
        height: 150px !important;
    }

    .profile-img img{
        border-radius: 50%;
    }

    .dk-option{
        padding-top:3px !important;
        padding-bottom:3px !important;
        font-size: 14px;
    }
    .border-bottom-only{
        font-weight:bold !important;
    }
    .body_bg .dk-select-options{
        min-height:100px !important;
        max-height:200px !important;
    }
    .mw-500 {
        max-width: 550px;
        width: 100%;
    }
    </style>
</head>

<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content">
        <!-- Header Section Start Here -->
        @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">
            <h5 class="font22 font-bold text-uppercase black_txt p-3 pt-4 text-center text-md-left">Profile</h5>
            <div class="clearfix mb-4">
                <div class="mw-500">
                    <form action="<?php echo url('updateProfileImage');?>" id="updateProfileImageForm" name="updateProfileImageForm" method="post" enctype="multipart/form-data">
                        <div class="container-fluid">
                            <div class="profile_pic row">
                                <div class="col-md-6 col-lg-6 col-xl-5 p-2">
                                    <div class="text-center text-md-left">
                                        <div class="card-body px-0 py-0 py-md-4">
                                            <div class="profile-img p-0 m-auto">
                                                <img src="<?php echo url('public/profileImages/').'/'.$userInfo['profile_image'];?>" id="profile-pic" class="img-fluid">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6 col-lg-6 col-xl-7 p-2">
                                    <div class="text-center text-md-left py-0 py-md-4">
                                    <div class="my-2"> Account Status</div>
                                    <div class="my-2">Date of Join : <strong><?php echo date("d/m/Y, h:i a",  strtotime($userInfo['registration_date']));?> </strong></div>
                                    <div class="my-2">Membership : <strong class="text-uppercase">
                                        <?php if($userInfo['user_role'] == 1) {echo 'SUPER ADMIN';}
                                        else if($userInfo['user_role'] == 2) {echo 'RESELLER';}
                                        else if($userInfo['user_role'] == 3) {echo 'AGENT';}
                                        else if($userInfo['user_role'] == 4) {echo 'CUSTOMER';}
                                        else echo '-';?></strong></div>

                                    <div class="btn btn-dark" >
                                            <input type="file" class="file-upload" id="file-upload" name="profile_picture"
                                            accept="image/*">
                                            Change Photo
                                            <input type="hidden" id="profile_img_type" value="old"/>
                                        </div>
                                        <div class="f14 my-2 my-lg-1">
                                            Format accepted .jpeg / .jpg / .png.
                                            File size must not more than 2MB
                                        </div>
                                    </div>
                                </div>
                                <!-- The Modal -->
                                <div class="modal" id="myModal">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <!-- Modal Header -->
                                            <div class="modal-header">
                                                <h4 class="modal-title">Crop Image And Upload</h4>
                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                            </div>
                                            <!-- Modal body -->
                                            <div class="modal-body">
                                                <div id="resizer"></div>
                                                <button class="btn rotate float-lef" data-deg="90">
                                                    <i class="fas fa-undo"></i></button>
                                                <button class="btn rotate float-right" data-deg="-90">
                                                    <i class="fas fa-redo"></i></button>
                                                <hr>
                                                <button class="btn btn-block btn-dark" id="upload">
                                                    Crop And Upload</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="text-center f14">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ strip_tags(str_replace("'",'',$errors->first())) }}
                            </div>
                        @endif
                        @if(Session::has('message'))
                            <div class="error-wrapper {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2">
                                {{ Session::get('message') }}
                            </div>
                        @endIf
                    </div>
                    <form action="{{ url('/').'/updateProfile' }}" id="updateProfileForm" name="updateProfileForm" method="post" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <div class="clearfix">

                            <!-- User ID -->
                            <?php
                                if($userInfo['user_role'] == 4){
                            ?>
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                        placeholder="Account Name" aria-label="Name" aria-describedby="basic-addon2"
                                        value="<?php echo $userInfo['user_id'];?>" readonly>
                                    <div class="text-right f14 w-100 pt-2">
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">User ID</span>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                            <!-- Account Name -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                        placeholder="Account Name" aria-label="Name" aria-describedby="basic-addon2"
                                        value="<?php echo $userInfo['first_name'].' '.$userInfo['last_name'];?>" readonly>
                                    <div class="text-right f14 w-100 pt-2">
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Account Name</span>
                                    </div>
                                </div>
                            </div>

                            <!-- First Name -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg lettersOnly"
                                        placeholder="First Name" aria-label="Name" aria-describedby="basic-addon2"
                                        value="<?php echo $userInfo['first_name'];?>" name="first_name" id="first_name" >
                                        <div class="text-right f14 w-100 pt-2">
                                        <span id="firstnameErrMsg" class="f14 error_txt"></span>
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">First Name</span>
                                        </div>
                                        <div class="error" id="first_name_err"></div>
                                </div>
                            </div>

                            <!-- Last Name -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg lettersOnly"
                                        placeholder="Last Name" aria-label="Name" aria-describedby="basic-addon2"
                                        value="<?php echo $userInfo['last_name'];?>" name="last_name" id="last_name" >
                                        <div class="text-right f14 w-100 pt-2">
                                        <span id="lastnameErrMsg" class="f14 error_txt"></span>
                                        <span class="text-danger">*</span>
                                        <span id="emailHelp" class="text-muted f14 black_txt">Last Name</span>
                                        </div>
                                        <div class="error" id="last_name_err"></div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                        placeholder="Email" aria-label="Email ID" aria-describedby="basic-addon2"
                                        value="<?php echo $userInfo['email'];?>" name="email" id="email" readonly>
                                    <div class="text-right f14 w-100 pt-2"><span class="text-danger">*</span><span
                                            id="emailHelp" class="text-muted f14 black_txt">Email ID</span></div>
                                </div>
                            </div>

                            <!-- Gender -->
                            <div class="mobile_menu_section body_bg form-group">
                                <select class="normal_select" name="gender">
                                    <option value="">Select Gender</option>
                                    <option value="Male" <?php if($userInfo->gender == "Male") echo 'selected';?>>Male</option>
                                    <option value="Female" <?php if($userInfo->gender == "Female") echo 'selected';?>>Female</option>
                                </select>
                                <div class="text-right f14 pt-2"><span id="genderErrMsg" class="f14 error_txt"></span><span class="text-danger"></span><span id="emailHelp"
                                        class="text-muted f14 black_txt">Gender</span></div>
                            </div>

                            <!-- Status -->
                            <!-- <div class="mobile_menu_section body_bg form-group">
                                <select id="normal_select1" name="married_status">
                                    <option value="">Martial Status</option>
                                    <option value="Married" <?php //if($userInfo->married_status == "Married") echo 'selected';?>>Married</option>
                                    <option value="Single" <?php //if($userInfo->married_status == "Single") echo 'selected';?>>Single</option>
                                </select>
                                <div class="text-right f14 pt-2"><span id="martialErrMsg" class="f14 error_txt"></span><span class="text-danger"></span><span id="emailHelp"
                                        class="text-muted f14 black_txt">Status</span></div>
                            </div> -->
                            @if($userInfo->user_role == 40)
                                <div id="shipping_details">
                                    <!-- Address -->
                                    <div class="text-center my-2 f14 font-bold color-black">SHIPPING ADDRESS</div>
                                    <!-- Address Line 1 -->
                                    <div class="form-group">
                                        <input type="name" class="form-control border-bottom-only body_bg" id="shipping_address1" name="shipping_address1"
                                            aria-describedby="emailHelp" placeholder="Address Line 1" value="{{ $userInfo->shipping_address1 }}">
                                        <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                                class="text-muted f14 black_txt">Shipping Address Line 1</span></div>
                                    </div>
                                    <!-- Address Line 2 -->
                                    <div class="form-group">
                                        <input type="address" class="form-control border-bottom-only body_bg" id="shipping_address2" name="shipping_address2"
                                            aria-describedby="emailHelp" placeholder="Address Line 2"
                                            value="{{ $userInfo->shipping_address2 }}">
                                        <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                                class="text-muted f14 black_txt">Shipping Address Line 2</span></div>
                                    </div>
                                    <!-- Pin code -->
                                    <div class="form-group">
                                        <input type="text" class="form-control border-bottom-only body_bg" id="shipping_zipcode"  name="shipping_zipcode"
                                            aria-describedby="emailHelp" placeholder="ZIP/Postal" value="{{ $userInfo->shipping_zipcode }}">
                                        <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                                class="text-muted f14 black_txt">ZIP code</span></div>
                                    </div>

                                    <!-- Country -->
                                    <div class="mobile_menu_section body_bg form-group">
                                        <select id="shipping_country" class="select_css" name="shipping_country">
                                            <option value="">Select Country</option>
                                            <?php
                                            foreach ($countries as $val) {?>
                                                <option value='<?php echo $val->countryid;?>' data-id='<?php echo $val->currencycode;?>' <?php if($val->countryid == $userInfo->shipping_country) {echo 'selected';} ;?>><?php echo $val->country_name;?></option>;
                                        <?php }?>
                                        </select>
                                        <div class="text-right f14"><span class="text-danger">*</span><span id="emailHelp"
                                                class="text-muted f14 black_txt">Country</span></div>
                                    </div>


                                    <!-- Mobile Number -->
                                    <div class="form-group row">
                                        <div class="col-3">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                                    placeholder="+0" aria-label="Country Code"
                                                    aria-describedby="basic-addon2" value="{{ $userInfo->shipping_country_code }}" name="shipping_country_code" id="shipping_country_code" readOnly>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                                    placeholder="Mobile Number" aria-label="Mobile number"
                                                    aria-describedby="basic-addon2" id="shipping_user_mobile_no" name="shipping_user_mobile_no" value="{{ $userInfo->shipping_telephone }}" >
                                                <div class="text-right f14 w-100 pt-2">
                                                    <span id="telErrorMsg" class="f14 error_txt"></span>
                                                    <span class="text-danger">*</span><span id="emailHelp"
                                                        class="text-muted f14 black_txt">Mobile number</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Pin code -->
                                    <div class="form-group" style="position: relative;">
                                        <input type="checkbox" class="form-check-input ml-0" id="same_address"  name="same_address" value="1" >
                                        <div class="text-left f14 ml-4">
                                            <span id="emailHelp" class="text-muted f14 black_txt">
                                                Address same as shipping Address
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endIf

                            @if($userInfo->user_role == 4)
                            <div class="form-group">
                                <label for="exampleInputEmail1" class="font-bold black_txt">Address</label>
                                <textarea id="shipping_address" name="shipping_address" rows="10" data-sample-short>{{ $userInfo['shipping_address'] }}</textarea>
                                <div class="f12" style="color:red" id="shipAddrErr"></div>
                            </div>
                            @else

                            <!-- Address -->
                            <div class="text-center my-2 f14 font-bold common_txt">ADDRESS</div>
                            <!-- Address Line 1 -->
                            <div class="form-group">
                                <input type="name" class="form-control border-bottom-only body_bg" id="address"
                                    aria-describedby="emailHelp" placeholder="Address Line 1" value="<?php echo $userInfo['address'];?>" name="address" id="address">
                                <div class="text-right f14"><span id="addrErrorMsg" class="f14 error_txt"></span>
                                    <!-- <span class="text-danger">*</span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt">Address Line 1</span></div>
                            </div>
                            <!-- Address Line 2 -->
                            <div class="form-group">
                                <input type="address" class="form-control border-bottom-only body_bg" id="address2"
                                    aria-describedby="emailHelp" placeholder="Address Line 2"
                                    value="<?php echo $userInfo['address2'];?>" name="address2" id="address2">
                                <div class="text-right f14"><span id="addr2ErrorMsg" class="f14 error_txt"></span>
                                    <!-- <span class="text-danger">*</span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt">Address Line 2</span></div>
                            </div>
                            <!-- Pin code -->
                            <div class="form-group">
                                <input type="text" class="form-control border-bottom-only body_bg " id="zipcode"
                                    aria-describedby="emailHelp" placeholder="ZIP/Postal"  value="<?php echo $userInfo['zipcode'];?>" name="zipcode" id="zipcode">
                                <div class="text-right f14 t-2"><span id="zipcodeErrMsg" class="f14 error_txt"></span>
                                    <!-- <span class="text-danger">*</span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt">ZIP code</span></div>
                            </div>
                            @endIf
                            <!-- Country -->
                            <div class="mobile_menu_section body_bg form-group">
                                <select id="select_country" class="select_css" name="country">
                                    <option value="">Select Country</option>
                                    <?php foreach($countries as $country){?>
                                        <option value="<?php echo $country["countryid"];?>" data-id="<?php echo $country["currencycode"];?>" <?php if($country["countryid"]== $userInfo['country_id']) echo "selected";?>><?php echo $country["country_name"];?></option>
                                    <?php }?>
                                </select>
                                <div class="text-right f14 pt-2"><span id="countryErrMsg" class="f14 error_txt"></span>
                                    <!-- <span class="text-danger">*</span> -->
                                    <span id="emailHelp" class="text-muted f14 black_txt">Country</span></div>
                            </div>

                            <!-- Mobile Number -->
                            <div class="form-group row">
                                <div class="col-3 pr-0">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                            placeholder="Code" aria-label="Country Code"
                                            aria-describedby="basic-addon2" value="<?php echo $userInfo['country_code'];?>" name="country_code" id="country_code" readOnly>
                                    </div>
                                </div>
                                <div class="col-9">
                                    <div class="input-group mb-3">
                                        <input type="text" class="form-control border-bottom-only with_addon_icon body_bg"
                                            placeholder="Mobile Number" aria-label="Mobile number"
                                            aria-describedby="basic-addon2" id="telephone" name="telephone" value="<?php echo $userInfo['telephone'];?>">
                                        <div class="text-right f14 w-100 pt-2">
                                            <span id="telErrorMsg" class="f14 error_txt"></span>
                                            <!-- <span class="text-danger">*</span> -->
                                            <span id="emailHelp" class="text-muted f14 black_txt">Mobile number</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        @if($userInfo->user_role == 2 || $userInfo->user_role == 3)
                        <!-- BANK ACCOUNT -->
                        <div class="text-center my-2 f14 font-bold blue_txt">BANK ACCOUNT</div>
                        <!-- Bank Name -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Bank Name" name="bank_name" id="bank_name" value="<?php echo $bankDetails['bank_name'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Bank Name</span></div>
                        </div>
                        <!-- Bank Holder -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Bank Holder" name="bank_holder" id="bank_holder"
                                value="<?php echo $bankDetails['bank_holder'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Bank Holder</span></div>
                        </div>

                        <!-- Account Number -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Account Number" name="account_number" id="account_number" value="<?php echo $bankDetails['account_number'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Account Number / IBAN</span></div>
                        </div>

                        <!-- Swift / BIC Codes -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Swift / BIC Codes" name="swift_code" id="swift_code"
                                value="<?php echo $bankDetails['swift_code'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Swift / BIC Codes</span></div>
                        </div>

                        <!-- Address Line 1 -->
                        <div class="form-group">
                            <input type="name" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Address Line 1" name="bank_address_one" id="bank_address_one"  value="<?php echo $bankDetails['bank_address_one'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Address Line 1</span></div>
                        </div>
                        <!-- Address Line 2 -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Address Line 2" name="bank_address_two" id="bank_address_two"
                                value="<?php echo $bankDetails['bank_address_two'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Address Line 2</span></div>
                        </div>

                        <!-- Country -->
                        <div class="mobile_menu_section body_bg form-group">
                            <select id="select_country2" class="select_css" name="bank_country">
                                <option value="">Select Country</option>
                                <?php foreach($countries as $country){?>
                                    <option value="<?php echo $country["countryid"];?>" <?php if($country["countryid"]== $bankDetails['country']) echo "selected";?> ><?php echo $country["country_name"];?></option>
                                <?php }?>
                            </select>
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">Country</span></div>
                        </div>

                        <!-- State -->
                        <div class="form-group">
                            <input type="address" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="State" name="state" id="state"
                                value="<?php echo $bankDetails['state'];?>">
                            <div class="text-right f14"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">State</span></div>
                        </div>

                         <!-- Pin code -->
                         <div class="form-group">
                            <input type="text" class="form-control border-bottom-only body_bg" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="ZIP/Postal" name="bank_zip_code" id="bank_zip_code" value="<?php echo $bankDetails['zip_code'];?>">
                            <div class="text-right f14 t-2"><!-- <span class="text-danger">*</span> --><span id="emailHelp"
                                    class="text-muted f14 black_txt">ZIP code</span></div>
                        </div>

                        <!-- CRYPTO WALLET -->
                        <div class="text-center my-2 f14 font-bold blue_txt ">CRYPTO WALLET</div>
                        <!-- Tru WALLET -->
                        <div class="form-group position-relative body_bg">
                            <input type="name" class="form-control border-bottom-only body_bg pr-5" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="TRU-e Wallet" value="<?php echo $userInfo['true_address'];?>" name="true_address" id="true_address" >
                                <!-- <span style="position: absolute; right: 10px; padding-left: 100px; top: 3px;">
                                <a href=""> <img src="<?php // echo url('/').'/public/images/profile_qr.png';?>" class="img-fluid"></a></span> -->
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">My TRU-e Wallet</span> <span class="ml-2" ><img src="<?php echo url('/').'/public/images/truliionicon.png';?>" class="img-fluid"></span></div>
                        </div>

                        <!-- Everus WALLET -->
                        <div class="form-group position-relative body_bg">
                            <input type="name" class="form-control border-bottom-only body_bg pr-5" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Everus Wallet" value="<?php echo $userInfo['evr_address'];?>" name="evr_address" id="evr_address" >
                                <!-- <span style="position: absolute; right: 10px; padding-left: 100px; top: 3px;">
                                <a href=""> <img src="<?php // echo url('/').'/public/images/profile_qr.png';?>" class="img-fluid"></a></span> -->
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">My Everus Wallet</span><span class="ml-2" ><img src="<?php echo url('/').'/public/images/everus.png';?>" class="img-fluid"></span></div>
                        </div>

                        <!-- CRYPTO WALLET -->
                        <div class="form-group position-relative body_bg">
                            <input type="name" class="form-control border-bottom-only body_bg pr-5" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Bitcoin Wallet" value="<?php echo $userInfo['btc_address'];?>" name="btc_address" id="btc_address">
                                <!-- <span style="position: absolute; right: 10px; padding-left: 100px; top: 3px;">
                                <a href="#"> <img src="<?php // echo url('/').'/public/images/profile_qr.png';?>" class="img-fluid"></a></span> -->
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">My Bitcoin Wallet</span><span class="ml-2" ><img src="<?php echo url('/').'/public/images/bitcoinicon.png';?>" class="img-fluid"></span></div>
                        </div>

                        <!-- CRYPTO WALLET -->
                        <div class="form-group position-relative body_bg">
                            <input type="name" class="form-control border-bottom-only body_bg pr-5" id="exampleInputEmail1"
                                aria-describedby="emailHelp" placeholder="Ethereum Wallet" value="<?php echo $userInfo['eth_address'];?>" name="eth_address" id="eth_address">
                                <!-- <span style="position: absolute; right: 10px; padding-left: 100px; top: 3px;">
                                <a href=""> <img src="<?php // echo url('/').'/public/images/profile_qr.png';?>" class="img-fluid"></a></span> -->
                            <div class="text-right f14"><span id="emailHelp"
                                    class="text-muted f14 black_txt">My Ethereum Wallet</span><span class="ml-2" ><img src="<?php echo url('/').'/public/images/ethereumicon.png';?>" class="img-fluid"></span></div>
                        </div>
                        @endIf

                        <div class="my-4">
                            <div class="display_inline">
                                <a href="{{ url('/').'/dashboard' }}" class="btn_cancel">CANCEL</a>
                            </div>

                            <div class="display_inline">
                                <button type="submit" class=" btn_primary  d-block w-100 mt-4 " id="update_customer" >SAVE</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
    </div>
     <!-- Success Model -->
     <div class="modal fade" id="successModel" tabindex="-1" role="dialog" aria-labelledby="deleteUser" aria-hidden="true" data-backdrop="static" data-keyboard="false">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header no-border">
                        <h5 class="modal-title font-bold black_txt text-uppercase f20" id="exampleModalLongTitle">
                            Confirmation</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" data-dismiss="modal" >
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body add_edit_user pb-4">
                        <div class="text-center f16 black_txt py-5 mb-5 " id="sucessMsg"></div>
                    </div>
                    <!-- footer buttons -->
                    <div class="inline-buttons">
                        <button type="button" class="btn inline-buttons-left cancel-btn"
                            data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn inline-buttons-right create-btn" data-dismiss="modal" id="OkBtn" >Ok</button>
                    </div>
                </div>
            </div>
        </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script type="text/javascript">

        $('.select_css').select2();


        function closeModal(){
            location.reload();
        }

        var token = "<?php echo csrf_token() ?>";
        // upload and crop image starts
        $(function() {
            var croppie = null;
            var el = document.getElementById('resizer');

            $.base64ImageToBlob = function(str) {
                // extract content type and base64 payload from original string
                var pos = str.indexOf(';base64,');
                var type = str.substring(5, pos);
                var b64 = str.substr(pos + 8);

                // decode base64
                var imageContent = atob(b64);

                // create an ArrayBuffer and a view (as unsigned 8-bit)
                var buffer = new ArrayBuffer(imageContent.length);
                var view = new Uint8Array(buffer);

                // fill the view, using the decoded base64
                for (var n = 0; n < imageContent.length; n++) {
                  view[n] = imageContent.charCodeAt(n);
                }

                // convert ArrayBuffer to Blob
                var blob = new Blob([buffer], { type: type });

                return blob;
            }

            $.getImage = function(input, croppie) {
                if (input.files && input.files[0]) {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        croppie.bind({
                            url: e.target.result,
                        });
                    }
                    reader.readAsDataURL(input.files[0]);
                }
            }

            $("#file-upload").on("change", function(event) {
                $("#myModal").modal();
                // Initailize croppie instance and assign it to global variable
                croppie = new Croppie(el, {
                        viewport: {
                            width: 200,
                            height: 200,
                            type: 'circle'
                        },
                        boundary: {
                            width: 250,
                            height: 250
                        },
                        enableOrientation: true
                    });
                $.getImage(event.target, croppie);
            });

            $("#upload").on("click", function(e) {
                e.preventDefault();
                croppie.result('base64').then(function(base64) {
                    $("#myModal").modal("hide");
                    $("#profile-pic").attr("src","/images/ajax-loader.gif");
                    $("#profile-pic").attr("src", base64);
                    $("#profile_img_type").val("new");
                    var updateProfileImageform = new FormData($("#updateProfileImageForm")[0]);
                    updateProfileImageform.append('_token', "{{ csrf_token() }}");
                    updateProfileImageform.append("profile_picture", $.base64ImageToBlob(base64));

                    $.ajax({
                        type: 'POST',
                        url: "<?php echo url('/');?>/updateProfileImage",
                        data: updateProfileImageform,
                        processData: false,
                        contentType: false,
                        success: function(data) {
                            if (data.status == "Success") {
                                $("#profile-pic").attr("src", base64);
                            } else {
                                $("#profile-pic").attr("src","<?php echo url('public/profileImages/').'/'.$userInfo['profile_image'];?>");
                                //console.log(data['profile_picture']);
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            $("#profile-pic").attr("src","/images/icon-cam.png");
                        }
                    });
                });
            });

            // To Rotate Image Left or Right
            $(".rotate").on("click", function(e) {
                e.preventDefault();
                croppie.rotate(parseInt($(this).data('deg')));
            });

            $('#myModal').on('hidden.bs.modal', function (e) {
                e.preventDefault();
                // This function will call immediately after model close
                // To ensure that old croppie instance is destroyed on every model close
                setTimeout(function() { croppie.destroy(); }, 100);
            })
        });
            // upload and crop image ends

            $("#select_country").change(function(e) {
                var country_code =  $('option:selected', this).attr('data-id');

                if(country_code == undefined){
                    $("#country_code").val('');
                    $("#telephone").val('');
                }else{
                    $("#country_code").val('+'+country_code);
                }

            });

            $("#shipping_country").change(function(e) {
                var country_code =  $('option:selected', this).attr('data-id');
                $("#shipping_country_code").val('+'+country_code);
            });

            $("#same_address").change(function(e){
                $("#address").val();
                $("#address2").val();
                $("#zipcode").val();
                $("#select_country").val();
                $("#country_code").val();
                $("#telephone").val();
                $("#MySelectBox").val("5");

                var shipping_address1 = $("#shipping_address1").val();
                var shipping_address2 = $("#shipping_address2").val();
                var shipping_zipcode = $("#shipping_zipcode").val();
                var shipping_country = $("#shipping_country").val();
                var shipping_country_code = $("#shipping_country_code").val();
                var shipping_user_mobile_no = $("#shipping_user_mobile_no").val();
                if($(this).is(':checked')){
                    $("#address").val(shipping_address1);
                    $("#address2").val(shipping_address2);
                    $("#zipcode").val(shipping_zipcode);
                    $("#select_country").val(shipping_country).trigger('change');
                    $("#country_code").val(shipping_country_code);
                    $("#telephone").val(shipping_user_mobile_no);
                }else{
                    $("#address").val('');
                    $("#address2").val('');
                    $("#zipcode").val('');
                    $("#select_country").val('').trigger('change');;
                    $("#country_code").val('');
                    $("#telephone").val('');
                }
            });

            CKEDITOR.replace('shipping_address', {
                height: 150
            });

            $(".lettersOnly").on("keypress keyup blur",function (event) {
                var charCode = event.keyCode;

                if ((charCode > 64 && charCode < 91) || (charCode > 96 && charCode < 123) || charCode == 8 || charCode == 32)
                {
                    return true;
                }
                else
                {
                    return false;
                }
            });

            $("#update_customer").click(function(e){
                e.preventDefault();
                var first_name = $("#first_name").val();
                var last_name = $("#last_name").val();
                var letters = /^[A-Za-z\s]+$/;
                if(first_name == "" || first_name.length < 3){
                    $("#first_name_err").html("First Name required with atleast 3 characters.");
                    return false;
                }else if(!first_name.match(letters)){
                    $("#first_name_err").html("First Name allow characters only.");
                    return false;
                }
                else{
                    $("#first_name_err").html("");
                }
                if(last_name == "" || last_name.length < 3){
                    $("#last_name_err").html("Last Name required with atleast 3 characters.");
                    return false;
                }else if(!last_name.match(letters)){
                    $("#last_name_err").html("Last Name allow characters only.");
                    return false;
                }else{
                    $("#last_name_err").html("");
                }

                    $("#updateProfileForm").submit();

            });
        </script>
</body>

</html>
