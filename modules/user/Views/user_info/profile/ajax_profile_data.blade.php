
<div class="row">
    <div class="col-sm-12">
        @if(isset($data))
            <a href="{{ route('edit-user-profile', $data->id) }}" class="btn btn-primary btn-xs" data-placement="top" data-toggle="modal" data-target="#entsolModal" style="margin-left:90%">Edit Profile</a>
        @else
            <a class="btn btn-success btn-xs" data-toggle="modal" href="#addProfile" data-placement="left" data-content="click 'add user' button to add new user"  style="margin-left:90%">
                <strong>Add Profile</strong>
            </a>
        @endif
        <div class="panel">
            <div class="panel-body">
                <div class="table-primary">
                    @if(isset($data))
                        <section class="col-lg-12">
                            <div class="col-lg-6">
                                <p><strong>First Name : </strong>{{isset($data->first_name)?ucfirst($data->first_name):''}}</p>
                                <p><strong>Last Name :</strong> {{isset($data->last_name)?ucfirst($data->last_name):''}}</p>
                                <p><strong>Telephone Number :</strong> {{isset($data->telephone_number)?ucfirst($data->telephone_number):''}}</p>
                            </div>
                            <div class="col-lg-6">
                                <p><strong>Data Of Birth : </strong>{{isset($data->date_of_birth)?ucfirst($data->date_of_birth):''}}</p>
                                <p><strong>Address : </strong>{{isset($data->address)?ucfirst($data->address):''}}</p>
                            </div>
                        </section>
                    @else
                        {{'No data Found'}}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal  -->


<!-- modal -->

