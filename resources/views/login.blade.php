<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Login</title>
  @vite(['resources/css/login.css', 'resources/js/login.js'])
  <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
</head>
<body>
  <div class="login-container">
    <!-- Left side: Branding -->
    <div class="branding">
      <div class="branding-content">
        <div class="logo">
          <img src="{{ Vite::asset('resources/images/logoPplWorks.png') }}" alt="PeopleWorks Logo">
        </div>
        <h1 class="headline">
            <span class="highlight">Experience the Future of</span><br>
            <span class="accent">Enterprise Productivity</span>
          </h1>
          <p class="description">
            An AI-powered enterprise platform for service, workforce, sales, and support operations —
            unified through <span class="emphasis">automation</span> and <span class="emphasis">real-time intelligence</span>.
          </p>

      </div>
    </div>

    <!-- Right side: Login form -->
    <div class="login-form">
      <div class="form-card">
        <h2>Sign In</h2>

        @if(session('error'))
          <div class="alert error">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.attempt') }}" method="POST">
          @csrf

          <div class="form-group">
            <label for="user_id">User Name</label>
            <input type="text" id="user_id" name="user_id" required />
          </div>

          <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required />
          </div>

          <div class="form-options">
            <label>
              <input type="checkbox" name="remember" /> Remember Me
            </label>

          </div>

          <button type="submit" class="btn-primary">LOG IN</button>

          <div class="privacy-link">
            <a href="/privacy-policy">Privacy Policy</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
