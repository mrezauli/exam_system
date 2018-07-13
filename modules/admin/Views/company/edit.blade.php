<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
             <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title"> Organization Information <span style="color:#FF0000">( ই-মেইল ও ওয়েব সাইট ছাড়া প্রতিষ্ঠানের অন্যান্য তথ্যাবলি বাংলায় পূরন করুন )</span></h4>
        </div>
        <div class="modal-body">

            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-company', $data->id]]) !!}
            @include('admin::company._update')
            {!! Form::close() !!}

        </div>
    </div>
</div>

