<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> Update Typing Test Details </h4>
        </div>
        <div class="modal-body">
{{-- {{$data}} --}}
<div class="text-center">
    
<p><b>Name:</b> {{$name}} </p>
<p><b>Roll No:</b> {{$roll_no}} </p>
<p><b>Exam Code:</b> {{$exam_code}} </p>

</div>




            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-roll-wise-typing-test-details', $data]]) !!}
            @include('reports::typing_test_report.update_typing_test_details')
            {!! Form::close() !!}

        </div>
    </div>
</div>