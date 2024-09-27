<div class="modal fade" id="lockModal" tabindex="-1" role="dialog" aria-labelledby="lockModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lockModalLabel">Lock this discussion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.threads.close', $thread->id)}}" method="POST" id="lock-form">
                    @csrf
                    <textarea name="message" id="lock_message" rows="5" class="form-control" placeholder="Type the reason why you have locked this discussion here..."></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn my-btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn my-btn" onclick="$('#lock-form').submit()">Submit</button>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="parkModal" tabindex="-1" role="dialog" aria-labelledby="parkModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="parkModalLabel">Park this discussion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('dashboard.threads.park', $thread->id)}}" method="POST" id="park-form">
                    @csrf
                    <textarea name="message" id="park_message" rows="5" class="form-control" placeholder="Type the reason why you have parked this discussion here..."></textarea>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn my-btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn my-btn" onclick="$('#park-form').submit()">Submit</button>
            </div>
        </div>
    </div>
</div>

@auth
<div class="modal fade" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share this discussion</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('discussions.share', $thread->id)}}" method="POST" id="share-form">
                    @csrf
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-uppercase">YOUR NAME<span class="text-red ml-1">*</span></label>
                        <div class="col-md-8 col-lg-8">
                            <input name="name" id="name" class="form-control validatable" value="{{auth()->user()->name}}" placeholder="YOUR NAME">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-uppercase">YOUR EMAIL<span class="text-red ml-1">*</span></label>
                        <div class="col-md-8 col-lg-8">
                            <input type="email" class="form-control validatable" id="email" name="email" value="{{auth()->user()->email}}" placeholder="YOUR EMAIL">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="emails" class="col-md-4 col-form-label text-uppercase">RECIPIENTS EMAIL(S)<span class="text-red ml-1">*</span></label>
                        <div class="col-md-8 col-lg-8">
                            <input type="text" class="form-control validatable" id="emails" name="emails" placeholder="example1@gmail.com; example2@gmail.com; example3@gmail.com">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="message" class="col-md-4 col-form-label text-uppercase">OPTIONAL MESSAGE</label>
                        <div class="col-md-8 col-lg-8">
                            <textarea name="message" id="message" cols="30" rows="3" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="message" class="col-md-4 col-form-label text-uppercase">SUBJECT</label>
                        <div class="col-md-8 col-lg-8">
                            <p class="mt-2">{{$thread->subject}}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="send_responses" class="col-md-4 col-form-label text-uppercase">INCLUDE ANSWERS?</label>
                        <div class="col-md-8 col-lg-8">
                            <input type="checkbox" name="send_responses" id="send_responses" >
                        </div>
                    </div>

                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn my-btn btn-white" data-dismiss="modal">Cancel</button>
                <button type="button" class="btn my-btn" id="share_form_submit">
                    Share
                    <span class="spinner-border spinner-border-sm d-none" role="status" aria-hidden="true"></span>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" tabindex="-1" id="shared_modal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-body text-center p-4">
                <p>Message sent!</p>
                <button type="button" class="btn my-btn mt-3" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $('#share_form_submit').on('click', function () {
        const form = $('#share-form');
        const submitBtn = $(this);
        const spinner = submitBtn.find('.spinner-border');
        submitBtn.attr('disabled', true);
        spinner.removeClass('d-none');
        clearFormErrors(form);

        const data = new FormData(form[0]);

        $.ajax({
            url: form.attr('action'),
            method: form.attr('method'),
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'ACCEPT': 'application/json'
            },
            data: data,
            processData: false,
            contentType: false,
            success: () => {
                spinner.addClass('d-none');
                submitBtn.attr('disabled', false);
                $('#shareModal').modal('hide');
                $('#shared_modal').modal('show');
            },
            error: err => {
                if (err?.responseJSON.errors) {
                    const errors = err.responseJSON.errors;

                    for (let key in errors) {
                        form.find(`.validatable[name=${key}]`).parent().append(`
                                <span class="text-danger" role=alert>
                                    <strong> ${errors[key][0]}</strong>
                                </span>
                            `)
                    }
                }
                spinner.addClass('d-none');
                submitBtn.attr('disabled', false);
            }
        })
    });

    function clearFormErrors(parent) {
        parent.find('.text-danger').remove();
    }
</script>
@endsection
@endauth
