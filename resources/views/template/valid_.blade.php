<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Selamat</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>
<body>
    <script>
        Swal.fire({
        icon: 'success',
        title: 'Selamat!',
        text: 'akun dengan email {{$email}} berhasil di aktivasi, silahkan login',
        showDenyButton: false,
        showCancelButton: false,
        confirmButtonText: `Ok`,
        allowOutsideClick: false,
        allowEscapeKey: false,
        allowEnterKey: false
        }).then((result) => {
        if (result.isConfirmed) {
            document.location.href = '{{url('/')}}'
        } 
        })
    </script>
    
</body>
</html>