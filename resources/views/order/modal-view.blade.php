<div class="modal fade" id="showOrderModal" tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Order Details</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p><strong>Code:</strong> <span id="modalCode"></span></p>
        <p><strong>Name:</strong> <span id="modalName"></span></p>
        <p><strong>Date:</strong> <span id="modalDate"></span></p>
        <p><strong>Address:</strong> <span id="modalAddress"></span></p>
        <p><strong>Status:</strong> <span id="modalStatus"></span></p>
        <p><strong>Total:</strong> <span id="modalTotal"></span></p>

        <hr>
        <h6>Products</h6>
        <table class="table table-bordered">
          <thead>
            <tr>
              <th>STT</th>
              <th>Product</th>
              <th>Quantity</th>
              <th>Price</th>
            </tr>
          </thead>
          <tbody id="modalProductsBody">
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const modal = new bootstrap.Modal(document.getElementById('showOrderModal'));

    document.querySelectorAll('.btn-show-details').forEach(button => {
      button.addEventListener('click', () => {
        const orderId = button.getAttribute('data-id');

        fetch(`/orders/${orderId}`)
          .then(res => res.json())
          .then(data => {
            document.getElementById('modalCode').textContent = data.order.code;
            document.getElementById('modalName').textContent = data.order.name;
            document.getElementById('modalDate').textContent = data.order.order_date;
            document.getElementById('modalAddress').textContent = data.order.address;
            document.getElementById('modalStatus').textContent = (data.order.status == 0) ? 'Waiting' : 'Processed';
            document.getElementById('modalTotal').textContent = data.order.total;
            const tbody = document.getElementById('modalProductsBody');
            tbody.innerHTML = '';

            data.orderDetails.forEach((d, i) => {
              const tr = document.createElement('tr');
              tr.innerHTML = `
                <td>${i + 1}</td>
                <td>${d.product_detail.product?.code} - ${d.product_detail.product?.name} - ${d.product_detail.color?.name || d.product_detail.power?.name || ''}</td>
                <td>${d.quantity}</td>
                <td>${d.price}</td>
              `;
              tbody.appendChild(tr);
            });

            modal.show();
          });
      });
    });
  });
</script>
