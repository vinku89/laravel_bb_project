<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>BestBOX - Wallet Balance Report</title>
    <link rel="shortcut icon" href="<?php echo url('/public/images/');?>/favicon.png?q=<?php echo rand();?>" type="image/png" sizes="32x32" />
    <!-- All styles include -->
     @include("inc.styles.all-styles")
     <style type="text/css">
     	#sort_sel .dd-select{
     		border: 1px solid transparent !important;
            background-color: #F7FBFF !important;
            top: -15px !important;
            position: relative;

     	}
     	#sort_sel .dd-select.active{
            background: #fff !important;
            border: 1px solid #0096DA !important;
            border-radius: 5px !important;
     	}
     	.dd-selected-text{
     		text-align: center !important;
         }


     	.dd-selected{
            text-align: right !important;
            padding-right: 30px !important;
         }

        .dd-select.active .dd-selcted{
         }


         .dd-options{
            border: solid 1px #0096DA !important;
            border-top: none !important;
            list-style: none;
            box-shadow: none !important;
            display: none;
            position: absolute;
            z-index: 2000;
            margin: 0;
            padding: 0;
            background: #fff;
            overflow: auto;
            /* top: 40px !important; */
            border-radius: 0px 0px 5px 5px !important;
         }

         .sort-header{
             height: 60px !important;
         }

         .sort-header .dd-options{
            top: 37px !important;
         }

         .dd-option-selected{
             background-color: #0096DA;
         }
     </style>
</head>
<body>
    <!-- Side bar include -->
    @include("inc.sidebar.sidebar")
    <div class="main-content sales_transaction">
        <!-- Header Section Start Here -->
         @include("inc.header.header")
        <!-- Header Section End Here -->
        <section class="main_body_section scroll_div">

            <!-- Page Title Section 1 Mobile fixed -->
            <h5 class="f22 font-bold text-uppercase black_txt py-4 text-center text-sm-left">Wallet Balance Report</h5>
            <!-- Page Title Section 1 Mobile End -->

            <div class="title_balance p-2">
                <div class="title_balance_title">
                    <?php
                    if($filterTerm==2) echo "Reseller";
                    else if($filterTerm==3) echo "Agent";
                    else if($filterTerm==4) echo "Customer";
                    else echo "ALL AUDIENCES";
                    ?>
                    <br>TOTAL WALLET BALANCE
                </div>

                <div class="title_balance_count">
                    <span class="title_balance_count_amount">{{ number_format($sumOfWalletAmount,2) }}</span><span class="title_balance_count_caption">USD</span>
                </div>
            </div>

            <!-- Section 2 Mobile fixed -->
            <div class="row filter_wrp">

                <!-- Calender from -->
                <div class="col-12 col-sm-5 col-md-3">
                    <div class="input-group mb-3">
                        <input type="text" id="receipient_name" class="form-control bbcustinput" placeholder="Email, Name or User ID" aria-label="Recipient's username" aria-describedby="button-addon2" value="<?php echo $searchTerm;?>">
                        <div class="input-group-append">
                            <button class="btn btn-outline-primary px-2" type="button" id="button_search">
                                <img src="/public/images/search.png" class=" mt-0">
                            </button>
                        </div>
                    </div>
                </div>

                <div class="col-10 col-sm-5 col-md-3 conquest-selection">
                    <div class="dropdown cusdlable">
                        <!-- <button id="dLabel" class="dropdown-select" type="button" aria-haspopup="true" aria-expanded="false">
                            All Audiences
                            <span class="caret"></span>
                        </button> -->
                        <!-- <ul class="dropdown-menu" aria-labelledby="dLabel">
                            <li>All Audiences</li>
                            <li class="selected">Reseller</li>
                            <li>Agent</li>
                            <li>Customer</li>
                        </ul> -->
                        <div id="filter_sel"></div>

                        <!-- <select class="d3-select w-100" id="filter_sel" data-placeholder="All Audiences" style="width: 100%">
                        	<option value="all">All Audiences</option>
	                        <option value="reseller">Reseller</option>
	                        <option value="agent">Agent</option>
	                        <option value="customer">Customer</option>
	                    </select> -->
                    </div>
                </div>

                <!-- Calender to end-->

                <!-- Filter btn -->
                <div class="col-6 col-sm-2 col-lg-1 px-md-1 mb-3 mb-sm-0">
                    <a href="javascript::void(0);" class="print_btn" id="print_data">
                    <i class="fas fa-print mx-2"> </i>Print
                    </a>
                </div>

            </div>
            <!-- Filter section End-->
            <div class="grid_wrp d-none d-lg-block">
                <div class="grid_header clearfix pt-3 pb-3 sort-header">
                    <div class="w5 float-left font16 font-bold blue_txt">S.No</div>
                    <div class="w15 float-left font16 font-bold blue_txt pl-3">User Id</div>
                    <div class="w29 float-left font16 font-bold blue_txt pl-3">Email ID</div>
                    <div class="w22 float-left font16 font-bold blue_txt">Name</div>
                    <div class="w9 float-left font16 font-bold blue_txt text-center ">Audiences</div>
                    <div class="w20 float-left font16 font-bold blue_txt text-right pr-3">
                        <!-- Wallet Balance
                        <br>(USD) -->
                        <div id="sort_sel"></div>
                        <!-- <div class="dropdown cusdlable cusdlable-table-title">
                            <button id="dLabel" class="dropdown-select no-border text-right pr-5" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                Wallet Balance
                                <br>(USD)
                                <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dLabel">
                                <li>Ascending</li>
                                <li>Descending</li>
                            </ul>
                        </div> -->

                    </div>
                </div>
            </div>

            <div class="middle_box clearfix d-none d-lg-block mb-4">
                <div class="grid_wrp">


                    <div class="grid_body clearfix">
                        @if($allUsersDet->count())
                        @foreach($allUsersDet as $index=>$item)
                            <!-- Row 1 -->

                            <div class="grid_row clearfix">
                                <div class="w5 float-left font16 dark-grey_txt position-relative">
                                     {{ $index+1 }}
                                </div>
                                <div class="w15 float-left font16 dark-grey_txt pl-3" style="word-break: break-all;padding-right: 30px;">
                                    <!-- {{ ($item['description'] != '') ? $item['description'] : '-' }} -->
                                    {{ $item['user_id'] }}
                                </div>
                                <div class="w29 float-left font16 dark-grey_txt pl-3" style="word-break: break-all;padding-right: 30px;">
                                    <!-- {{ ($item['description'] != '') ? $item['description'] : '-' }} -->
                                    {{ $item['email'] }}
                                </div>
                                <div class="w22 float-left font16" style="word-break: break-all;">
                                    <!-- {{ number_format($item['sales_amount'],2) }} -->
                                    {{ $item['first_name']." ".$item['last_name'] }}
                                </div>
                                <div class="w9 float-left text-center">
                                    <div class="">
                                        <!-- {{ $item['commission_per'] }} -->
                                        @if($item['user_role']==2)
                                            <div class="label_resel">Reseller</div>
                                        @elseif($item['user_role']==3)
                                            <div class="label_agen">Agent</div>
                                        @elseif($item['user_role']==4)
                                            <div class="label_custo">Customer</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="w20 float-left font16 dark-grey_txt text-right pr-3">{{ number_format($item['amount'],2) }} USD</div>
                            </div>
                            @endforeach
                        @else
                            <div class="w100 norecord_txt">No Records Found</div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Table details Mobile view fixed -->

            <!-- Table details Mobile view End -->


            @if($allUsersDet->total()>0)
                <?php echo $allUsersDet->links();?>
            @endIf
        </section>
    </div>
    <!-- All scripts include -->
    @include("inc.scripts.all-scripts")

    <script type="text/javascript">
    	$(document).ready(function(){

    		var f=0;
    		var ddBasic = [
			    { text: "All Audiences", value: 'all', },
			    { text: "Reseller", value: '2',selected:'<?php if($filterTerm==2){ echo true;} ?>', },
			    { text: "Agent", value: '3', selected:'<?php if($filterTerm==3){ echo true;} ?>',},
			    { text: "Customer", value: '4', selected:'<?php if($filterTerm==4){ echo true;} ?>',}
			];
			$('#filter_sel').ddslick({
			    data: ddBasic,
			    onSelected: function(data){
			    	//alert();
	                var sel_fil=data.selectedData.value;
	                var receipient_name=$("#receipient_name").val();
	                if(receipient_name==""){
	                	receipient_name='all';
	                }
	                if(f!=0){
	                	if(sel_fil=='all'){
	                		location.href="<?php echo url('/');?>/walletBalanceReport/"+receipient_name;
	                	}else{
	                		location.href="<?php echo url('/');?>/walletBalanceReport/"+receipient_name+"/"+sel_fil;
	                	}

	                }
	               f++;
	            }
			});
	    	$('.dd-select').on('click',function(){
               if($(".dd-select").not( this ).hasClass('active')){
                    $(".dd-select").removeClass('active');
                }
           });
	    });
        $("#button_search").click(function(){
            var receipient_name=$("#receipient_name").val();
            var filter=$('#filter_sel .dd-selected-value').val();
            if(receipient_name==""){
            	receipient_name='all';
            }
            location.href="<?php echo url('/');?>/walletBalanceReport/"+receipient_name+"/"+filter;

        });
        var ddSort = [
		    { text: "Ascending", value: 'asc',selected:'<?php if($sortTerm=='asc'){ echo true;} ?>', },
		    { text: "Descending", value: 'desc',selected:'<?php if($sortTerm=='desc' || $sortTerm==''){ echo true;} ?>', }

		];
		var s=0;
        $("#sort_sel").ddslick({
        	data: ddSort,
		    onSelected: function(data){
		    	//alert();
                var sel_sort=data.selectedData.value;
                if(s!=0){
                	var receipient_name=$("#receipient_name").val();
                	var filter=$('#filter_sel .dd-selected-value').val();
                	//alert(filter);
                	if(receipient_name==""){
                		receipient_name='all';
                	}

                	location.href="<?php echo url('/');?>/walletBalanceReport/"+receipient_name+"/"+filter+"/"+sel_sort;
                }
               s++;
            }
        });
       $("#sort_sel .dd-select").click(function(){
       	if($("#sort_sel .dd-select").hasClass('active')){
       		$("#sort_sel .dd-select").removeClass('active');
       	}else{
       		$("#sort_sel .dd-select").addClass('active');
       	}
       });

       $('body').click(function() {
	       	if($("#sort_sel .dd-select").hasClass('active')){
	       		$("#sort_sel .dd-select").removeClass('active');
	       	}
       });

       var page = '<?php echo $page;?>';
       /* filter data */
        $("#print_data").click(function(e){
            e.preventDefault();
            if(page == '' || page == 0){
                page = 0;
            }
            var receipient_name=$("#receipient_name").val();
            var filter=$('#filter_sel .dd-selected-value').val();
            var sel_sort=$('#sort_sel .dd-selected-value').val();
            if(receipient_name==""){
                receipient_name='all';
            }
            location.href="<?php echo url('/');?>/walletBalanceReport/"+receipient_name+"/"+filter+"/"+sel_sort+"/yes?page="+page;

        });

    </script>

</body>
</html>
