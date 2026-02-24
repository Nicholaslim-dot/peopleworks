<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>User Registration</title>
  {{-- Load CSS & JS via Vite --}}
  @vite(['resources/css/register.css', 'resources/js/register.js'])
</head>
<body>
  <div class="container">
    {{-- Logo --}}
    <div class="logo">
      <img src="{{ Vite::asset('resources/images/logoPplWorks.png') }}" alt="PeopleWorks Logo">
    </div>
    {{-- Success / Error messages --}}
    @if(session('success'))
      <div class="alert success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
      <div class="alert error">
        <ul>
          @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <div class="form-section">
        <h2>USER Registration</h2>

        <form action="{{ route('users.store') }}" method="POST" class="form-card">
          @csrf
          <div class="form-row">
            <label>User ID:</label>
            <input type="text" name="user_id" required />
          </div>

          <div class="form-row">
            <label>Password:</label>
            <input type="password" name="password" required />
          </div>

          <div class="form-row">
            <label>User Name:</label>
            <input type="text" name="user_name" required />
          </div>

          <div class="form-row">
            <label>Branch:</label>
            <input type="text" name="branch" required />
          </div>

          <div class="form-row">
            <label>User Level:</label>
            <select name="user_level">
              <option value="Admin">Admin</option>
              <option value="Manager">Manager</option>
              <option value="CE">CE</option>
              <option value="Account">Account</option>
              <option value="Guest">Guest</option>
            </select>
          </div>

          <button type="submit">Register</button>
        </form>
      </div>



    {{-- User Table --}}
    <div class="user-table">
      <h3>Registered Users</h3>
      <table>
        <thead>
          <tr>
            <th>No</th>
            <th>User ID</th>
            <th>User Name</th>
            <th>Branch</th>
            <th>User Level</th>
            <th>Delete</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $index => $user)
            <tr>
              <td>{{ $index + 1 }}</td>
              <td>{{ $user->user_id }}</td>
              <td>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <input type="text" name="user_name" value="{{ $user->user_name }}" onchange="this.form.submit()">
                  <input type="hidden" name="branch" value="{{ $user->branch }}">
                  <input type="hidden" name="user_level" value="{{ $user->user_level }}">
                </form>
              </td>
              <td>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <input type="text" name="branch" value="{{ $user->branch }}" onchange="this.form.submit()">
                  <input type="hidden" name="user_name" value="{{ $user->user_name }}">
                  <input type="hidden" name="user_level" value="{{ $user->user_level }}">
                </form>
              </td>
              <td>
                <form action="{{ route('users.update', $user->id) }}" method="POST">
                  @csrf
                  @method('PATCH')
                  <select name="user_level" onchange="this.form.submit()">
                    <option value="Admin" {{ $user->user_level == 'Admin' ? 'selected' : '' }}>Admin</option>
                    <option value="Manager" {{ $user->user_level == 'Manager' ? 'selected' : '' }}>Manager</option>
                    <option value="CE" {{ $user->user_level == 'CE' ? 'selected' : '' }}>CE</option>
                    <option value="Account" {{ $user->user_level == 'Account' ? 'selected' : '' }}>Account</option>
                    <option value="Guest" {{ $user->user_level == 'Guest' ? 'selected' : '' }}>Guest</option>
                  </select>
                  <input type="hidden" name="user_name" value="{{ $user->user_name }}">
                  <input type="hidden" name="branch" value="{{ $user->branch }}">
                </form>
              </td>
              <td>
                <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn-danger">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
