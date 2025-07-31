<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <form id="form" method="POST">
        @csrf

        <!-- HEADER -->
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Order</h5>
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
              <select class="form-select" id="status" name="status" required>
                <option value="0">Pending</option>
                <option value="1">Approved</option>
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
                <!-- JavaScript sẽ render dòng sản phẩm ở đây -->
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
  const modal = document.getElementById('modal');
  modal.addEventListener('show.bs.modal', function (event) {
    const button = event.relatedTarget;
    const mode = button.getAttribute('data-mode');
    const form = document.getElementById('form');
    const tbody = document.getElementById('productBody');
    const methodInput = form.querySelector('input[name="_method"]');

    // Reset form
    form.reset();
    tbody.innerHTML = '';
    document.getElementById('total').value = 0;

    if (mode === 'edit') {
      const order = JSON.parse(button.getAttribute('data-order'));
      const details = JSON.parse(button.getAttribute('data-details'));

      // Set action và thêm method PUT
      form.action = `/orders/${order.id}`;
      if (!methodInput) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = '_method';
        input.value = 'PUT';
        form.appendChild(input);
      }

      // Gán các giá trị order
      document.getElementById('code').value = order.code;
      document.getElementById('name').value = order.name;
      document.getElementById('address').value = order.address;
      document.getElementById('orderDate').value = order.order_date;
      document.getElementById('status').value = order.status;

      // Render product details
      details.forEach(detail => {
        const row = createProductRow(detail.product_detail_id, detail.quantity, detail.price);
        tbody.appendChild(row);
      });
    } else {
      // Mode add
      form.action = '/orders';
      if (methodInput) methodInput.remove();
    }

    updateGrandTotal();
  });

  // Tạo dòng sản phẩm
  function createProductRow(productDetailId = '', quantity = 1, price = 0) {
    const row = document.createElement('tr');

    let options = `
      @foreach ($product_details as $item)
        <option value="{{ $item->id }}" data-price="{{ $item->price }}">
          {{ $item->product->code }} - {{ $item->product->name }} - {{ $item->color->name ?? $item->power->name }}
        </option>
      @endforeach
    `.trim();

    row.innerHTML = `
      <td>
        <select name="product_details[]" class="form-select">
          ${options}
        </select>
      </td>
      <td><input type="number" name="quantities[]" class="form-control quantity" min="1" value="${quantity}" /></td>
      <td><input type="number" name="prices[]" class="form-control price" min="0" step="0.01" value="${price}" readonly /></td>
      <td><input type="text" class="form-control total-field" readonly /></td>
      <td><button type="button" class="btn btn-danger btn-sm remove-row">X</button></td>
    `;

    // Chọn đúng option
    const select = row.querySelector('select[name="product_details[]"]');
    const matchedOption = Array.from(select.options).find(opt => opt.value == productDetailId);
    if (matchedOption) {
      matchedOption.selected = true;
      row.querySelector('.price').value = matchedOption.getAttribute('data-price');
    }

    updateRowTotal(row);
    return row;
  }

  // Add product row (Add mode)
  document.getElementById('addRowBtn').addEventListener('click', function () {
    const row = createProductRow();
    document.getElementById('productBody').appendChild(row);
    updateGrandTotal();
  });

  // Change & remove event handlers
  document.getElementById('productTable').addEventListener('change', function (e) {
    const row = e.target.closest('tr');

    if (e.target.name === 'product_details[]') {
      const selectedOption = e.target.options[e.target.selectedIndex];
      const price = selectedOption.getAttribute('data-price');
      row.querySelector('input.price').value = price;
      updateRowTotal(row);
      updateGrandTotal();
    }

    if (e.target.classList.contains('quantity')) {
      updateRowTotal(row);
      updateGrandTotal();
    }
  });

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


