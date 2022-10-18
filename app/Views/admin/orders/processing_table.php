<table id="processing_table" class="table table-hoverable mt-5">
    <thead>
        <th>No</th>
        <th>Order No.</th>
        <th>Customer Name</th>
        <th>Customer Phone</th>
        <th>Update Status</th>
        <th>Delete</th>
        <th>Edit</th>
        <th>Details</th>
    </thead>
    <tbody>
        <?php
        foreach ($orders_processing as $key => $order) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"><?= $order['order_no'] ?></td>
                <td class="align-middle"><?= $order['cust_name'] ?></td>
                <td class="align-middle"><a target="_blank" href="https://wa.me/<?= $order['cust_phone'] ?>"><?= $order['cust_phone'] ?></a></td>

                <td class="align-middle"><button class="btn btn-sm btn-primary rounded-0" onclick="updateStatusModal(<?= $order['id'] ?>,'<?= $order['order_no'] ?>','<?= $order['status'] ?>')"><i class="fa-solid fa-flag-checkered"></i>&nbsp; Update Status</button></td>

                <td class="align-middle"><button class="btn btn-sm btn-danger rounded-0" onclick="deleteOrder(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-trash-can"></i>&nbsp; Delete</button></td>

                <td class="align-middle"><button class="btn btn-sm btn-success rounded-0" onclick="updateOrderModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-regular fa-pen-to-square"></i>&nbsp; Edit</button></td>

                <td class="align-middle"><button class="btn btn-sm btn-primary rounded-0" onclick="detailModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-solid fa-circle-info"></i>&nbsp; Detail</button></td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
    var t = $('#processing_table').DataTable({
        columnDefs: [{
            orderable: false,
            targets: 0
        }]
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