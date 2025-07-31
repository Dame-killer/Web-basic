@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h4 class="card-title">
                <a href="{{ route('product.show', $product->id) }}">Product - {{ $product->code }}</a>
            </h4>
            <button type="button" class="btn btn-primary"
                data-bs-toggle="modal"
                data-bs-target="#modal"
                data-mode="add"
                data-action="{{ route('product_detail.store') }}"
            >
                Add Product Detail
            </button>
        </div>

        <div class="card-body">
            <div class="table-responsive">
            <table class="table tablesorter " id="">
                <thead class="text-primary">
                <tr>
                    <th>STT</th>
                    <th>Code</th>
                    <th>Size</th>
                    <th>Color</th>           
                    <th>Power</th>        
                    <th class="text-end">Actions</th>
                </tr>
                </thead>
                <tbody>
                    @foreach($product_details as $detail)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $product->code }}</td>
                            <td>{{ $detail->size?->name ?? '-' }}</td>
                            <td>{{ $detail->color?->name ?? '-' }}</td>
                            <td>{{ $detail->power?->name ?? '-' }}</td>
                            <td class="text-end">
                                {{-- Nút Edit --}}
                                <button class="btn btn-sm btn-warning"
                                data-bs-toggle="modal"
                                data-bs-target="#modal"
                                data-mode="edit"
                                data-product_id="{{ $detail->product_id }}"
                                data-power_id="{{ $detail->power_id }}"
                                data-size_id="{{ $detail->size_id }}"
                                data-color_id="{{ $detail->color_id }}"
                                data-action="{{ route('product_detail.update', $detail->id) }}"
                                >
                                <i class="fa fa-edit"></i>
                                </button>

                                {{-- Nút Delete --}}
                                <form action="{{ route('product_detail.destroy', $detail->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
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
@include('product.modal-detail')
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal');
  const form = document.getElementById('form');
  const sizeSelect = document.getElementById('size_id');
  const colorSelect = document.getElementById('color_id');
  const powerSelect = document.getElementById('power_id');
  const productIdInput = document.getElementById('product_id');
  const modalTitle = document.getElementById('modalLabel');
  const submitBtn = document.getElementById('submitBtn');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const action = button.getAttribute('data-action');

    const size_id = button.getAttribute('data-size_id') || '';
    const color_id = button.getAttribute('data-color_id') || '';
    const power_id = button.getAttribute('data-power_id') || '';
    const product_id = button.getAttribute('data-product_id') || '';

    form.action = action;
    sizeSelect.value = size_id;
    colorSelect.value = color_id;
    powerSelect.value = power_id;
    productIdInput.value = product_id;

    // Xoá _method cũ nếu có
    const oldMethod = document.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    if (mode === 'edit') {
      modalTitle.textContent = 'Edit Product Detail';
      submitBtn.textContent = 'Update';

      const methodInput = document.createElement('input');
      methodInput.setAttribute('type', 'hidden');
      methodInput.setAttribute('name', '_method');
      methodInput.setAttribute('value', 'PUT');
      form.appendChild(methodInput);
    } else {
      modalTitle.textContent = 'Add Product Detail';
      submitBtn.textContent = 'Save';
    }
  });
});
</script>

