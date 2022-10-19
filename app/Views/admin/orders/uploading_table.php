<table id="uploading_table" class="table table-hoverable mt-5">
    <thead>
        <th style="white-space: nowrap">No</th>
        <th style="white-space: nowrap">Order No.</th>
        <th style="white-space: nowrap">Customer Name</th>
        <th style="white-space: nowrap">Customer Phone</th>
        <th style="white-space: nowrap">Uploaded</th>
        <th style="white-space: nowrap">Order Date</th>
        <th style="white-space: nowrap">Option</th>
    </thead>
    <tbody>
        <?php
        foreach ($orders_uploading as $key => $order) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"><?= $order['order_no'] ?></td>
                <td class="align-middle"><?= $order['cust_name'] ?></td>
                <td class="align-middle"><a target="_blank" href="https://wa.me/<?= $order['cust_phone'] ?>"><?= $order['cust_phone'] ?></a></td>
                <td class="align-middle"><?= $order['uploaded'] ?> / <?= $order['amount_photo'] ?></td>
                <td class="align-middle"><?= date("d M Y", $order['created_at']) ?></td>

                <td class="align-middle col-5">
                    <button class="btn btn-sm btn-danger rounded-0 me-2 my-1" onclick="deleteOrder(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button>

                    <button class="btn btn-sm btn-success rounded-0 me-2 my-1" onclick="updateOrderModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-regular fa-pen-to-square"></i>&nbsp; Edit</button>

                    <button class="btn btn-sm btn-primary rounded-0 me-2 my-1" onclick="detailModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-solid fa-circle-info"></i>&nbsp; Detail</button>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
    var t = $('#uploading_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }],
        ordering: false,
        sorting: false
    });

    t.on('order.dt search.dt', function() {
        let i = 1;
        t.cells(null, 0, {
            search: 'applied',
            order: 'applied'
        }).every(function(cell) {
            this.data(i++);
        });
    }).draw();
</script>