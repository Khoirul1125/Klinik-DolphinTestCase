<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  @php
  // Mengambil data menggunakan model Webset
     $setweb = App\Models\setweb::first(); // Anda bisa sesuaikan query ini dengan kebutuhan Anda
 @endphp
     <title>{{  $setweb->name_app }}</title>

  <!-- Brand Logo -->
     <!-- Favicon untuk browser standar -->
     <link rel="icon"sizes="180x180" type="image/x-icon" href="{{ asset('webset/' . $setweb->logo_app) }}">

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css')}}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css')}}">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">
</head>
<body class="hold-transition login-page">
    @yield('content')
<!-- /.login-box -->

<?php
// Fungsi untuk membuat string error dari array error
if (!function_exists('createErrorStringHelper')) {
    /**
     * Membuat string error dari array error.
     *
     * @param array $errors
     * @return string
     */
    function createErrorStringHelper(array $errors): string {
        if (!empty($errors)) {
            // Gabungkan semua pesan error menjadi satu string dan escape untuk HTML
            return htmlspecialchars(implode(' ', $errors), ENT_QUOTES, 'UTF-8');
        }
        return '';
    }
}

// Fungsi untuk membuat string error untuk username, email, password
if (!function_exists('createErrorString')) {
    /**
     * Membuat string error untuk setiap field (username, email, password).
     *
     * @param object $errors (misalnya Illuminate\Support\MessageBag dari Laravel)
     * @return array
     */
    function createErrorString($errors): array {
        // Ambil pesan error untuk setiap field
        $usernameErrors = $errors->get('username') ?? [];
        $emailErrors = $errors->get('email') ?? [];
        $passwordErrors = $errors->get('password') ?? [];

        // Gunakan helper untuk membuat string error
        $usernameErrorString = createErrorStringHelper($usernameErrors);
        $emailErrorString = createErrorStringHelper($emailErrors);
        $passwordErrorString = createErrorStringHelper($passwordErrors);

        // Kembalikan array error string untuk masing-masing field
        return [
            'username' => $usernameErrorString,
            'email' => $emailErrorString,
            'password' => $passwordErrorString,
        ];
    }
}

$errorStrings = createErrorString($errors);
?>



<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('dist/js/adminlte.min.js')}}"></script>
<!-- SweetAlert2 -->
<script src="{{ asset('plugins/sweetalert2/sweetalert2.min.js') }}"></script>
<!-- Page specific script -->
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 10000,
        timerProgressBar: true
    });

    document.addEventListener('DOMContentLoaded', function() {
    if ("{{ session('success') }}") {
        Toast.fire({
            icon: 'success',
            title: "{{ session('success') }}"
        });
    }

    if ("{{ session('error') }}") {
        Toast.fire({
            icon: 'error',
            title: "{{ session('error') }}"
        });
    }

    if ("{{session('status') == 'verification-link-sent'}}"){
        Toast.fire({
        icon: 'success',
        title: 'A new verification link has been sent to the email address you provided during registration.'
        });
    }
    });
</script>
<script>
    // Display Toast for username errors
    <?php if (!empty($errorStrings['username'])): ?>
        Toast.fire({
            icon: 'error',
            title: <?= json_encode($errorStrings['username']); ?>
        });
    <?php endif; ?>

    // Display Toast for email errors
    <?php if (!empty($errorStrings['email'])): ?>
        Toast.fire({
            icon: 'error',
            title: <?= json_encode($errorStrings['email']); ?>
        });
    <?php endif; ?>

    // Display Toast for password errors
    <?php if (!empty($errorStrings['password'])): ?>
        Toast.fire({
            icon: 'error',
            title: <?= json_encode($errorStrings['password']); ?>
        });
    <?php endif; ?>
</script>


</body>
</html>
