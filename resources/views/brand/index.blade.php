@extends('layouts.app')

@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card ">
      <div class="card-header d-flex justify-content-between align-items-center">
      <h4 class="card-title">Brand</h4>
      <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addBrandModal">
        + Add Brand
      </button>
    </div>

      <div class="card-body">
        <div class="table-responsive">
          <table class="table tablesorter " id="">
            <thead class="text-primary">
              <tr>
                <th>STT</th>
                <th>Name</th>
              </tr>
            </thead>
            <tbody>
              @foreach($brands as $brand)
              <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $brand->name }}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
@include('brand.modal')
@endsection
