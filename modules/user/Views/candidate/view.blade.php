<div class="modal-dialog modal-md">
    <div class="modal-content">

<div class="modal-header">
    <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
    <h4 class="modal-title" id="myModalLabel">{{$pageTitle}}</h4>
</div>

<div class="modal-body">
    <div style="padding: 30px;">
        <table id="" class="table table-bordered table-hover table-striped">
            <tr>
                <th class="col-lg-4">Candidate Name</th>
                <td>{{ isset($data->username)?ucfirst($data->username):''}}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Organization Name</th>
                <td>{{ isset($data->relCompany->company_name)?ucfirst($data->relCompany->company_name):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Name of the Post</th>
                <td>{{ isset($data->relDesignation->designation_name)?ucfirst($data->relDesignation->designation_name):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Roll No.</th>
                <td>{{ isset($data->roll_no)?$data->roll_no:'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">NID</th>
                <td>{{ isset($data->nid)?ucfirst($data->nid):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">DOB</th>
                <td>{{ isset($data->dob)?date('Y-m-d', strtotime($data->dob)):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">District</th>
                <td>{{ isset($data->district)?ucfirst($data->district):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Typing Status</th>
                <td>{{ isset($data->typing_status)?ucfirst($data->typing_status):'' }}</td>
            </tr>
            <tr>
                <th class="col-lg-4">Apt. Status</th>
                <td>{{ isset($data->aptitude_status)?ucfirst($data->aptitude_status):'' }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="modal-footer">
    <a href="{{ URL::previous()}}" class="btn btn-default" type="button" data-placement="top" data-content="click close button for close this entry form"> Close </a>
</div>

    </div>
</div>

<script>
    $(".btn").popover({ trigger: "manual" , html: true, animation:false})
            .on("mouseenter", function () {
                var _this = this;
                $(this).popover("show");
                $(".popover").on("mouseleave", function () {
                    $(_this).popover('hide');
                });
            }).on("mouseleave", function () {
                var _this = this;
                setTimeout(function () {
                    if (!$(".popover:hover").length) {
                        $(_this).popover("hide");
                    }
                }, 300);
            });
</script>




