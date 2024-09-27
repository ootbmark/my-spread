<script src="/js/crop.js"></script>
<script>
    $(document).ready(function(){
        $(".open_close-menu").click(function(){
            $('.my-profile-menu').toggleClass('profile-menu-opened');
        });
    });

    // crop
    function getName(str) {
        if (str.lastIndexOf('\\')) {
            var i = str.lastIndexOf('\\') + 1;
        }
        else {
            var i = str.lastIndexOf('/') + 1;
        }
        var filename = str.slice(i);
        var uploaded = document.getElementById("fileformlabel");
        uploaded.innerHTML = filename;
    }

    $('div.alert').not('.alert-important').delay(3000).fadeOut(350);

    $uploadCrop = $('#upload-img').croppie({
        enableExif: true,
        viewport: {
            width: 170,
            height: 170,
            type: 'square'
        },
        boundary: {
            width: 220,
            height: 220
        }
    });
    $('#upload').on('change', function () {
        var reader = new FileReader();
        reader.onload = function (e) {
            $uploadCrop.croppie('bind', {
                url: e.target.result
            }).then(function () {
                $('.upload-result').attr('disabled', false);
                console.log('jQuery bind complete');
            });

        }
        reader.readAsDataURL(this.files[0]);
    });

    $('.upload-result').on('click', function (ev) {
        $uploadCrop.croppie('result', {
            type: 'canvas',
            size: 'viewport'
        }).then(function (resp) {
            $.ajax({
                url: "{{route('profile.image.update')}}",
                method: "POST",
                data: {"image": resp},
                success: function (data) {
                    html = '<img src="' + resp + '" />';
                    $("#user-img").html(html);
                }
            });
        });
    });
    $(document).ready(function(){
        $(".open_close-menu").click(function(){
            $('.my-profile-menu').toggleClass('profile-menu-opened');
        });
    });
</script>
