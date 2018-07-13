@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper contact-index-page">

    <div class="row">
        <div class="col-sm-12">
        <section class="panel">
            <header class="panel-heading">
                {{ $pageTitle }}
            </header>
            <br>
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $error)
                        <p>{{ $error }}</p>
                    @endforeach
                </div>
            @endif
            @if(Session::has('flash_message'))
                <div class="alert alert-success">
                    <p>{{ Session::get('flash_message') }}</p>
                </div>
            @endif

            <div class="panel-body">
                <div class="adv-table">

                    <table  class="display table table-bordered table-striped" id="example">
                        <thead>
                        <tr>
                            <th> Organization Name </th>
                            <th> Date </th>
                            <th> Subject </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tfoot class="search-section">
                        <tr>
                            <th> Organization Name </th>
                            <th> Date </th>
                            <th> Subject </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{isset($values->company->company_name) ? $values->company->company_name:''}}</td>
                                    <td>{{isset($values->created_at) ? $values->created_at->toDateString():''}}</td>
                                    <td>{{isset($values->relAppOrgDtls->subject) ? $values->relAppOrgDtls->subject:''}}</td>
                                    <td>

                                    <?php $application_format = str_replace("_","-",$values->application_format);

                                    $read = isset($values->relAppOrgDtls->read_email) && $values->relAppOrgDtls->read_email == 'true' ? 'none':'inline-block';

                                     ?>

                                        <a href="{{ route('view-bcc-' . $application_format, ['received',$values->id]) }}" class="btn btn-info btn-xs" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>

                                        <div class="btn btn-danger btn-xs" style="display:{{$read}}">Unread</div>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
        </div>
    </div>
</div>
<!-- page end-->



<div class="modal fade" id="etsbModal" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">
</div>

<!--script for this page only-->



<script>

    $(document).ready(function() {


        if ($('html').width() <= '1110') {

            $('.contact-index-page .adv-table table.display thead th:first-child').html('Organization Name');
        }

    });
</script>


@stop





{{--
@section('custom-script')
    <script>

        var column_index = ['1','2'];
        create_dropdown_column(column_index);


    </script>
@stop--}}
