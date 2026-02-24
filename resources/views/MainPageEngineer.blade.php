@extends('layouts.app')

@section('content')
<div class="container mt-4">
  <!-- Current Month -->
  <h4>My Performance</h4>
  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <tbody>
        <tr>
          <td>Total of case Attend</td>
          <td id="totalAttend">10</td>
          <td>Escalation Case</td>
          <td id="escalationCase">1</td>
          <td>Productivity Ranking</td>
        </tr>
        <tr>
          <td>Total of case pending</td>
          <td id="totalPending">5</td>
          <td>Assist Case</td>
          <td id="assistCase">2</td>
          <td id="productivityRankingPending">1</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Previous Month -->
  <h4>Previous Month Performance</h4>
  <div class="table-responsive">
    <table class="table table-bordered text-center">
      <tbody>
        <tr>
          <td>Total of case Attend</td>
          <td id="prevTotalAttend">10</td>
          <td>Escalation Case</td>
          <td id="prevEscalationCase">0</td>
          <td>Productivity Ranking</td>
        </tr>
        <tr>
          <td>Total of case pending</td>
          <td id="prevTotalPending">5</td>
          <td>Assist Case</td>
          <td id="prevAssistCase">1</td>
          <td id="prevProductivityRankingPending">1</td>
        </tr>
      </tbody>
    </table>
  </div>

  <!-- Work Queue -->
  <h4 class="mt-4">My Work Queue</h4>
  <div class="table-responsive">
    <table id="workQueue" class="table table-bordered table-striped text-center">
      <thead class="thead-dark">
        <tr>
          <th>Case ID</th>
          <th>Customer</th>
          <th>Address</th>
          <th>Contact Number</th>
          <th>Case Aging</th>
          <th>Case Status</th>
          <th>Action Taken</th>
          <th>Log Note</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>12345678</td>
          <td>Tan ah kow</td>
          <td>jalan song song</td>
          <td>165235478</td>
          <td>2</td>
          <td>New</td>
          <td>replace hdd ok .</td>
          <td></td>
        </tr>
      </tbody>
    </table>
  </div>
</div>
@endsection

@push('scripts')
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<script>
  $(document).ready(function() {
    $('#workQueue').DataTable({
      pageLength: 20,
      lengthChange: false,
      ordering: true,
      searching: true
    });
  });

  // Echo listener for engineer dashboard updates
  Echo.channel('engineer-dashboard')
      .listen('.EngineerDashboardUpdated', (e) => {
        document.getElementById('totalAttend').innerText = e.payload.totalAttend;
        document.getElementById('totalPending').innerText = e.payload.totalPending;
        document.getElementById('escalationCase').innerText = e.payload.escalationCase;
        document.getElementById('assistCase').innerText = e.payload.assistCase;
        document.getElementById('productivityRankingPending').innerText = e.payload.productivityRankingPending;

        document.getElementById('prevTotalAttend').innerText = e.payload.prevTotalAttend;
        document.getElementById('prevTotalPending').innerText = e.payload.prevTotalPending;
        document.getElementById('prevEscalationCase').innerText = e.payload.prevEscalationCase;
        document.getElementById('prevAssistCase').innerText = e.payload.prevAssistCase;
        document.getElementById('prevProductivityRankingPending').innerText = e.payload.prevProductivityRankingPending;

        if (e.payload.newCase) {
          const newRow = `<tr>
            <td>${e.payload.newCase.case_id}</td>
            <td>${e.payload.newCase.customer}</td>
            <td>${e.payload.newCase.address}</td>
            <td>${e.payload.newCase.contact_number}</td>
            <td>${e.payload.newCase.aging}</td>
            <td>${e.payload.newCase.status}</td>
            <td>${e.payload.newCase.action_taken}</td>
            <td>${e.payload.newCase.log_note}</td>
          </tr>`;
          document.querySelector('#workQueue tbody').insertAdjacentHTML('afterbegin', newRow);
        }
      });
</script>
@endpush
