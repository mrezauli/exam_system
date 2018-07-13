<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <a href="{{ URL::previous() }}" class="close" type="button" title="click x button for close this entry form"> × </a>
        </div>

        <div class="modal-body">

            <iframe style="width:100%;height:500px" src="{{URL::asset($question->image_file_path)}}"></iframe>

        </div>

        <div class="modal-footer">
            <a href="{{ URL::previous()}}" class="btn btn-default" type="button" data-placement="top" data-content="click close button for close this entry form" onclick="close_modal();"> Close </a>
        </div>
    </div>
</div>