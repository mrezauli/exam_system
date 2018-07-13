<div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
             <a href="{{route('designation')}}" class="close" type="button"> &times; </a>
            <h4 class="modal-title">Edit Post</h4>
        </div>
        <div class="modal-body">
            {!! Form::model($data, ['method' => 'PATCH', 'route'=> ['update-designation', $data->id]]) !!}
            @include('admin::designation._form')
            {!! Form::close() !!}
        </div>
    </div>
</div>