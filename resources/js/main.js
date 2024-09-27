
// search
$('.header').on('click', '.search-toggle', function(e) {
    const selector = $(this).data('selector');

    $(selector).toggleClass('search-box-show').find('.search-input').focus();
    $(this).toggleClass('active');

    e.preventDefault();
});
//end search



// select file and image
$('.custom-file-input').on('change',function(){
    var fileName = $(this).val();
    $(this).next('.custom-file-label').html(fileName);
});

(function( $ ) {
    $.fn.extend({
        prettyFile: function( options ) {
            var defaults = {
                text : "Select Image"
            };

            var options =  $.extend(defaults, options);
            var plugin = this;

            function make_form( $el, text ) {
                $el.wrap('<div></div>');

                $el.hide();
                $el.after( '\
				<div class="input-append input-group"">\
					<span class="input-group-btn">\
						<button class="btn btn-secondary" type="button">' + text + '</button>\
					</span>\
					<input class="input-large form-control" type="text">\
				</div>\
				' );

                return $el.parent();
            }

            function bind_change( $wrap, multiple ) {
                $wrap.find( 'input[type="file"]' ).change(function () {
                    // When original file input changes, get its value, show it in the fake input
                    var files = $( this )[0].files,
                        info = '';

                    if ( files.length == 0 )
                        return false;

                    if ( !multiple || files.length == 1 ) {
                        var path = $( this ).val().split('\\');
                        info = path[path.length - 1];
                    } else if ( files.length > 1 ) {
                        // Display number of selected files instead of filenames
                        info = files.length + ' files selected';
                    }

                    $wrap.find('.input-append input').val( info );
                });
            }

            function bind_button( $wrap, multiple ) {
                $wrap.find( '.input-append' ).click( function( e ) {
                    e.preventDefault();
                    $wrap.find( 'input[type="file"]' ).click();
                });
            }

            return plugin.each( function() {
                $this = $( this );

                if ( $this ) {
                    var multiple = $this.attr( 'multiple' );

                    $wrap = make_form( $this, options.text );
                    bind_change( $wrap, multiple );
                    bind_button( $wrap );
                }
            });
        }
    });
}( jQuery ));
(function( $ ) {

    $.fn.jPreview = function() {
        var jPreview = this;

        jPreview.preview = function(selector){
            var container = $(selector).data('jpreview-container');
            var textInput = $(selector).parent().find('.input-append input:not([name])');

            $(selector).change(function(){
                $(container).empty();
                if (selector.files.length === 0) {
                    textInput.val('');
                } else {
                    $.each(selector.files, function(index, file){
                        var imageData = jPreview.readImageData(file, function(data){
                            jPreview.addPreviewImage(container, data);
                        });
                    });
                }
            });
        }

        jPreview.readImageData = function(file, successCallback){
            var reader = new FileReader();
            reader.onload = function(event){
                successCallback(event.target.result);
            }
            reader.readAsDataURL(file);
        }

        jPreview.addPreviewImage = function(container, imageDataUrl){
            $(container).append('<div class="jpreview-image" style="background-image: url('+ imageDataUrl +')"></div>');
        }

        var selectors = $(this);
        return $.each(selectors, function(index, selector){
            jPreview.preview(selector);
        });

    };

}( jQuery ));

$('.custom-file-img').prettyFile();
$('.demo').jPreview();
// end select file and image



$(document).ready(function(){
    $(window).scroll(function(){
        if ($(this).scrollTop() > 300) {
            $('#scroll').fadeIn();
        } else {
            $('#scroll').fadeOut();
        }
    });
    $('#scroll').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
});


