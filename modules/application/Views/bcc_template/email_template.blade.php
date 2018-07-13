<!DOCTYPE html>
<html lang="en-US">
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

    <link href="https://fonts.googleapis.com/css?family=Graduate" rel="stylesheet">

    <style>

    @font-face {
      /*font-family: 'SolaimanLipi';*/
      /*src: url('http://localhost/exam_system/public/assets/fonts/SolaimanLipi.ttf')  format('truetype');*/
    }
        
    .container{
        width: auto !important;
        padding: 40px !important;
    }

    .text-center {
        text-align: center;
    }

    body{
        font-size:14px !important;
        width: 210mm;
        margin: 0 auto!important;
    }

    .pull-right {
        float: right;
        width: auto !important;
    }

    .email-body{
        text-align: justify;
    }

    .{
        margin-bottom: -5px;
    }

    p{
        margin: 1em 0 !important;
    }

    .title{
        color:#333;
    }

    .sub-title{
        color:#333;
    }


    label{
        font-family: 'Open Sans', 'Open Sans', sans-serif;
        font-weight: 600 !important;
        font-size: 13px !important;
    }

    .page-header{
        margin: 0px 0 20px !important;
        padding-bottom: 20px !important;
    }


    

    @media print{    

        body *{
            font-size:18.5px !important;
        }

        .title{
            color:#333;
        }

        .sub-title{
            color:#333;
        }

    }

    </style>

</head>

<body style="width: 210mm;margin: 0 auto!important;font-size: 14px;font-family: 'Open Sans', sans-serif;">



    <div class="email-template-wrapper container" style="width: auto !important;padding:20px 40px !important;">


        <div class="row">

            <div class="col-sm-12">


                <div class="text-center title" style="text-align: center;font-family: 'Open Sans', sans-serif;font-size: 14px;max-width: 400px;margin: 0 auto;">গণপ্রজাতন্ত্রী বাংলাদেশ সরকার</div>
                
                <div class="text-center" style="text-align: center;font-family: 'Open Sans', sans-serif;font-size: 14px;max-width: 400px;margin: 0 auto;">{{$input['bcc_company_name']}}</div>

                <div class="text-center" style="text-align: center;font-family: 'Open Sans', sans-serif;font-size: 14px;max-width: 400px;margin: 0 auto;">{{$input['bcc_address']}}</div>

                <div class="text-center" style="text-align: center;font-family: 'Open Sans', sans-serif;font-size: 14px;max-width: 400px;margin: 0 auto;">{{$input['bcc_web_address']}}</div><br>


                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom: -5px;overflow: hidden;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">


                        @if(! empty($input['letter_no']))

                        <div class="col-sm-9" style="float: left;font-size: 14px;font-family: 'Open Sans', sans-serif;width:73%;">
                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">পত্র নং:</span>
                            {{$input['letter_no']}}
                        </div>

                        @endif

                        <div class="col-sm-3 pull-right" style="float: right;width: auto;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">তারিখ:</span>
                            {{$input['date_email']}}
                        </div>
                    </div>
                </div>




                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="font-size: 14px;font-family: 'Open Sans', sans-serif;margin-bottom:-5px;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                        <div class="col-sm-12" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                            <span class="sub-title" style="font-weight:700;color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">বিষয়:</span>
                            {{$input['subject']}}
                        </div>
                    </div>
                </div>





                <?php $i=1; ?>

                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t reference-no" style="margin-bottom: -5px;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                        <div class="col-sm-12" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                           
                        @foreach($input['reference_no'] as $value)

                            @if(! empty($value))

                                @if($i == 1)

                                <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">সূত্র: </span>
                                @else

                                <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;visibility: hidden;">সূত্র: </span>


                                @endif


                            <span style="font-weight:700">{{$i . '.'}}</span>
                            {{$value}}<br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                            <?php $i++; ?>

                            @endif

                        @endforeach

                        </div>
                    </div>
                </div>



                
                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom:5px;">
                    <div class="row">
                        <div class="col-sm-12 email-body" style="text-align:justify;">
                            {!! $input['email_description'] !!}
                        </div>
                    </div>
                </div>



                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

                @if(! empty($input['company_name']))

                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom: -5px;overflow: hidden;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

                        @if($has_file)

                        <div class="col-sm-9" style="float: left;font-size: 14px;font-family: 'Open Sans', sans-serif;width:50%;">
                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">সংযুক্তি: বর্ণনা মোতাবেক</span>

                        </div>

                        @endif


                        <div class="col-sm-3 pull-right" style="float: right;width: auto;font-size: 14px;font-family: 'Open Sans', sans-serif;text-align:center;">
                            
                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif">স্বাক্ষরিত/-</span>
                            
                            <br>
                            {!! ! empty($bcc_company->contact_person) ? $bcc_company->contact_person . '<br>':'' !!}
                            {!! ! empty($bcc_company->designation) ? $bcc_company->designation . '<br>':'' !!}
                            {!! ! empty($bcc_company->phone) ? $bcc_company->phone . '(অফিস)<br>':'' !!}
                            {!! ! empty($bcc_company->mobile) ? $bcc_company->mobile . '(মোবাইল)<br>':'' !!}
                            ই-মেইল: {{$input['bcc_web_address']}}<br>
                            
                        </div>
                    </div>
                </div>


                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom: -5px;overflow: hidden;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

                        <div class="col-sm-12 pull-left" style="float: left;max-width: 400px;font-size: 14px;font-family: 'Open Sans', sans-serif; text-align:left;">

                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif">{{$input['designation']}}</span>

                            <div class="text-left" style="text-align: left;max-width: 400px;margin: 0 auto;font-size: 14px;font-family: 'Open Sans', sans-serif;">{{$input['company_name']}}</div>

                            <div class="text-left" style="text-align: left;max-width: 400px;margin: 0 auto;font-size: 14px;font-family: 'Open Sans', sans-serif;">{{$input['address']}}</div>
                    
                        </div>
                    </div>
                </div>

                @endif    


                <?php $j=1;$j++; ?>


              {{--   @if(! empty($input['copy'][$j-1]))

                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">অনুলিপি:</span>
                
                @foreach($input['copy'] as $value)  

                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom: 0;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                        <div class="col-sm-12" style="font-size: 14px;font-family: 'Open Sans', sans-serif;margin-left: 60px">
                            @if(! empty($input['copy'][$j-1]))
                                <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;"> {{$j . '.'}} </span>
                                {{$value}}<br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                            @endif
                        </div>
                    </div>
                </div>
                
                @endforeach

                @endif  --}}


                <?php $j=1; ?>

                <br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

                <div class="no-margin-hr panel-padding-h no-padding-t no-border-t" style="margin-bottom: 0;font-size: 14px;font-family: 'Open Sans', sans-serif;">
                    <div class="row" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                        <div class="col-sm-12" style="font-size: 14px;font-family: 'Open Sans', sans-serif;">

                        @foreach($input['copy'] as $value)  

                            @if(! empty($value))

                            @if($j == 1)

                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;">অনুলিপি: </span>
                            @else

                            <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif; visibility: hidden;">অনুলিপি: </span>

                            @endif

                                <span class="sub-title" style="color:#333;font-size: 14px;font-family: 'Open Sans', sans-serif;"> {{$j . '.'}} </span>
                                {{$value}}<br style="font-size: 14px;font-family: 'Open Sans', sans-serif;">
                                <?php $j++; ?>

                            @endif

                        @endforeach

                        </div>
                    </div>
                </div>

                <footer style="margin-top:10px;padding:10px;text-align:center;font-family:Graduate;">N.B. This Letter is System Generated.</footer>

            </div>

        </div>

    </div>


    <link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
    <link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css">

</body>



</html>