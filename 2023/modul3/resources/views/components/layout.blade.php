<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title }} - LKS Jabar Juara 2023</title>
    @vite('resources/js/app.js')
</head>
<body class="d-flex flex-column min-vh-100">
  <main class="container">
    <x-navigation />
    <x-signed-in-status />
    {{ $slot }}
  </main>
  <x-footer />
</body>
</html>
