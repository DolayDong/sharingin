<!DOCTYPE html>
<html lang="en">
<head>
<style>
    button {
        background-color: purple;
        color: white;
        border-radius: 25px;
        border: 1px solid rgb(221, 221, 221);
        outline: none;
    }
</style>
</head>
<body>
    
    <h3>Hallo {{ $username }}</h3>
    <hr>
<p> <strong><i>Perhatian!!!</i></strong> isi email ini hanya akan berlaku selama 45 menit kedepan. Jika anda melakukan aktivasi lebih dari waktu yang ditentukan maka anda harus melakukan registrasi ulang. Silahkan klik aktivasi untuk mengaktifkan akun {{ $appname }} anda, <a href="{{url('')}}/verifikasi_?email={{ $email }}&token={{$token}}"><button>Aktifasi</button></a></p>

<br>
<br>
<br>
<strong>Salam</strong><br>
<i>Team KKI Kelompok V</i>
</body>
</html>
