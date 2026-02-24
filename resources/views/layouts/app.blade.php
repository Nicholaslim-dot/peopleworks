<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>IWork Portal</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

  <!-- DataTables Bootstrap 4 CSS -->
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="{{ homeRoute() }}">
        iWorks
    </a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <!-- Left side menu -->
      <ul class="navbar-nav mr-auto">
        @if(in_array(session('user_level'), ['Admin', 'Manager', 'Account']))
          <li class="nav-item"><a class="nav-link" href="{{ route('case.management') }}">Case Management</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Part Management</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('report.create') }}">Report</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('leave.review') }}">Leave Applications</a></li>
        @elseif(session('user_level') === 'CE')
          <li class="nav-item"><a class="nav-link" href="{{ route('leave.apply') }}">Apply Leave</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Part Management</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Portal</a></li>
          <li class="nav-item"><a class="nav-link" href="{{ route('report.create') }}">Report</a></li>
          <li class="nav-item"><a class="nav-link" href="#">Service Manual</a></li>
        @elseif(session('user_level') === 'Guest')
          <li class="nav-item"><a class="nav-link" href="#">Guest Dashboard</a></li>
        @else
          <li class="nav-item"><a class="nav-link" href="{{ route('report.create') }}">Report</a></li>
        @endif
      </ul>

      <!-- Right side: user + logout -->
      <ul class="navbar-nav ml-auto">
        @if(session('user_name'))
          @if(session('user_level') === 'CE')
              <li class="nav-item"><a class="nav-link" href="#">Network Status</a></li>
          @endif
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="userDropdown"
               role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              {{ session('user_name') }}
              <span class="badge badge-info">{{ session('user_level') }}</span>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
              <!-- ✅ Secure logout form -->
              <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="dropdown-item">Logout</button>
              </form>
            </div>
          </li>
        @endif
      </ul>

      <!-- Live Active Users + Clock -->
      <span class="navbar-text text-white ml-3">
        @if(in_array(session('user_level'), ['Admin', 'Manager', 'Account']))
          <span
            id="activeUsersWrapper"
            data-toggle="tooltip"
            data-html="true"
            title="
              @foreach($roleCounts ?? [] as $role => $count)
                {{ $role }}: {{ $count }}
                @if(!empty($roleUsers[$role]))
                  ({{ implode(', ', $roleUsers[$role]) }})
                @endif
                <br>
              @endforeach
            "
          >
            Total Users Logged In: <span id="activeUsers">{{ $activeUsers ?? 0 }}</span>
          </span>
          |
        @endif
          Time: <span id="currentTime">--:--</span> |
          Date: <span id="currentDate">--/--/----</span>
      </span>
    </div>
</nav>

<div class="container mt-4">
  @yield('content')
</div>

<!-- Core Scripts -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<!-- DataTables core + Bootstrap 4 integration JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>

<!-- Pushed scripts from views -->
@stack('scripts')

<!-- Enable Bootstrap tooltip + clock -->
<script>
  $(function () {
    $('[data-toggle="tooltip"]').tooltip();
  });

  function updateDateTime() {
      const now = new Date();
      document.getElementById('currentTime').innerText =
          now.toLocaleTimeString([], {hour: '2-digit', minute:'2-digit', second:'2-digit'});
      document.getElementById('currentDate').innerText =
          now.toLocaleDateString([], {year: 'numeric', month: 'long', day: 'numeric'});
  }
  setInterval(updateDateTime, 1000);
  updateDateTime();
</script>
</body>
</html>
