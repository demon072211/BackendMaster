<div class="modal fade bd-example-modal-lg" id="deleteModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content background-modal">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">{{__('base.cancel')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="{{__('base.close')}}">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" id="form-delete" action="">
                    @csrf
                    <div class="card-body">
                        <div class="form-group row">
                            <input type="text" hidden id="delete-modal-bank" value="" name="id">
                            <div class="col-sm-10" id="delete-content">
                            </div>
                        </div>
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-light px-5" data-dismiss="modal">{{__('base.close')}}</button>
                        <button type="submit" class="btn btn-light px-5" id="create-modal">{{__('base.confirm')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>