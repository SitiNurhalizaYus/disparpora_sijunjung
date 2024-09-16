<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verifikasi Email</title>
</head>
<body>
    <h1>Verifikasi Email Anda</h1>
    <p>Klik tautan berikut untuk memverifikasi email Anda:</p>
    <a href="{{ url('/api/verify/' . $id . '?token=' . $token) }}">Verifikasi Email</a>
</body>
</html>
