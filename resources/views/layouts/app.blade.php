<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $title ?? config('app.name') }}</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,500;12..96,700&family=Instrument+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('assets/css/app.css') }}">
</head>
<body class="{{ $bodyClass ?? '' }}">
@include('partials.icons')

<div class="app">
  @include('partials.sidebar')

  <div class="scrim" id="scrim"></div>

  <div class="main">
    @include('partials.topbar')

    {{ $slot }}
  </div>
</div>

@include('partials.toast')
@include('partials.confirm-delete')

<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('scripts')
</body>
</html>
