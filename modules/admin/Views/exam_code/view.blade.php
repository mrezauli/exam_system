<div class="modal-dialog modal-md">
    <div class="modal-content">
        <div class="modal-header">
            <a href="{{route('exam-code')}}" class="close" type="button"> &times; </a>
            <h4 class="modal-title">{{ 'Exam Code Information' }} </h4>
        </div>
        <div class="modal-body">
            <div style="padding: 30px;">
                <table id="" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th class="col-lg-6">Exam Code Number</th>
                        <td>{{ isset($data->exam_code_name)?$data->exam_code_name:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-6">Organization Name</th>
                        <td>{{ isset($data->company->company_name)?$data->company->company_name:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-6">Post Name</th>
                        <td>{{ isset($data->designation->designation_name)?$data->designation->designation_name:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-6">Exam Date</th>
                        <td>{{ isset($data->exam_date)?$data->exam_date:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-6">Shift</th>
                        <td>{{ isset($data->shift)?$data->shift:''}}</td>
                    </tr>

                    <tr>
                        <th class="col-lg-6">Exam Type</th>
                        <td>{{ isset($data->exam_type)?$data->exam_type:''}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()}}" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>
</div>