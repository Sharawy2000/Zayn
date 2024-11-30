<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
  <title>Login - Clothes E-Commerce</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      background: linear-gradient(135deg, #ff9a9e, #fad0c4);
    }
    .form-container {
      background: #fff;
      padding: 30px 40px;
      border-radius: 15px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
      max-width: 500px;
      width: 100%;
      text-align: center;
    }
    .form-container h2 {
      font-size: 2rem;
      color: #333;
      margin-bottom: 20px;
    }
    .form-container label {
      font-size: 1rem;
      color: #555;
      display: block;
      text-align: left;
      margin-bottom: 8px;
    }
    .form-container input {
      width: 100%;
      padding: 12px;
      margin-bottom: 20px;
      border: 1px solid #ddd;
      border-radius: 8px;
      font-size: 1rem;
      outline: none;
      transition: border 0.3s ease;
    }
    .form-container input:focus {
      border-color: #ff6f61;
    }
    .form-container button {
      width: 100%;
      padding: 12px;
      border: none;
      border-radius: 8px;
      font-size: 1.2rem;
      font-weight: bold;
      background: linear-gradient(135deg, #ff6f61, #ff9068);
      color: #fff;
      cursor: pointer;
      transition: transform 0.3s ease;
    }
    .form-container button:hover {
      transform: translateY(-3px);
    }
    .form-container p {
      margin-top: 10px;
      font-size: 0.9rem;
    }
    .form-container a {
      color: #ff6f61;
      text-decoration: none;
      font-weight: bold;
      transition: color 0.3s ease;
    }
    .form-container a:hover {
      color: #ff9068;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2>Login</h2>
    @include('inc.success-error-msg')
    <form action="{{ route('postSignIn') }}" method="POST">
      @csrf
      <label for="email">Phone</label>
      
      <input type="text" id="phone" name="phone" placeholder="Enter your phone" style="@error('phone') border: 1px solid red; @enderror" required>
      <label for="password">Password</label>
      
      <input type="password" id="password" name="password" placeholder="Enter your password" style="@error('password') border: 1px solid red; @enderror" required>
      <button type="submit">Login</button>
      <p>Don't have an account? <a href="{{ route('getSignUp') }}">Register here</a></p>
    </form>
  </div>
</body>
</html>
