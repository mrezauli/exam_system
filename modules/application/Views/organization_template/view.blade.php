@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

    <div class="inner-wrapper task-view-page">

        <div class="page-header">

            <a href="{{URL::previous()}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

            <div class="clearfix"></div>

        </div>

        <div class="app-container col-sm-offset-2 col-sm-8">
            <h3 class="page-title text-center green">{{  $page_title  }}</h3>
                <table id="" class="table table-bordered table-hover table-striped vertical-table view-table">

                    <tr>
                        <th class="col-lg-1">Organization Name</th>
                        <td class="col-lg-3">{{ isset($data->company->company_name)?$data->company->company_name:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-1">User Name</th>
                        <td class="col-lg-3">{{ isset($data->user->username)?$data->user->username:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-1">Email</th>
                        <td class="col-lg-3">{{ isset($data->user->email)?$data->user->email:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-1">Letter No</th>
                        <td class="col-lg-3">{{ isset($data->relAppOrgDtls->letter_no)?$data->relAppOrgDtls->letter_no:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-1">Subject</th>
                        <td class="col-lg-9" colspan="3">{{ isset($data->relAppOrgDtls->subject)?$data->relAppOrgDtls->subject:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-1">Letter</th>
                        <td class="col-lg-9" colspan="3">
                            
                        @if(count($file_main_data)>0)

                                <?php $expld = explode('/',$file_main_data->application_attachment_path); ?>
                                
                                    {{ $expld[1] }}

                                    {{-- <a href="{{ URL::to($file_main_data->application_attachment_path) }}" class="btn btn-primary btn-xs" data-placement="top" download="{{ $expld[1] }}">Download</a> --}}

                                    <a href="#" class="btn btn-danger btn-xs print">Print</a>

                                    {{-- <a href="{{ route('delete-organization-template-attachment',$file_main_data->id) }}" class="btn btn-danger btn-xs" data-placement="top">Delete</a><br><br><br> --}}

                        @endif

                        </td>
                    </tr>


                    @if(count($file_extra_data)>0  && collect($file_extra_data)->lists('status')->contains('active'))

                    <tr>
                        <th style="position:relative;" class="col-lg-1"><div class="attachment-class">Attachment</div></th>

                        <td class="col-lg-9" colspan="3">


                        @foreach($file_extra_data as $file)

                            <?php $expld = explode('/',$file->application_attachment_path); ?>

                            @if($file->status = 'active' && isset($file->application_attachment_path))

                                
                                    {{ $expld[1] }}
                                    
                                    <a style="margin: 10px 7px;" href="{{ URL::to($file->application_attachment_path) }}" class="btn btn-primary btn-xs" data-placement="top" download="{{ $expld[1] }}">Download</a><br>
                                             

                            @endif

                                {{-- <a href="{{ route('delete-organization-template-attachment',$file->id) }}" class="btn btn-danger btn-xs" data-placement="top">Delete</a><br><br><br> --}}

                        @endforeach

                        </td>

                        </tr>

                    @endif

                </table>
        </div>

        




        

    </div>

@stop

@section('custom-script')

<script>
    
// w=window.open();
// w.document.write(document.getElementsByClassName('report_left_inner')[0].innerH‌​TML);
// w.print();
// w.close();


$(document).ready(function()
{

  $('.print').click(function(event) {

    var w = window.open('{{ URL::to(isset($file_main_data->application_attachment_path)?$file_main_data->application_attachment_path:'') }}'); //Required full file path.
    w.print();
    
  });

});

</script>


@stop