<!DOCTYPE html>
@inject('country', 'App\Models\Country')
@inject('city', 'App\Models\City')
@inject('neighborhood', 'App\Models\Neighborhood')
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register - Clothes E-Commerce</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #89f7fe, #66a6ff);
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }

    .form-container {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 6px 15px rgba(0, 0, 0, 0.2);
      width: 100%;
      max-width: 700px; /* Adjusted for wider form */
    }

    .form-container h2 {
      font-size: 1.5rem;
      margin-bottom: 15px;
      text-align: center;
      color: #333;
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-size: 0.85rem;
      color: #555;
    }

    input, select, button {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 0.9rem;
    }

    input:focus, select:focus {
      border-color: #007aff;
    }

    button {
      background: linear-gradient(135deg, #007aff, #00c6ff);
      color: white;
      font-weight: bold;
      cursor: pointer;
      border: none;
      transition: transform 0.3s;
    }

    button:hover {
      transform: translateY(-2px);
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr 1fr; /* Two columns */
      gap: 20px;
    }

    .form-row input,
    .form-row select {
      width: 100%;
    }

    .form-row .full-width {
      grid-column: span 2; /* Full-width input for fields like password confirmation */
    }

    p {
      text-align: center;
      font-size: 0.85rem;
    }

    p a {
      color: #007aff;
      text-decoration: none;
      font-weight: bold;
    }

    p a:hover {
      color: #00c6ff;
    }

    .error {
      color: red;
      font-size: 12px;
      margin-bottom: 5px;
      display: block;
    }
  </style>
</head>
<body>
  <div class="form-container">
    <h2><strong>SignUp</strong> </h2>
    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif
    <form action="{{ route('postSignUp') }}" method="POST">
      @csrf

      <div class="form-row">
        <div>
          <label for="name">Full Name</label>
          @error('name')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="text" id="name" name="name" placeholder="Enter your full name" style="@error('name') border: 1px solid red; @enderror" required>
        </div>

        <div>
          <label for="phone">Phone</label>
          @error('phone')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="text" id="phone" name="phone" placeholder="Enter your phone" style="@error('phone') border: 1px solid red; @enderror" required >
        </div>
      </div>

      <div class="form-row">
        <div class="full-width">
          <label for="email">Email</label>
          @error('email')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="email" id="email" name="email" placeholder="Enter your email" style="@error('email') border: 1px solid red; @enderror" required>
        </div>
      </div>

      <div class="form-row">
        <div>
          <label for="password">Password</label>
          @error('password')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="password" id="password" name="password" placeholder="Enter your password" style="@error('password') border: 1px solid red; @enderror" required >
        </div>
        <div>
          <label for="confirm_password">Confirm Password</label>
          @error('password_confirmation')
            <span class="error">{{ $message }}</span>
          @enderror
          <input type="password" id="confirm_password" name="password_confirmation" placeholder="Confirm your password" style="@error('password_confirmation') border: 1px solid red; @enderror" required >
        </div>
      </div>
      <div class="form-row">
        <div>
          <label for="countries">Country</label>
          @error('country_id')
            <span class="error">{{ $message }}</span>
          @enderror
          <select id="countries" name="country_id" style="@error('country_id') border: 1px solid red; @enderror" required>
            <option value="" selected disabled>Select Country</option>
            @foreach ($country->all() as $country)
              <option value="{{ $country->id }}">{{ $country->name }}</option>
            @endforeach
          </select>
        </div>

        <div>
          <label for="city">City</label>
          @error('city_id')
            <span class="error">{{ $message }}</span>
          @enderror
          <select id="cities" name="city_id" style="@error('city_id') border: 1px solid red; @enderror" required>
            <option value="" selected disabled>Select City</option>
          </select>
        </div>
      </div>

      <div class="form-row">
        <div class="full-width">
          <label for="neighborhoods">Neighborhood</label>
          @error('neighborhood_id')
            <span class="error">{{ $message }}</span>
          @enderror
          <select id="neighborhoods" name="neighborhood_id" style="@error('neighborhood_id') border: 1px solid red; @enderror" required>
            <option value="" selected disabled>Select Neighborhood</option>
          </select>
        </div>
      </div>

      <button type="submit">Create</button>
      <p>Already have an account? <a href="{{ route('getSignIn') }}">Login here</a></p>
    </form>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script>
    $(document).ready(function() {
      $("#countries").change(function(e) {
        e.preventDefault();
        var country_id = $(this).val();
        if (country_id) {
          $.ajax({
            url: "http://zain.test/v1/get-cities/" + country_id,
            type: "GET",
            success: function(response) {
              if (response.status === 200) {
                $("#cities").empty();
                $("#cities").append('<option value="" selected disabled>Select City</option>');
                $("#neighborhoods").empty();
                $("#neighborhoods").append('<option value="" selected disabled>Select Neighborhood</option>');
                $.each(response.data, function(key, city) {
                  $("#cities").append('<option value="' + city.id + '">' + city.name + "</option>");
                });
              }
            }
          });
        } else {
          $("#cities").empty();
          $("#cities").append('<option value="" selected disabled>Select City</option>');
        }
      });

      $("#cities").change(function(e) {
        e.preventDefault();
        var city_id = $(this).val();
        if (city_id) {
          $.ajax({
            url: "http://zain.test/v1/get-neighborhoods/" + city_id,
            type: "GET",
            success: function(response) {
              if (response.status === 200) {
                $("#neighborhoods").empty();
                $("#neighborhoods").append('<option value="" selected disabled>Select Neighborhood</option>');
                $.each(response.data, function(key, city) {
                  $("#neighborhoods").append('<option value="' + city.id + '">' + city.name + "</option>");
                });
              }
            }
          });
        } else {
          $("#neighborhoods").empty();
          $("#neighborhoods").append('<option value="" selected disabled>Select Neighborhood</option>');
        }
      });
    });
  </script>
</body>
</html>
