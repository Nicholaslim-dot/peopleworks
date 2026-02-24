@extends('layouts.app')

@section('content')
  <div class="container mt-4">

    <!-- My Workload Summary -->
    <h4>My Workload</h4>
    <div class="row">
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-primary summary-card">
          <div class="card-header">Total Case Created This Month</div>
          <div class="card-body text-center"><h5 class="card-title">120</h5></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-secondary summary-card">
          <div class="card-header">Total Case Closed This Month</div>
          <div class="card-body text-center"><h5 class="card-title">98</h5></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-success summary-card">
          <div class="card-header">Total Lognote for This Month</div>
          <div class="card-body text-center"><h5 class="card-title">85</h5></div>
        </div>
      </div>
    </div>

    <!-- Additional summary row -->
    <div class="row mt-3">
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-dark">
          <div class="card-header">Last Month Created</div>
          <div class="card-body text-center"><h5 class="card-title">85</h5></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-info">
          <div class="card-header">Last Month Case Closed</div>
          <div class="card-body text-center"><h5 class="card-title">85</h5></div>
        </div>
      </div>
      <div class="col-sm-12 col-md-4 mb-3">
        <div class="card text-white bg-warning">
          <div class="card-header">Total CDax Case Close</div>
          <div class="card-body text-center"><h5 class="card-title">85</h5></div>
        </div>
      </div>
    </div>

    <!-- All Case(s) Real-Time -->
    <div class="card mt-4">
      <div class="card-header bg-info text-white">All Case(s) (Dashboard Real Time)</div>
      <div class="card-body">
        <ul class="list-group">
          <li class="list-group-item">Today New Case(s): <strong>40</strong></li>
          <li class="list-group-item">Total Pending Close Case: <strong>10</strong></li>
          <li class="list-group-item">Yesterday Case(s): <strong>1</strong></li>
          <li class="list-group-item">Yesterday Close Case: <strong>1</strong></li>
          <li class="list-group-item">
            <h5 class="mt-3">Aging Case more than</h5>
            <div class="table-responsive">
              <table class="table table-bordered text-center">
                <thead class="thead-light">
                  <tr>
                    <th></th>
                    <th>4 Days</th>
                    <th>8 Days</th>
                    <th>12 Days</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>Count</td>
                    <td>4</td>
                    <td>5</td>
                    <td>7</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </li>
          <li class="list-group-item">Case No Update: <strong>10</strong></li>
          <li class="list-group-item">Engineer On Leave: <strong>1</strong></li>
        </ul>
      </div>
    </div>

    <!-- Branch Cases Table -->
<h4 class="mt-5">Branch Cases (Dashboard Real Time)</h4>
<div class="table-responsive">
  <table class="table table-bordered table-striped text-center">
    <thead class="thead-dark">
      <tr>
        <th rowspan="2">State</th>
        <th colspan="3">Total Cases</th>
        <th colspan="4">Aging cases over</th>
      </tr>
      <tr>
        <th>Today</th>
        <th>Yesterday</th>
        <th>Pending Close</th>
        <th>Pending to Close</th>
        <th>4 Days</th>
        <th>8 Days</th>
        <th>12 Days</th>
      </tr>
    </thead>
    <tbody>
      <tr><td>Kedah</td><td>10</td><td>5</td><td>1</td><td>1</td><td>2</td><td>5</td><td>3</td></tr>
      <tr><td>Penang</td><td>20</td><td>10</td><td>5</td><td>1</td><td>3</td><td>6</td><td>4</td></tr>
      <tr><td>Perak</td><td>10</td><td>5</td><td>4</td><td>1</td><td>1</td><td>7</td><td>2</td></tr>
      <tr><td>KL</td><td>45</td><td>45</td><td>1</td><td>5</td><td>6</td><td>8</td><td>7</td></tr>
      <tr><td>Kelantan</td><td>2</td><td>1</td><td>1</td><td>9</td><td>3</td><td>2</td><td>1</td></tr>
      <tr><td>Terengganu</td><td>3</td><td>2</td><td>0</td><td>1</td><td>7</td><td>10</td><td>4</td></tr>
      <tr><td>Pahang</td><td>5</td><td>3</td><td>1</td><td>1</td><td>5</td><td>11</td><td>6</td></tr>
    </tbody>
  </table>
</div>

<!-- Search & Export Tools -->
<div class="mt-4">
  <h4>Engineer Case Summary (Quick View)</h4>

  <!-- Custom Filters -->
  <div class="form-inline mb-3">
    <select id="statusFilter" class="form-control mr-2">
      <option value="">All Status</option>
      <option value="Pending Cases">Pending Cases</option>
      <option value="Resolved">Resolved</option>
      <option value="Revisit">Revisit</option>
    </select>
    <input id="engineerFilter" type="text" class="form-control mr-2" placeholder="Search engineer">
  </div>

  <!-- Engineer Case Summary Table -->
  <div class="table-responsive">
    <table id="engineerTable" class="table table-bordered table-striped text-center">
      <thead class="thead-dark">
        <tr>
          <th rowspan="2">Engineer</th>
          <th rowspan="2">Case ID</th>
          <th rowspan="2">Case Status</th>
          <th colspan="2">CDaX Action Needed</th>
          <th rowspan="2">Done</th>
        </tr>
        <tr>
          <th>Action Taken (c)</th>
          <th>Log Note (c)</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>Lam</td>
          <td><a href="#">123456789</a></td>
          <td>Pending Cases</td>
          <td>Engineer action taken / log note shown here</td>
          <td>sdfdsff</td>
          <td>✔</td>
        </tr>
        <tr>
          <td>Wong</td>
          <td><a href="#">987654321</a></td>
          <td>Resolved</td>
          <td>Waiting for update</td>
          <td></td>
          <td></td>
        </tr>
        <tr>
          <td>Keith</td>
          <td><a href="#">456789123</a></td>
          <td>Revisit</td>
          <td>Parts ordered</td>
          <td>Follow-up scheduled</td>
          <td>✔</td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection






