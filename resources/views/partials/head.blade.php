<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />

<title>{{ $title ?? config('app.name') }}</title>

<link rel="icon" type="image/png" href="{{ asset('images/favicon-kine.png?v=2') }}">
<link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon-kine.png?v=2') }}">
<link rel="apple-touch-icon" href="{{ asset('images/favicon-kine.png?v=2') }}">

<link rel="preconnect" href="https://fonts.bunny.net">
<link href="https://fonts.bunny.net/css?family=nunito-sans:300,400,600,700&display=swap" rel="stylesheet" />
<link href="https://www.dafont.com/arsenica.font" rel="stylesheet" />

@vite(['resources/css/app.css', 'resources/js/app.js'])
@fluxAppearance
