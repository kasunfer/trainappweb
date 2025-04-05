@extends('admin.layouts.app')
@section('content')
<div class="pagetitle">
  <h1>Dashboard</h1>
  <nav>
    <ol class="breadcrumb">
      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
      <li class="breadcrumb-item active">Dashboard</li>
    </ol>
  </nav>
</div><!-- End Page Title -->

<section class="section dashboard">
  <div class="row">
    <div class="col-lg-12">
      <div class="row">

        <!-- Sales Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card sales-card">
            <div class="card-body">
              <h5 class="card-title">Today Booked</h5>
              @php
              $today = Carbon\Carbon::today();
              $todayBookingCount = App\Models\Booking::whereDate('created_at', $today)->count();
              $todayVerifiedBookingCount = App\Models\Booking::whereDate('created_at', $today)->where('verified',1)->count();
              $uniqueVisitCount = App\Models\Booking::distinct('phone_number')->count('phone_number');
              @endphp
              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-receipt"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$todayBookingCount}}</h6>
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Sales Card -->

        <!-- Revenue Card -->
        <div class="col-xxl-4 col-md-6">
          <div class="card info-card revenue-card">
            <div class="card-body">
              <h5 class="card-title">Today Verified Bookings</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-receipt"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$todayVerifiedBookingCount}}</h6>
                </div>
              </div>
            </div>

          </div>
        </div><!-- End Revenue Card -->

        <!-- Customers Card -->
        <div class="col-xxl-4 col-xl-12">

          <div class="card info-card customers-card">
            <div class="card-body">
              <h5 class="card-title">Passengers Visited</h5>

              <div class="d-flex align-items-center">
                <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                  <i class="bi bi-people"></i>
                </div>
                <div class="ps-3">
                  <h6>{{$uniqueVisitCount}}</h6>
                </div>
              </div>

            </div>
          </div>

        </div><!-- End Customers Card -->

        <!-- Reports -->
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">This Month Bookings</span></h5>

              <canvas id="monthlybooking" style="width: 50%; height:200px;"></canvas>

            </div>
          </div>
        </div>
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Year Wise Bookings</span></h5>

              <canvas id="annualBookingChart" style="width: 50%; height:200px;"></canvas>

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  $(document).ready(function() {
    const days = @json($days);
    const counts = @json($counts);
    const ctx = document.getElementById('monthlybooking').getContext('2d');
    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, 'rgba(98, 157, 233, 0.6)');
    gradient.addColorStop(1, 'rgba(98, 157, 233, 0.1)');

    const monthlyBookingChart = new Chart(ctx, {
      type: 'bar',
      data: {
        labels: days,
        datasets: [{
          label: 'Bookings',
          data: counts,
          borderColor: '#629de9',
          backgroundColor: gradient,
          fill: true,
          tension: 0.4
        }]
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            display: true
          },
          tooltip: {
            mode: 'index',
            intersect: false
          }
        },
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });


const months = @json($months);
const countsYear = @json($yearcounts);
const allMonths = [
    'January', 'February', 'March', 'April', 'May', 'June',
    'July', 'August', 'September', 'October', 'November', 'December'
];

let orderedMonths = allMonths;
let orderedCounts = new Array(12).fill(0);

months.forEach((month, index) => {
    const monthIndex = allMonths.indexOf(month);
    orderedCounts[monthIndex] = countsYear[index];
});

const ctxyear = document.getElementById('annualBookingChart').getContext('2d');
const annualBookingChart = new Chart(ctxyear, {
    type: 'line',
    data: {
        labels: orderedMonths,
        datasets: [{
            label: 'Bookings',
            data: orderedCounts,
            borderColor: '#629de9',
            backgroundColor: 'rgba(98, 157, 233, 0.2)',
            borderWidth: 1,
            fill: true,
            tension: 0.5
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            },
            tooltip: {
                mode: 'index',
                intersect: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
  });
</script>
@endpush