<!doctype html>
<html>
<head><meta charset="utf-8"><title>Profile</title></head>
<body style="font-family: sans-serif; max-width: 700px; margin: 40px auto;">
  <h1>Profile</h1>

  <p>Logged in as: <strong>{{ $user->email }}</strong></p>
  <p>Current role: <strong>{{ $user->role }}</strong></p>

  @if (session('status'))
    <div style="color: green;">{{ session('status') }}</div>
  @endif

  <form method="POST" action="{{ route('profile.update') }}">
    @csrf
    @method('PATCH')

    <div>
      <label>Name</label><br>
      <input name="name" value="{{ $user->name }}" style="width: 100%; padding: 8px;">
    </div>

    <div style="margin-top: 10px;">
      <label>Email</label><br>
      <input name="email" value="{{ $user->email }}" style="width: 100%; padding: 8px;">
    </div>

    <button style="margin-top: 12px; padding: 10px 14px;">Save</button>
  </form>

  <p style="margin-top: 18px;">
    <a href="{{ route('admin') }}">Go to /admin</a> |
    <a href="{{ route('logout') }}">Logout</a>
  </p>
</body>
</html>
