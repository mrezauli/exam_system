@extends('admin::layouts.master')
@section('sidebar')
@include('admin::layouts.sidebar')
@stop

@section('content')

<style>
    
form{
    padding-top: 0;
}

form .col-sm-12{
    margin-bottom: 20px;
}


form .col-sm-12:last-child{
    margin-bottom: 30px;
}

</style>

<!-- page start-->
<div class="row task-report-index report-index">
    <div class="col-sm-12">
        <div class="panel">
            <div class="panel-heading">
                <span class="panel-title">{{ $page_title }}</span>
                <div class="clearfix"></div>
            </div>

          
            <div class="panel-body">

                <ul class="alert alert-danger" style="margin-left: 30px;border-radius: 5px; display: none">
                    <li class="msg"></li>
                </ul>

                {{-------------- Filter :Starts ------------------------------------------}}
                {!! Form::open(['method' =>'GET','route'=>'generate-examination-summary-report','class'=>'report-form']) !!}
                <div class="col-sm-12">
                
                    <div class="col-lg-25 col-md-3 col-sm-6">
                        {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                        {!! Form::Select('company_id',$company_list, @Input::get('company_id')? Input::get('company_id') : null,['id'=>'company_list','class' => 'form-control js-select','placeholder'=>'select company', 'title'=>'select company']) !!}
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('from_date', 'From Date:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('from_date', Input::get('from_date')? Input::get('from_date') : null, ['id'=>'from_date', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-25 col-md-3 col-sm-6">
                      {!! Form::label('to_date', 'To Date:', ['class' => 'control-label']) !!}
                      <small class="required jrequired">(Required)</small>
                      {!! Form::text('to_date', Input::get('to_date')? Input::get('to_date') : null, ['id'=>'to_date', 'class' => 'form-control datepicker','required'=>'required']) !!}
                      <span class="input-group-btn add-on">
                        <button class="btn btn-danger calender-button" type="button"><i class="icon-calendar"></i></button>
                      </span>
                    </div>

                    <div class="col-lg-2 col-md-3 col-sm-6 filter-btn">

                      {!! Form::submit('Generate Report', array('class'=>'btn btn-primary btn-xs pull-left','id'=>'submit-button','style'=>'padding:9px 17px!important', 'data-placement'=>'right', 'data-content'=>'type user name or select branch or both in specific field then click search button for required information')) !!}
                    </div>

                    <a href="#" class="btn btn-danger print-button pdf_report_button">Print Result</a>

                </div>        

                {!! Form::close() !!}

                <br><br><br><br><br>



                {{------------- Filter :Ends ------------------------------------------}}
                <div class="table-primary report-table-wrapper">

                    <table width="100%" cellpadding="0" cellspacing="0" border="0" class="table table-striped table-bordered report-table" id="examples_report">
                        <thead>
                        <tr>
                            <th class="no-border"> <span>SL.</span> </th>
                            <th class="no-border"> <span>Organization Name</span> </th>
                            <th class="no-border"> <span>Exam Type</span> </th>
                            <th class="no-border"> <span>Exam Date</span> </th>
                            <th class="no-border"> <span>No. of Candidates</span> </th>
                        </tr>
                        </thead>
                        <tbody>
                        
                        @if($status==2)

                            <?php $sl_no = '0'; ?>

                            @foreach($all_model as $values)

                            <?php 

                            $sl_no++; 

                            $exam_type = ucwords(implode(' ',explode('_', $values->exam_type)));
 
                            ?>

                                <tr class="gradeX">                   
                                    <td>{{$sl_no}}</td>
                                    <td>{{$values->company_name}}</td>
                                    <td>{{$exam_type}}</td>
                                    <td>{{$values->exam_date}}</td>
                                    <td>{{$values->no_of_candidates}}</td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>         
        
                </div>
                @if($status==2)
                    {{-- <span class="pull-right">{!! str_replace('/?', '?',  $model->render() ) !!} </span> --}}

                @endif
            </div>
        </div>
    </div>
</div>









<div class="table-primary print-report-table-wrapper">

<style>

    .print-show{
        display: none;
    }

    table thead tr th:last-child{
        border-right: 1px solid #333 !important;
    }

    .table-name{
        text-align: left;
    }

    .dataTables_filter{
        display: none;
    }


    @media print{      

        *{
            text-align: center !important;
            font-size: 14px !important;
        }

        .table-name{
            text-align: left !important;
        }

        #examples * {
            border: none;
        }

        table#examples{
            border-collapse: collapse !important;
        }

        thead tr th, tbody tr td{
            border: 1px solid #333 !important;
        }

        thead tr th:empty{
            border-right:none !important;
            border-top:none !important;
        }

        thead:first-child tr, thead tr th.no-border{
            border-bottom:0 !important;
        }


        .no-border span{
            /*position: relative;*/
            /*top: 18px;*/
        }

        .print-hide{
            display: none !important;
        }

        .print-show{
            display: block !important;
        }

        .header{
            font-family: SolaimanLipi !important;
            font-size: 15px !important;
            text-align: center;
            max-width: 400px;
            margin: 5px auto;
        }

        .header-section{
            margin-bottom: 20px;
        }

        .table-primary thead tr th:empty {
            border-right: none !important;
            border-top: none !important;
        }

        table.report-table thead th {
            padding: 10px;
            font-weight: 600;
            color: #333;
            text-align: center;
        }


        table thead th, table tfoot th {
            font-weight: 600 !important;
            color: #333 !important;
            padding-left: 0 !important;
        }

        footer{
            font-size: 16px !important;
        }

        table thead tr th:last-child{
            border-right: 1px solid #333 !important;
        }

        thead tr th, tbody tr td,tr th, tr td {
            border: 1px solid #333 !important;
        } 

    } 

</style>
                        

<div class="print-section print-show">
    <div class="header-section">
        <p class="header">{{ isset($header->company_name) ? $header->company_name : ''}}</p>
        <p class="header">{{ isset($header->address_one) ? $header->address_one : ''}}</p>
        <p class="header">{{ isset($header->address_two) ? $header->address_two : ''}}</p>
        <p class="header">{{ isset($header->address_three) ? $header->address_three : ''}}</p>
        <p class="header">{{ isset($header->address_four) ? $header->address_four : ''}}</p>
        <p class="header">পদের নাম: {{ isset($header->designation_name) ? $header->designation_name : ''}}</p>
        <p class="header">পরীক্ষার তারিখ: {{ $exam_dates_string }}</p>
        <p class="header">পরীক্ষা গ্রহণে: বাংলাদেশ কম্পিউটার কাউন্সিল।</p>
    </div>



    <table width="100%" cellpadding="3" cellspacing="0" border="1" class="table table-striped table-bordered report-table" id="examples">
        <thead>
        <tr>
            <th class="no-border"> <span>SL.</span> </th>
            <th class="no-border"> <span>Organization Name</span> </th>
            <th class="no-border"> <span>Exam Type</span> </th>
            <th class="no-border"> <span>Exam Date</span> </th>
            <th class="no-border"> <span>No. of Candidates</span> </th>
        </tr>
        </thead>
        <tbody>
        
        @if($status==2)

        <?php

        $sl_no = '0';

        //$all_model = collect($all_model)->sortBy('company_name')->sortByDesc('exam_type')->sortBy('exam_date');

        ?>

            @foreach($all_model as $values)

                <?php 

                $sl_no++; 

                $exam_type = ucwords(implode(' ',explode('_', $values->exam_type)));
 
                ?>

                <tr class="gradeX">
                    <td>{{$sl_no}}</td>
                    <td>{{$values->company_name}}</td>
                    <td>{{$exam_type}}</td>
                    <td>{{$values->exam_date}}</td>
                    <td>{{$values->no_of_candidates}}</td>
                </tr>
            @endforeach
            
        @endif
        </tbody>
    </table>


    <table style="margin:20px;width:30%;margin-left:70%;" cellspacing="1" border="1" class="table table-striped table-bordered report-table" id="examples">
      <tr>
        <th>Total Organizations</th>
        <th>No. of Candidates</th>
      </tr>
      
      <tr>
        <td>{{$total_organizations}}</td>
        <td>{{$total_no_of_candidates}}</td>
      </tr>
    </table>

    </div>

    <footer class="print-show" style="margin-top:10px;padding:10px;text-align:center;">N.B. This Report is System Generated.</footer>

</div>

</div>



<!-- page end-->

<!--script for this page only-->


<script type="text/javascript" src="{{ URL::asset('assets/js/date-and-timepicker-custom.js') }}"></script>
<script>

    // $('#button').click(function(e){
    //     var company_id = $('#company_id').val();
    //     var designation_id = $('#designation_id').val();
    //     var from_date = $('#from_date').val();
    //     var to_date = $('#to_date').val();

    //     if(company_id.length <= 0 || designation_id.length <= 0 || from_date.length <= 0 || to_date.length <= 0 ){
    //         $('.alert-danger').show();
    //         $('.msg').html('Please fill out all input field!');
    //     }else{
    //         $('.report-form').submit();
    //     }

    // })

    $('.print-button').click(function(event) {

        w=window.open();
        w.document.write(document.getElementsByClassName('print-report-table-wrapper')[0].outerHTML);
        w.print();
        w.close();

    });

    $('.print-button-wr').click(function(event) {

        w=window.open();
        w.document.write(document.getElementsByClassName('print-report-table-wr-wrapper')[0].outerHTML);
        w.print();
        w.close();

    });

</script>
@stop




@section('custom-script')
<script>

var table = $('#examples_report').DataTable( {
  "language": {
    "search": "Search Roll No:"
  },
  //"aaSorting": [['1','asc'],['2','desc'],['3','asc']],
  "pageLength": 50,
});


$('#examples_report_filter input').on('keyup', function(){

   table
   .column(1)
   .search(this.value)
   .draw();

 });

</script>
@stop