<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>

    @livewireStyles

</head>
<body>

  @yield('content')


<script src="{{ asset('plugins/chart.js/Chart.min.js')  }}"></script>
  @livewireScripts
  @stack('scripts')
  @yield("javascript")  
</body>
</html>