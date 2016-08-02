
<html>
    <head>
        <title>QDN</title>
        <link rel="stylesheet" href="/css/all.css">
        <link rel="stylesheet" href="/css/intro.css">
    </head>
    <body>
        <div class="header">
        {{-- <img src="/img/infographic.png" style="width: 100vw;height:100vh"> --}}
        <div class="bg">
                 <img src="{{ $server }}/img/backdrop.png" class="cover">
             </div>

            <div class="logo">TELFORD</div>

            <div class="nav">
                <ul class="topnav">
                    <li>About</li>
                    <li>Contact</li>
                    <li>FAQs</li>
                </ul>
            </div>

            <div class="header__title">
                <h1>QUALITY DEVIATION NOTICE</h1>

        <form method="POST" action="{{ url('/login') }}">
            {!! csrf_field() !!}
            <div id="login">
                @if ($errors->any())
                    @foreach($errors->all() as $error)
                        <p class="error">{{ $error }}</p>
                    @endforeach
                @endif

                <input required
                       type="text"
                       name="employee_id"
                       placeholder="Employee ID"
                       autocomplete="off"
                >

                <input required
                       type="password"
                       name="password"
                       placeholder="Password"
                       autocomplete="off"
                >

                <div class="login-submit">
                    <button
                            type="submit"
                            class="btn-submit"
                    >Login
                        <i class="fa fa-sign-in"></i>
                    </button>
                </div>

            </div>
        </form>


            </div>
        </div>
        <script src="/js/all.js"></script>
        <script>
            $(document).ready(function () {

                $(window).scroll(function() {

                    var wScroll = $(window).scrollTop();
                    $(".cover").css("transform", "translate(0px, " + wScroll/5 + "px)");
                });

                $("#login-btn").on('click', function (event) {

                    event.preventDefault();

                    // Store hash (#)
                    var hash = this.hash;
                    $('html, body').animate({
                        scrollTop: $(hash).offset().top
                    }, 1000, function () {
                        window.location.hash = hash;
                        $('#login>input:first-of-type').focus();
                    });
                });

            });
        </script>
    </body>
</html>