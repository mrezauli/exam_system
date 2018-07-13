<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
            <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
        </div>

        <div class="modal-body">
            <div style="padding:30px;">
                <table id="" class="table table-bordered table-hover table-striped">
                    <tr>
                        <th class="col-lg-6">Organization Name</th>
                        <td>{{ isset($data->company_name)?$data->company_name:''}}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Address </th>
                        <td>{{ isset($data->address)?$data->address:''}}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Head of Organization</th>
                        <td>{{ isset($data->contact_person)?$data->contact_person:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Designation</th>
                        <td>{{ isset($data->designation)?$data->designation:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Office Phone</th>
                        <td>{{ isset($data->phone)?$data->phone:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Mobile</th>
                        <td>{{ isset($data->mobile)?$data->mobile:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">E-Mail</th>
                        <td>{{ isset($data->email)?$data->email:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Website</th>
                        <td>{{ isset($data->web_address)?$data->web_address:'' }}</td>
                    </tr>
                    <tr>
                        <th class="col-lg-6">Status</th>
                        <td>{{ isset($data->status)?$data->status:'' }}</td>
                    </tr>
                </table>
            </div>
        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()}}" class="btn btn-default" type="button" data-placement="top" data-content="click close button for close this entry form" onclick="close_modal();"> Close </a>
        </div>
    </div>
</div>




