@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="card-title">Product</h4>
      <button type="button" class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modal"
        data-mode="add"
        data-action="{{ route('product.store') }}"
      >
        Add Product
      </button>

    </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class="text-primary">
              <tr>
                <th>STT</th>
                <th>Image</th>
                <th>Code</th>
                <th>Name</th>
                <th>Description</th>
                <th>Brand</th>           
                <th>Category</th>        
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($products as $product)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                @if($product->image)
                  <img src="{{ asset('uploads/products/' . $product->image) }}" alt="Image" width="80">
                @else
                  
                @endif
                </td>
                <td>{{ $product->code }}</td>
                <td>{{ $product->name }}</td>
                <td>{{ $product->description }}</td>
                <td>{{ $product->brand?->name ?? '-' }}</td>     
                <td>{{ $product->category?->name ?? '-' }}</td>  
                <td class="text-end"> 
                  {{-- Nút Xem thêm --}}
                  <a href="{{ route('product.show', $product->id) }}" class="btn btn-sm btn-info">
                    <i class="fa fa-eye"></i>
                  </a>

                  {{-- Nút Edit --}}
                  <button class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#modal"
                    data-mode="edit"
                    data-id="{{ $product->id }}"
                    data-image="{{ $product->image }}"
                    data-code="{{ $product->code }}"
                    data-name="{{ $product->name }}"
                    data-description="{{ $product->description }}"
                    data-brand_id="{{ $product->brand_id }}"
                    data-category_id="{{ $product->category_id }}"
                    data-action="{{ route('product.update', $product->id) }}"
                  >
                    <i class="fa fa-edit"></i>
                  </button>

                  {{-- Nút Delete --}}
                  <form action="{{ route('product.destroy', $product->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
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
@include('product.modal')
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal');
  const form = document.getElementById('form');
  const codeInput = document.getElementById('code');
  const nameInput = document.getElementById('name');
  const descriptionInput = document.getElementById('description');
  const brandSelect = document.getElementById('brand_id');
  const categorySelect = document.getElementById('category_id');
  const modalTitle = document.getElementById('modalLabel');
  const submitBtn = document.getElementById('submitBtn');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const action = button.getAttribute('data-action');
    const code = button.getAttribute('data-code') || '';
    const image = button.getAttribute('data-image') || '';
    const name = button.getAttribute('data-name') || '';
    const description = button.getAttribute('data-description') || '';
    const brand_id = button.getAttribute('data-brand_id') || '';
    const category_id = button.getAttribute('data-category_id') || '';

    form.action = action;
    codeInput.value = code;
    nameInput.value = name;
    descriptionInput.value = description;
    brandSelect.value = brand_id;
    categorySelect.value = category_id;

    // Xoá input _method cũ nếu có
    const oldMethod = document.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    const previewImage = document.getElementById('previewImage');

    if (mode === 'edit') {
      modalTitle.textContent = 'Edit Other';
      submitBtn.textContent = 'Update';

      const methodInput = document.createElement('input');
      methodInput.setAttribute('type', 'hidden');
      methodInput.setAttribute('name', '_method');
      methodInput.setAttribute('value', 'PUT');
      form.appendChild(methodInput);

      // ✅ Hiển thị ảnh cũ
      if (image) {
        previewImage.src = `/uploads/products/${image}`;
        previewImage.style.display = 'block';
      } else {
        previewImage.style.display = 'none';
      }
    } else {
      modalTitle.textContent = 'Add Other';
      submitBtn.textContent = 'Save';

      // ✅ Ẩn ảnh preview khi thêm mới
      previewImage.style.display = 'none';
      form.reset();
    }
  });
});
</script>
