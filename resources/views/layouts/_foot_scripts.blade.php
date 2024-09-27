@if(config('app.env') == 'production')
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.10/cookieconsent.min.js"></script>
    <script>
        window.cookieconsent_options = {
            "message":'{{__('This website uses cookies to ensure you get the best experience on our website')}}',
            "dismiss":'{{__('Got it!')}}',
            "learnMore":'{{__('More info')}}',
            "link":"http://my-spread.com/tos-privacy-cookie","theme":"dark-bottom"
        };
    </script>
    <script src="//load.sumome.com/" data-sumo-site-id="7d73e8c5d96dfe03184db63a3e0bed133cb977b1092ec106acc1f315b4390431" async="async"></script>
@endif
