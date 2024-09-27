<!-- Modal -->
<div class="modal" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content border-purple">
            <div class="modal-header text-center">
                <h5 class="modal-title" id="contactModalLabel"><b>{{__('Contacting another member')}}</b></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('profile.send', $user->id)}}" method="POST" id="contact-user-form">
                @csrf
                <div class="modal-body">
                    <p>{{__('My-SPREAD takes user privacy extremely seriously. We will pass your contact details and your message on to this user, and it is up to them to choose if they wish to reply.')}}</p>
                    <label for="message" class="text-uppercase"><b>{{__('Your Message:')}}</b></label>
                    <textarea rows="6" cols="75" id="message" name="message" required></textarea>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-purple text-white sub-btn">{{__('SEND')}}</button>
                </div>
            </form>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        $('#contact-user-form').on('submit', function () {
            $('.sub-btn').prop('disabled', true);
        })
    </script>
@endsection
