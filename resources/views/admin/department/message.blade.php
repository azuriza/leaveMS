@if(session('status'))
    <script src="{{asset('frontend/js/sweetalert.min.js')}}"></script>
    <script>
        swal({
            title: "{{session('status')}}",
            text: "",
            icon: "{{session('status_code')}}",
            button: "Ok!",
        }).then(function () {
            window.location.reload();
        })
    </script>

@endif
