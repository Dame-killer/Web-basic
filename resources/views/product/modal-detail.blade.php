<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Product Detail - {{ $product->code }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}">
          <div class="mb-3">
            <label for="size_id" class="form-label">Size</label>
            <select class="form-select" id="size_id" name="size_id">
              <option disabled selected value="">Select</option>
              @foreach($sizes as $size)
                <option value="{{ $size->id }}">{{ $size->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="color_id" class="form-label">Color</label>
            <select class="form-select" id="color_id" name="color_id">
              <option disabled selected value="">Select</option>
              @foreach($colors as $color)
                <option value="{{ $color->id }}">{{ $color->code }} - {{ $color->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="power_id" class="form-label">Power</label>
            <select class="form-select" id="power_id" name="power_id" required>
              <option disabled selected value="">Select</option>
              @foreach($powers as $power)
                <option value="{{ $power->id }}">{{ $power->name }}</option>
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label for="stock" class="form-label">Quantity</label>
            <input type="number" class="form-control" id="stock" name="stock" required>
          </div>

          <div class="mb-3">
            <label for="price" class="form-label">Price</label>
            <input type="number" class="form-control" id="price" name="price" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
