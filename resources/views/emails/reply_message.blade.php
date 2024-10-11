<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Balasan Pesan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .email-container {
            width: 100%;
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ddd;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #1E88E5;
            padding-bottom: 20px;
            margin-bottom: 20px;
        }
        .header img {
            width: 100px;
            height: auto;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            color: #333;
        }
        .content {
            line-height: 1.6;
            color: #333;
        }
        .content h3 {
            color: #1E88E5;
        }
        .footer {
            margin-top: 30px;
            font-size: 12px;
            color: #888;
            text-align: center;
        }
    </style>
</head>
<body>

    <div class="email-container">
        <!-- Bagian Header dengan logo dan nama dinas -->
        <div class="header">
            {{-- <img src="{{ asset('/uploads/logo-parpora.ico') }}" alt="Logo Dinas"> --}}
            <h1>Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung</h1>
        </div>

        <!-- Bagian konten balasan email -->
        <div class="content">
            <p>Halo {{ $name }},</p>

            <p>Terima kasih telah menghubungi kami. Berikut adalah balasan dari pesan yang Anda kirimkan:</p>

            <h3>Subjek: {{ $subject }}</h3>
            <p>{{ $reply }}</p>

            <p>Salam hormat,</p>
            <p>Dinas Pariwisata Pemuda dan Olahraga Kabupaten Sijunjung</p>
        </div>

        <!-- Bagian footer -->
        <div class="footer">
            <p>Ini adalah email otomatis, mohon jangan membalas email ini. Jika ada pertanyaan tambahan silahkan masukan pada halaman hubungi kami di website <a href="https://disparpora.sijunjung.go.id/">disparpora.sijunjung.go.id</a></p>
        </div>
    </div>

</body>
</html>
