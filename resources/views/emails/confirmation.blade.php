<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pesan Anda</title>
</head>
<body>
    <h2>Terima kasih, {{ $name }}</h2>
    <p>Pesan Anda telah berhasil kami terima. Kami akan segera menghubungi Anda untuk memberikan respon terhadap pesan ini.</p>
    <p>Detail pesan yang Anda kirimkan:</p>
    <ul>
        <li><strong>Nama:</strong> {{ $name }}</li>
        <li><strong>Email:</strong> {{ $email }}</li>
        <li><strong>Subjek:</strong> {{ $subject }}</li>
        <li><strong>Pesan:</strong> {!! nl2br(e($message)) !!}</li>
        
        @if ($file_path && $file_path != 'noimage.jpg')
            <li><strong>File yang diunggah:</strong> <a href="{{ asset($file_path) }}">Download File</a></li>
        @else
            <li><strong>File yang diunggah:</strong> Tidak ada file yang diunggah.</li>
        @endif
    </ul>
    <p>Terima kasih telah menghubungi kami.</p>
</body>
</html>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Email</title>
</head>
<body>
    <h2>Halo, {{ $message->name }}</h2>
    <p>Terima kasih atas pesan Anda.</p>
    <p>Ini adalah email konfirmasi bahwa pesan Anda sudah kami terima. Kami akan membalas pesan Anda melalui email ini.</p>
    <p>Detail pesan yang Anda kirimkan:</p>
    <ul>
        <li><strong>Nama:</strong> {{ $message->name }}</li>
        <li><strong>Email:</strong> {{ $message->email }}</li>
        <li><strong>Subjek:</strong> {{ $message->subject }}</li>
        <li><strong>Pesan:</strong> {!! nl2br(e($message->message)) !!}</li>
        
        @if ($file_path && $file_path != 'noimage.jpg')
            <li><strong>File yang diunggah:</strong> <a href="{{ asset($file_path) }}">Download File</a></li>
        @else
            <li><strong>File yang diunggah:</strong> Tidak ada file yang diunggah.</li>
        @endif
    </ul>
    <p>Terima kasih telah menghubungi kami.</p>
</body>
</html>

