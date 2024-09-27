@foreach (session('flash_notification', collect())->toArray() as $message)
    <div class="modal" tabindex="-1" id="flash_modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-4">
                    <p>{!! $message['message'] !!}</p>
                    <button type="button" class="btn my-btn mt-3" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
<script>
   if($('#flash_modal').length) $('#flash_modal').modal('show');
</script>
{{ session()->forget('flash_notification') }}
