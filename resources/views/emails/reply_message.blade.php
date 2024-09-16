<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan</title>
</head>
<body style="font-family: Arial, sans-serif;">

    <h2 style="color: #1E88E5;">Balasan dari Dinas Pariwisata Pemuda dan Olahraga Kab. Sijunjung</h2>

    <p>Halo {{ $name }},</p>

    <p>Terima kasih telah menghubungi kami. Berikut adalah balasan dari pesan yang Anda kirimkan:</p>

    <h3 style="color: #1E88E5;">Subjek: {{ $subject }}</h3>

    <p>{{ $reply }}</p>

    <p>Salam hormat,</p>
    <p>Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung</p>

    <footer style="margin-top: 30px; color: #888;">
        <p>Ini adalah email otomatis, mohon jangan membalas email ini. Jika ada pertanyaan tambahan silahkan masukan pada halaman hubungi kami di website https://disparpora.sijunjung.go.id/</p>
    </footer>

</body>
</html>
