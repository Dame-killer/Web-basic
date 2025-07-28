@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="card-title">Size</h4>
      <button type="button" class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#modal"
        data-mode="add"
        data-action="{{ route('size.store') }}"
      >
        Add Size
      </button>

    </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class="text-primary">
              <tr>
                <th>STT</th>
                <th>Name</th>
                <th class="text-end">Actions</th>
              </tr>
            </thead>
            <tbody>
              @foreach($sizes as $size)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $size->name }}</td>
                <td class="text-end">
                  {{-- Nút Edit --}}
                  <button class="btn btn-sm btn-warning"
                    data-bs-toggle="modal"
                    data-bs-target="#modal"
                    data-mode="edit"
                    data-id="{{ $size->id }}"
                    data-name="{{ $size->name }}"
                    data-action="{{ route('size.update', $size->id) }}"
                  >
                    <i class="fa fa-edit"></i>
                  </button>

                  {{-- Nút Delete --}}
                  <form action="{{ route('size.destroy', $size->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure?');">
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
@include('size.modal')
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
  const modal = document.getElementById('modal');
  const form = document.getElementById('form');
  const nameInput = document.getElementById('name');
  const modalTitle = document.getElementById('modalLabel');
  const submitBtn = document.getElementById('submitBtn');

  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const action = button.getAttribute('data-action');
    const name = button.getAttribute('data-name') || '';

    form.action = action;
    nameInput.value = name;

    // Xoá input _method cũ nếu có
    const oldMethod = document.querySelector('input[name="_method"]');
    if (oldMethod) oldMethod.remove();

    if (mode === 'edit') {
      modalTitle.textContent = 'Edit Size';
      submitBtn.textContent = 'Update';

      const methodInput = document.createElement('input');
      methodInput.setAttribute('type', 'hidden');
      methodInput.setAttribute('name', '_method');
      methodInput.setAttribute('value', 'PUT');
      form.appendChild(methodInput);
    } else {
      modalTitle.textContent = 'Add Size';
      submitBtn.textContent = 'Save';
    }
  });
});
</script>
