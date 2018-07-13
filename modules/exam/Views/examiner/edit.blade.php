@extends('admin::layouts.master')
@section('sidebar')
@parent
@include('admin::layouts.sidebar')
@stop

@section('content')

        <!-- page start-->

<div class="inner-wrapper index-page">

    <div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">

                    {{ $page_title }}

                    <a href="{{route('examiner-selection')}}" class=" btn btn-default pull-right" data-placement="top" data-content="click close button for close this entry form">Back</a>

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

                        <p> &nbsp;</p>
                        <p> &nbsp;</p>
                        {{-------------- Filter :Ends --------------------------------------------}}

                        {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-examiner', $data->id]]) !!}

                        <div class="form-group no-margin-hr panel-padding-h no-padding-t no-border-t">
                            <div class="row">

                                <div class="col-sm-2">
                                    {!! Form::label('exam_code_id', 'Exam Code:', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    @if(count($exam_code_list)>0)
                                    {!! Form::select('exam_code_id', $exam_code_list, Input::get('exam_code_list')? Input::get('exam_code_list') : null,['id'=>'exam_code_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                    {!! Form::text('exam_code_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::label('company_id', 'Organization:', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    @if(count($company_list)>0)
                                        {!! Form::select('company_id', $company_list, Input::old('company_id'),['id'=>'company_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                        {!! Form::text('company_id', 'No Product ID available',['id'=>'company_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>


                                <div class="col-sm-2">
                                    {!! Form::label('designation_id', 'Post Name:', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    @if(count($designation_list)>0)
                                        {!! Form::select('designation_id', $designation_list, Input::old('designation_id'),['id'=>'designation_list','class' => 'form-control  js-select','required']) !!}
                                    @else
                                        {!! Form::text('designation_id', 'No Product ID available',['id'=>'designation_list','class' => 'form-control','required','disabled']) !!}
                                    @endif
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::label('exam_date', 'Exam Date', ['class' => 'control-label']) !!}
                                     <small class="required">*</small>
                                    {!! Form::text('exam_date', Input::old('exam_date'), ['id'=>'exam_date', 'class' => 'form-control datepicker','required']) !!}
                                    <span class="input-group-btn add-on">
                                        <button class="btn btn-danger" type="button"><i class="icon-calendar"></i></button>
                                    </span>
                                </div>

                                <div class="col-sm-2">
                                    {!! Form::submit('Save', ['class' => 'btn btn-primary selection-button','data-placement'=>'top','data-content'=>'click save changes button for save Typing Text']) !!}
                                </div>



                            </div>
                        </div>

                        <p> &nbsp;</p>

                        <table  class="display table table-bordered table-striped typing-select-table" id="example">
                            <thead>
                            <tr>
                                <th> Select Examiner </th>
                                <th> First Name </th>
                                <th> Email </th>
                                <th> Action  </th>
                            </tr>
                            </thead>


                            <tfoot class="search-section">
                            <tr>
                                <th> Select Examiner </th>
                                <th> First Name </th>
                                <th> Email </th>
                                <th> Action  </th>
                            </tr>
                            </tfoot>
                            <tbody>

                            @if(isset($questions))
                                @foreach($questions as $values)
                                    <tr class="gradeX">
                                        <td><input type="checkbox" name="checkbox[]" class="checkbox" {{in_array($values->id,$selected_questions_id)?'checked':''}} value="{{$values->id}}"></td>
                                        <td>{{ucfirst($values->username)}}</td>
                                        <td>{{$values->email}}</td>
                                        <td>
                                            <a href="{{ route('view-examiner', $values->id) }}" class="btn btn-info btn-xs" data-toggle="modal" data-target="#estbModal3" data-placement="top" data-content="view"><i class="fa fa-eye"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                        {!! Form::close() !!}
                    </div>
                </div>
            </section>
        </div>
    </div>
</div>
<!-- page end-->


<!-- Modal  -->

<div class="modal fade" id="estbModal3" tabindex="" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static">

</div>

<!-- modal -->
@stop
        <!--script for this page only-->


@section('custom-script')

    <script>


    $('select, #exam_date').not('#exam_code_list').prop('disabled', true);
                        
    $('form').on('submit', function() {
        $('select, #exam_date').prop('disabled', false);
    });


    

        $('.datepicker').each(function(index, el) {

            $(el).datepicker({
                format: 'yyyy-mm-dd'
            });

        });


        var column_index = ['2'];
        create_dropdown_column(column_index);
    </script>
@stop
