@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper contact-index-page">

    <div class="row">
        <section class="panel">
            <header class="panel-heading">
                {{ $pageTitle }}
                <a class="btn-sm btn-success pull-right paste-blue-button-bg" href="{{route('application-org-form')}}">
                    <b>Application Form</b>
                </a>
            </header>

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
                            <th> User Name </th>
                            <th> Organization Name </th>
                            <th> Reference No. </th>
                            <th> Subject </th>
                            <th> Action </th>
                        </tr>
                        </thead>
                        <tfoot class="search-section">
                        <tr>
                            <th> User Name </th>
                            <th> Organization Name </th>
                            <th> Reference No. </th>
                            <th> Subject </th>
                            <th> Action </th>
                        </tr>
                        </tfoot>
                        <tbody>
                        @if(isset($data))
                            @foreach($data as $values)
                                <tr class="gradeX">
                                    <td>{{isset($values->user->username) ? ucfirst($values->user->username):''}}</td>
                                    <td>{{isset($values->company->company_name) ? ucfirst($values->company->company_name):''}}</td>
                                    <td>{{isset($values->relAppOrgDtls->ref_no) ? ucfirst($values->relAppOrgDtls->ref_no):''}}</td>
                                    <td>{{isset($values->relAppOrgDtls->subject) ? ucfirst($values->relAppOrgDtls->subject):''}}</td>
                                    <td>
                                        <a href="{{ route('application-org-view', $values->id) }}" class="btn btn-info btn-xs" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        <a href="{{ route('edit-application-org', $values->id) }}" class="btn btn-primary btn-xs edit-link"><i class="fa fa-edit"></i></a>
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
