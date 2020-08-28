<html lang='pt-br'>

<head>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <title>Perfect Pay - Teste - @yield('title')</title>
    <link href="{{ asset('/images/brand/favicon.png') }}" rel="icon" type="image/png" />
    <link rel='stylesheet' href="{{ url('/css/app.css') }}">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .custom-file-label::after {
            content: 'Buscar'
        }

        .wrapper #wrapperContent,
        .wrapper #wrapperContent.closed {
            padding: 0;
        }
    </style>
</head>

<body>
    <!-- NAVBAR TOP -->
    @include('layout_header')
    <div class='wrapper'>
        <div id='wrapperContent' class='content container mt-3'>
            @yield('content')
        </div>
    </div>
    <script src="{{ url('/js/app.js') }}"></script>
    <script src="{{ url('/js/bootstrap-validation.js') }}"></script>

    {{-- Incluso apenas para exibição da magem no momento do cadastro do produto --}}
    <script>
        document.querySelector('#image').onchange = (event) => {
            document.querySelector('label[for="image"]').innerText = event.target.files[0].name
            const reader = new FileReader()
            reader.readAsDataURL(event.target.files[0])
            reader.onload = () => {
                document.querySelector('#productThumb').src = reader.result
            }
        }
    </script>
    <script src="https://kit.fontawesome.com/d712964458.js" crossorigin="anonymous"></script>
    @yield('script')
</body>

</html>