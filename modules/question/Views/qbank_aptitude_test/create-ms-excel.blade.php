<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <a type="button" class="close" data-dismiss="modal" title="click x button for close this entry form">×</a>
            <h4 class="modal-title" id="myModalLabel">Add Aptitude Test Questions<span style="color:#A54A7B" class="user-guideline" data-content="<em>Must Fill <b>Required</b> Field. <b>*</b> Put cursor on input field for more informations</em>"><font size="2"></font> </span></h4>
        </div>
        <div class="modal-body">

            <div class="inner-wrapper form-page meeting-form-page">

                @if($errors->any())
                <ul class="alert alert-danger">
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
                @endif
                @if(Session::has('error'))
                <div class="alert alert-danger">
                    <p>{{ Session::get('error') }}</p>
                </div>
                @endif

                {!! Form::open(['route' => ['store-qbank-aptitude-test'],'id' => 'jq-validation-form','enctype'=>'multipart/form-data']) !!}
                @include('question::qbank_aptitude_test._form')
                    <input type="hidden" name="question_type" value="excel">
                {!! Form::close() !!}

            </div>

        </div> <!-- / .modal-body -->
    </div> <!-- / .modal-content -->
</div> <!-- / .modal-dialog -->



