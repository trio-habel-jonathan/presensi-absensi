<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login - Argon Dashboard</title>
  <!-- CSS dan asset lain -->
  <link href="assets/css/argon-dashboard.css" rel="stylesheet" />
</head>
<body class="{{ $class ?? '' }}">
  <main class="main-content mt-0">
    @yield('content')
  </main>

  <!-- Script dasar -->
  <script src="assets/js/core/popper.min.js"></script>
  <script src="assets/js/core/bootstrap.min.js"></script>
  <script src="assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="assets/js/argon-dashboard.js"></script>
  @stack('js')
</body>
</html>
