@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="card-title">Order</h4>
      <button type="button" class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modal"
        data-mode="add"
        data-action="{{ route('order.store') }}"
      >
        Add Order
      </button>

    </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class="text-primary">
              <tr>
                <th>STT</th>
                <th>Code</th>
                <th>Name</th>
                <th>Order date</th>           
                <th>Address</th>
                <th>Total</th>
                <th>Status</th>        
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($orders as $order)
              @php
                  $details = $order_details->where('order_id', $order->id)->values(); // lọc theo order_id
              @endphp
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->total }} VND</td>
                <td>
                  @if($order->status == 0)
                    <span class="badge bg-warning text-dark">Pending</span>
                  @elseif($order->status == 1)
                    <span class="badge bg-success">Approved</span>
                  @else
                    <span class="badge bg-secondary">Unknown</span>
                  @endif
                </td>
                <td class="text-end"> 
                  <!-- Nút xem -->
                  <button type="button" class="btn btn-sm btn-info btn-show-details"
                          data-id="{{ $order->id }}">
                    <i class="fa fa-eye"></i>
                  </button>
                  {{-- Nút Edit --}}
                  <button type="button" class="btn btn-sm btn-warning"
                    data-id="{{ $order->id }}"
                    data-code="{{ $order->code }}"
                    data-name="{{ $order->name }}"
                    data-address="{{ $order->address }}"
                    data-status="{{ $order->status }}"
                    data-total="{{ $order->total }}"
                    data-order_date="{{ $order->order_date }}"
                    data-mode="edit"
                    data-action="{{ route('order.update', $order->id) }}"
                    data-order='@json($order)'
                    data-details='@json($details)'
                    data-bs-toggle="modal" 
                    data-bs-target="#modal"
                    >
                    <i class="fa fa-edit"></i>
                  </button>

                  {{-- Nút Delete --}}
                  <form action="{{ route('order.destroy', $order->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">
                      <i class="fa fa-trash"></i>
                    </button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>

          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('order.modal', ['product_details' => $product_details])
@include('order.modal-view')
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal');
  const form = document.getElementById('form');
  const codeInput = document.getElementById('code');
  const nameInput = document.getElementById('name');
  const statusInput = document.getElementById('status');
  const order_dateInput = document.getElementById('order_date');
  const addressInput = document.getElementById('address');
  const totalInput = document.getElementById('total');
  const modalTitle = document.getElementById('modalLabel');
  const submitBtn = document.getElementById('submitBtn');
  const modal = document.getElementById('modal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const form = document.getElementById('form');

    if (mode === 'edit') {
      const action = button.getAttribute('data-action');
      form.action = action;

      // Xóa input _method cũ nếu có
      const existingMethod = form.querySelector('input[name="_method"]');
      if (existingMethod) existingMethod.remove();

      // Tạo input _method mới
      const input = document.createElement('input');
      input.type = 'hidden';
      input.name = '_method';
      input.value = 'PUT';
      form.appendChild(input);
    } else {  
      // Nếu là thêm mới
      form.action = "{{ route('order.store') }}";

      // Xóa input _method nếu có (để dùng POST mặc định)
      const existingMethod = form.querySelector('input[name="_method"]');
      if (existingMethod) existingMethod.remove();
    }
  });


});
</script>