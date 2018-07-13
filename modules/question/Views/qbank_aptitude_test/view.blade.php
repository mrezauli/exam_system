<div class="modal-dialog modal-extra-large">
    <div class="modal-content">
        <div class="modal-header">
            <a class="close" type="button" title="click x button for close this entry form"  data-dismiss="modal">&times;</a>
        </div>

        <div class="modal-body">

            <iframe style="width:100%;height:500px" src="{{URL::asset($question->image_file_path)}}"></iframe>
            {{-- <img width="100%" src="{{URL::asset($question->image_file_path)}}" alt="No Image is Found."> --}}
        </div>

        <div class="modal-footer">
            <a class="btn btn-default" title="click x button for close this entry form"  data-dismiss="modal">Close</a>
        </div>
    </div>
</div>




