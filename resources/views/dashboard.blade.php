@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row g-4">
        <!-- Total Products -->
        <div class="col-md-3">
            <div class="card text-white bg-primary shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Products</h5>
                    <h2>{{ $totalProducts }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="col-md-3">
            <div class="card text-white bg-success shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Orders</h5>
                    <h2>{{ $totalOrders }}</h2>
                </div>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="col-md-3">
            <div class="card text-white bg-warning shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Total Revenue</h5>
                    <h2>{{ number_format($totalRevenue) }} VND</h2>
                </div>
            </div>
        </div>

        <!-- Approved Revenue -->
        <div class="col-md-3">
            <div class="card text-white bg-danger shadow rounded-3">
                <div class="card-body text-center">
                    <h5 class="card-title">Approved Revenue</h5>
                    <h2>{{ number_format($approvedRevenue) }} VND</h2>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Orders Table -->
    <table class="table table-hover mt-4">
        <thead>
            <tr>
                <th>Order Code</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentOrders as $order)
            <tr>
                <td>{{ $order->code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ number_format($order->total) }} VND</td>
                <td>
                    @if($order->status == 1)
                        <span class="badge bg-success">Approved</span>
                    @else
                        <span class="badge bg-warning text-dark">Pending</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Revenue Chart -->
    <div class="row g-12">
        <h4 class="mb-3">Monthly Revenue Chart</h4>
        <div class="card shadow rounded-3 p-4">
            <canvas id="revenueChart" height="120"></canvas>
        </div>  
    </div>
</div>
@endsection
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const ctx = document.getElementById('revenueChart')?.getContext('2d');

        if (ctx) {
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: {!! json_encode($months) !!},
                    datasets: [{
                        label: 'Revenue (VND)',
                        data: {!! json_encode($revenues) !!},
                        backgroundColor: 'rgba(75, 192, 192, 0.7)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        borderRadius: 6
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return value.toLocaleString('en-US') + ' VND';
                                }
                            }
                        }
                    }
                }
            });
        }
    });
</script>

