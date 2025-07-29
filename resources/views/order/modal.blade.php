<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <form id="form" method="POST">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalLabel">Add Order</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <div class="mb-3">
            <label for="code" class="form-label">Code</label>
            <input type="text" class="form-control" id="code" name="code" required>
          </div>

          <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>

          <div class="mb-3">
            <label for="address" class="form-label">Address</label>
            <input type="text" class="form-control" id="address" name="address" required>
          </div>

          <div class="mb-3">
            <label for="orderDate" class="form-label">Order date</label>
            <input type="date" class="form-control" id="orderDate" name="orderDate" />
          </div>


          <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select class="form-control" id="status" name="status">
              <option value="0">Waiting for processing</option>
              <option value="1">Processed</option>
            </select>
          </div>


        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary" id="submitBtn">Save</button>
        </div>
      </form>
    </div>
  </div>
</div>
