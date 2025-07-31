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
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $order->code }}</td>
                <td>{{ $order->name }}</td>
                <td>{{ $order->order_date }}</td>
                <td>{{ $order->address }}</td>
                <td>{{ $order->total }}</td>
                <td>
                  @if($order->status == 0)
                    <span class="badge bg-warning text-dark">Waiting</span>
                  @elseif($order->status == 1)
                    <span class="badge bg-success">Processed</span>
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
                    data-bs-toggle="modal" data-bs-target="#modal">
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

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const action = button.getAttribute('data-action');
    const code = button.getAttribute('data-code') || '';
    const name = button.getAttribute('data-name') || '';
    const status = button.getAttribute('data-status') || '';
    const order_date = button.getAttribute('data-order_date') || '';
    const address = button.getAttribute('data-address') || '';
    const total = button.getAttribute('data-total') || '';

    form.action = action;
    codeInput.value = code;
    nameInput.value = name;
    statusInput.value = status;
    addressInput.value = address;
    totalInput.value = total;
    order_dateInput.value = order_date;

    // Xoá input _method cũ nếu có
    const oldMethod = document.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    if (mode === 'edit') {
      modalTitle.textContent = 'Edit Order';
      submitBtn.textContent = 'Update';

      const methodInput = document.createElement('input');
      methodInput.setAttribute('type', 'hidden');
      methodInput.setAttribute('name', '_method');
      methodInput.setAttribute('value', 'PUT');
      form.appendChild(methodInput);
    } else {
      modalTitle.textContent = 'Add Order';
      submitBtn.textContent = 'Save';
    }
  });
});
</script>