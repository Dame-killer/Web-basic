<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form" method="POST">
        @csrf

        <!-- HEADER -->
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Add Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <!-- BODY -->
        <div class="modal-body">
          <!-- PHẦN 1: Thông tin đơn hàng -->
          <h6 class="mb-3 border-bottom pb-2">Order Information</h6>
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="code" class="form-label">Code</label>
              <input type="text" class="form-control" id="code" name="code" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="name" class="form-label">Name</label>
              <input type="text" class="form-control" id="name" name="name" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="address" class="form-label">Address</label>
              <input type="text" class="form-control" id="address" name="address" required>
            </div>

            <div class="col-md-6 mb-3">
              <label for="total" class="form-label">Total</label>
              <input type="text" class="form-control" id="total" name="total" readonly>
            </div>

            <div class="col-md-6 mb-3">
              <label for="orderDate" class="form-label">Order Date</label>
              <input type="date" class="form-control" id="orderDate" name="order_date" value="{{ now()->toDateString() }}">
            </div>

            <div class="col-md-6 mb-3">
              <label for="status" class="form-label">Status</label>
              <select class="form-select" id="status" name="status">
                <option value="0">Waiting</option>
                <option value="1">Processed</option>
              </select>
            </div>
          </div>

          <!-- PHẦN 2: Sản phẩm -->
          <h6 class="mt-4 mb-3 border-bottom pb-2">Select Products</h6>
          <div class="table-responsive">
            <table class="table table-bordered" id="productTable">
              <thead>
                <tr>
                  <th>Product</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                  <th></th>
                </tr>
              </thead>
              <tbody id="productBody">
                <!-- JS sẽ thêm dòng tại đây -->
              </tbody>
            </table>
            <button type="button" class="btn btn-outline-primary" id="addRowBtn">+ Add Product</button>
          </div>
        </div>

        <!-- FOOTER -->
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- SCRIPT -->
<script>
  // Thêm dòng sản phẩm
  document.getElementById('addRowBtn').addEventListener('click', function () {
    const tbody = document.getElementById('productBody');
    const row = document.createElement('tr');

    row.innerHTML = `
      <td>
        <select name="product_details[]" class="form-select">
          @foreach ($product_details as $detail)
            <option value="{{ $detail->id }}" data-price="{{ $detail->price }}">
              {{ $detail->product->code }} - {{ $detail->product->name }} - {{ $detail->color->name ?? $detail->power->name }}
            </option>
          @endforeach
        </select>
      </td>
      <td><input type="number" name="quantities[]" class="form-control quantity" min="1" value="1" /></td>
      <td><input type="number" name="prices[]" class="form-control price" min="0" step="0.01" readonly /></td>
      <td><input type="text" class="form-control total-field" readonly /></td>
      <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
    `;

    tbody.appendChild(row);

    // Gán giá tự động khi vừa thêm row mới
    const select = row.querySelector('select[name="product_details[]"]');
    const priceInput = row.querySelector('input.price');
    const selectedOption = select.options[select.selectedIndex];
    priceInput.value = selectedOption.getAttribute('data-price');
    updateRowTotal(row);
    updateGrandTotal();
  });

  // Khi thay đổi sản phẩm hoặc nhập số lượng
  document.getElementById('productTable').addEventListener('change', function (e) {
    const row = e.target.closest('tr');

    // Thay đổi sản phẩm -> cập nhật giá
    if (e.target.name === 'product_details[]') {
      const selectedOption = e.target.options[e.target.selectedIndex];
      const price = selectedOption.getAttribute('data-price');
      const priceInput = row.querySelector('input.price');
      priceInput.value = price;
      updateRowTotal(row);
      updateGrandTotal();
    }

    // Thay đổi số lượng -> tính lại tổng
    if (e.target.classList.contains('quantity')) {
      updateRowTotal(row);
      updateGrandTotal();
    }
  });

  // Xóa dòng
  document.getElementById('productTable').addEventListener('click', function (e) {
    if (e.target.classList.contains('remove-row')) {
      e.target.closest('tr').remove();
      updateGrandTotal();
    }
  });

  function updateRowTotal(row) {
    const qty = parseFloat(row.querySelector('.quantity')?.value || 0);
    const price = parseFloat(row.querySelector('.price')?.value || 0);
    const total = qty * price;
    row.querySelector('.total-field').value = total.toFixed(0);
  }

  function updateGrandTotal() {
    let grandTotal = 0;
    document.querySelectorAll('.total-field').forEach(input => {
      grandTotal += parseFloat(input.value) || 0;
    });
    document.getElementById('total').value = grandTotal.toFixed(0);
  }
</script>

