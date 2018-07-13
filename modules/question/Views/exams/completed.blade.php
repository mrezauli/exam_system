
<link href="{{ URL::asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" >
<link href="{{ URL::asset('assets/css/bootstrap-reset.css') }}" rel="stylesheet" type="text/css" >






<div class="exam-page-wrapper container">
  <p><br></p>
  
  <h3 class="text-center">Exam Completed Suessfully.</h3>

</div>


<p><br></p>







<table  class="display table table-bordered table-striped company-table" id="example">
    <thead>
    <tr>
        <th> Candidate Name</th>
        <th> Language</th>
        <th> Accuracy</th>
        <th> wpm</th>
    </tr>
    </thead>

  

    <tbody>
    @if(isset($exams))
        @foreach($exams as $values)
            <tr class="gradeX">
                <td>{{$values->candidate_name}}</td>
                <td>{{$values->exam_type}}</td>
                <td>{{$values->accuracy}}</td>
                <td>{{$values->wpm}}</td>
            </tr>
    @endforeach
    @endif
</table>