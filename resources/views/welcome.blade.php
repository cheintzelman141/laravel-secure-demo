<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <title>Laravel Secure Demo – Mass Assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="font-family: system-ui, -apple-system, Segoe UI, Roboto, sans-serif; max-width: 900px; margin: 40px auto; line-height: 1.5;">
  <h1>Laravel Secure Demo: Mass Assignment → Privilege Escalation</h1>

  <p>
    This repo demonstrates a common Laravel vulnerability where a profile update endpoint
    improperly mass-assigns user input (e.g., <code>$user->update($request->all())</code>),
    allowing a normal user to escalate privileges by submitting <code>role=admin</code>.
  </p>

  <h2>Demo Accounts</h2>
  <ul>
    <li><strong>User</strong>: user@example.com / password</li>
    <li><strong>Admin</strong>: admin@example.com / password</li>
  </ul>

  <h2>How to Reproduce (Vulnerable Branch)</h2>
  <ol>
    <li>Login: <a href="/login">/login</a></li>
    <li>Go to Profile: <a href="/profile">/profile</a></li>
    <li>Intercept the <code>PATCH /profile</code> request in Burp (or use curl) and add <code>role=admin</code> to the form body</li>
    <li>Submit the modified request</li>
    <li>Visit <a href="/admin">/admin</a> (should now succeed)</li>
  </ol>

  <h2>Where to Look in Code</h2>
  <ul>
    <li><code>app/Http/Controllers/ProfileController.php</code> (vulnerable update)</li>
    <li><code>app/Models/User.php</code> (mass assignment configuration)</li>
    <li><code>routes/web.php</code> (routes + admin check)</li>
  </ul>

  <h2>Secure Version</h2>
  <p>
    The <strong>main</strong> branch fixes this using allowlisted inputs, model protection, validation,
    and a regression test to prevent reintroduction. See the README in the repo for the patch details.
  </p>

  <hr>
  <p style="color:#555;">
    Notes: This is an intentionally vulnerable demo for educational purposes.
  </p>
</body>
</html>
