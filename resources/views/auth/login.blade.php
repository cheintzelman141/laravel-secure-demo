<!doctype html>
<html>
<head><meta charset="utf-8"><title>Demo Login</title></head>
<body style="font-family: sans-serif; max-width: 640px; margin: 40px auto;">
  <h1>Demo Login</h1>

  <p><strong>Demo accounts:</strong></p>
  <ul>
    <li>user@example.com / password</li>
    <li>admin@example.com / password</li>
  </ul>

  @if ($errors->any())
    <div style="color: darkred;">
      {{ $errors->first() }}
    </div>
  @endif

  <form method="POST" action="{{ route('login.do') }}">
    @csrf
    <div>
      <label>Email</label><br>
      <input name="email" style="width: 100%; padding: 8px;">
    </div>
    <div style="margin-top: 10px;">
      <label>Password</label><br>
      <input name="password" type="password" style="width: 100%; padding: 8px;">
    </div>
    <button style="margin-top: 12px; padding: 10px 14px;">Login</button>
  </form>
</body>
</html>
