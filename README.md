🔐 Laravel Secure Demo – Mass Assignment Privilege Escalation

This repository demonstrates a realistic Laravel application vulnerability where improper mass assignment allows a normal user to escalate privileges by modifying protected fields (e.g., role=admin) during a profile update.

The project includes:

a vulnerable implementation (vulnerable branch)

a secure remediation (main branch)

clear exploit steps

a regression test and CI guardrails (in the secure branch)

This mirrors real-world AppSec work: identify → exploit → fix → prevent regression.

🧠 Vulnerability Overview

Category:

OWASP Top 10: A01 – Broken Access Control

CWE-915 – Improperly Controlled Modification of Dynamically-Determined Object Attributes (Mass Assignment)

Root Cause:
The profile update endpoint blindly passes user-controlled input into an ORM update call:

$user->update($request->all());


Combined with a permissive model configuration, this allows attackers to update security-sensitive fields not intended to be user-controlled.

🎯 Impact

A standard authenticated user can:

escalate their role to admin

gain access to admin-only functionality

bypass authorization checks that rely on role-based logic

This class of issue has led to real-world fraud, data exposure, and account takeover incidents.

🧪 Demo Accounts (Local)
Role	Email	Password
User	user@example.com
	password
Admin	admin@example.com
	password
🚨 How to Exploit (Vulnerable Branch)

Branch: vulnerable

Login at:

/login


Navigate to profile edit:

/profile


Intercept the request:

Method: PATCH

Endpoint: /profile

Tool: Burp Suite or similar

Modify the request body to include:

role=admin


Forward the request.

Visit:

/admin


✅ Access is granted as a non-admin user.

🔎 Relevant Code (Vulnerable)

app/Http/Controllers/ProfileController.php

app/Models/User.php

routes/web.php

Key issue:

Mass assignment of untrusted input

No allowlist of permitted fields

No defense-in-depth protections

🛡️ Secure Implementation

Branch: main

The secure version remediates the issue using defense-in-depth, not a single fix:

1. Model Protection

Sensitive fields are no longer mass assignable.

protected $fillable = ['name', 'email'];

2. Allowlisted Input

Only expected fields are accepted from the request.

$request->only(['name', 'email']);

3. Validation via Form Request

Centralized validation prevents unexpected input from being processed.

4. Authorization Logic

Security-sensitive attributes are never derived from client input.

5. Regression Test

A PHPUnit test ensures:

role cannot be modified via the profile endpoint

privilege escalation attempts fail consistently

6. CI Guardrails

The secure branch includes:

automated tests

Semgrep SAST scanning

CI failure on regression

This prevents the vulnerability from being reintroduced.

⚙️ Local Setup (Optional)
git clone https://github.com/<your-username>/laravel-secure-demo.git
cd laravel-secure-demo

composer install
cp .env.example .env
php artisan key:generate

touch database/database.sqlite
php artisan migrate
php artisan db:seed

php artisan serve

💼 Why This Project Exists

This demo reflects real Application Security work, not a lab exercise:

finding exploitable vulnerabilities in real frameworks

understanding root causes, not just symptoms

implementing fixes that scale

preventing recurrence with tests and CI

collaborating with developers instead of throwing tickets over the wall

I learned security the hard way in production. This project shows how I now formalize and automate those lessons.

⚠️ Disclaimer

This repository contains intentionally vulnerable code for educational and demonstration purposes only.
Do not deploy this application in production.

📌 Next Steps in Portfolio

This project is part of a broader AppSec portfolio:

Laravel: Mass Assignment / Privilege Escalation (this repo)

Python (FastAPI): IDOR / Authorization Failures

Node (Express): Authorization / Input Trust Issues