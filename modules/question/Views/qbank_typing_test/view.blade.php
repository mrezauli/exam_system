<div class="modal-dialog modal-extra-large">
    <div class="modal-content">
        <div class="modal-header">
            <a class="close" type="button" title="click x button for close this entry form"  data-dismiss="modal">&times;</a>
            <h4 class="modal-title">{{ $page_title }} </h4>
        </div>
        <div class="modal-body">
            <div style="padding: 30px;">
                <table id="" class="table table-bordered table-hover table-striped">
                    <tr>
                        <td>{{$data->typing_question}}</td>
                    </tr>
    
                </table>
            </div>
        </div>

        <div class="modal-footer">
{{--            <a href="{{ URL::previous()}}" class="btn btn-default" type="button"> Close </a>--}}
            <a class="btn btn-default" title="click x button for close this entry form"  data-dismiss="modal">Close</a>
        </div>

    </div>
</div>