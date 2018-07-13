<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
            <a href="{{route('designation')}}" class="close" type="button"> &times; </a>
            <h4 class="modal-title">{{ $page_title }} </h4>
        </div>
        <div class="modal-body">
            <div style="padding: 30px;">
                <table id="" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th class="col-lg-6">Post Name</th>
                        <td>{{ isset($data->designation_name)?$data->designation_name:''}}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()}}" class="btn btn-default" type="button"> Close </a>
        </div>

    </div>
</div>