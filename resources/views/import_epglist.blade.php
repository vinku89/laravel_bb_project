<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Import EPG List</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
    @include("inc.styles.all-styles")
    <style type="text/css">
        .org-txt {
            color: #FA6400;
        }
        .select2-selection.select2-selection--single{
            height: 40px !important;
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
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">EPG List</h5>
            <div class="blue_bg p-3 mb-3">
                <h5 class="f22 font-bold text-uppercase black_txt py-2 text-center text-sm-left">EPG List File</h5>
                <div class="text-center f14">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <span style="color: #721c24;">Please fill all the mandatory fields</span><br/>
                        {{ strip_tags(str_replace("'",'',$errors->first())) }}
                    </div>
                @endif
                @if(Session::has('message'))
                    <div class="error-wrapper {{ (Session::get('alert') == 'Success') ? 'badge-success' : 'badge-danger' }} badge my-2">
                        {{ Session::get('message') }}
                    </div>
                @endIf
                </div>
                <form class="py-2" action="<?php echo url('/');?>/save_epg_list" method="post" id="upload_epg_list" enctype="multipart/form-data">
                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                    <div class="form-group row col-8">
                        <div class="col-3">
                            <label for="imageInput">Epg List File</label>
                        </div>
                        <div class="col-8">
                            <input name="epg_list_file" type="file" id="epg_list_file" accept="text/xml" required style="line-height: 23px;padding: 5px;">
                            <p class="help-block">upload .xml format only</p>
                        </div>
                    </div>
                    <div class="form-group row col-8">
                        <div class="col-3">
                            <label for="imageInput">Country</label>
                        </div>
                        <div class="col-8">
                            <select class="form-control select_css" id="country_id" name="country_id" required>
                                <option value="">Select Country</option>
                                <?php
                                if(!empty($countryList)){
                                    foreach($countryList as $cnt){?>
                                        <option value="<?php echo $cnt->id;?>"><?php echo $cnt->name;?></option>
                                <?php }
                                }?>
                            </select>
                        </div>
                    </div>

                    <div class="my-4 px-lg-3">
                        <button type="submit" id="save_epg_list" class="btn btn-blue">Submit</button>
                    </div>
                </form>
            </div>
        </section>
    </div>


    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")
    <script>
        $('.select_css').select2();
        $("#epg_list_file").change(function(e){
            var value = $(this).value;
            var res = value.substr(value.lastIndexOf('.')) == '.xml';
                if (!res) {
                    input.value = "";
                }
            return res;
        });
    </script>
    <?php
        if(Session::has('alert') && Session::get('alert') == 'Failure'){
    ?>
        <script type="text/javascript">
            swal(
                'Failure',
                '<?php echo Session::get('error');?>',
                'error'
            )
        </script>
    <?php
        }
    ?>

    <?php
        if(Session::has('alert') && Session::get('alert') == 'Success'){
    ?>
        <script type="text/javascript">
            swal(
                'Success',
                '<?php echo Session::get('message');?>',
                'success'
            )
        </script>
    <?php
        }
    ?>

</body>
</html>
