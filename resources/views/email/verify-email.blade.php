<h2>Verifikasi Email</h2>

<p>Halo {{ $user->name }},</p>

<p>Silakan klik link berikut untuk verifikasi email kamu:</p>

<a href="{{ $verificationUrl }}">
    Verifikasi Email
</a>

<p>Jika kamu tidak merasa mendaftar, abaikan email ini.</p>