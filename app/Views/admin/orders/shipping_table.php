<table id="shipping_table" class="table table-hoverable mt-5">
    <thead>
        <th>No</th>
        <th>Order No.</th>
        <th>Customer Name</th>
        <th>Customer Phone</th>
        <th>Order Date</th>
        <th>Option</th>
    </thead>
    <tbody>
        <?php
        foreach ($orders_shipping as $key => $order) {
        ?>
            <tr>
                <td class="align-middle"></td>
                <td class="align-middle"><?= $order['order_no'] ?></td>
                <td class="align-middle"><?= $order['cust_name'] ?></td>
                <td class="align-middle"><a target="_blank" href="https://wa.me/<?= $order['cust_phone'] ?>"><?= $order['cust_phone'] ?></a></td>
                <td class="align-middle"><?= date("d M Y", $order['created_at']) ?></td>
                <td class="align-middle">
                    <button class="btn btn-sm btn-primary rounded-0 me-2 my-1" onclick="markAsCompleted(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-flag-checkered"></i>&nbsp; Mark Order As Completed</button>

                    <button class="btn btn-sm btn-primary rounded-0 me-2 my-1" onclick="detailModal('<?= $order['id'] ?>','<?= $order['order_no'] ?>','<?= $order['cust_name'] ?>','<?= $order['cust_phone'] ?>','<?= $order['cust_address'] ?>','<?= $order['description'] ?>','<?= $order['amount_photo'] ?>','<?= $order['status'] ?>')"><i class="fa-solid fa-circle-info"></i>&nbsp; Detail</button>

                    <button class="btn btn-primary btn-sm rounded-0"><i class="fa-solid fa-truck-fast"></i>&nbsp; Print Delivery Notes</button>

                    <button class="btn btn-outline-primary btn-sm rounded-0" onclick="downloadFiles(<?= $order['id'] ?>,'<?= $order['order_no'] ?>')"><i class="fa-solid fa-download"></i>&nbsp; Download Photos</button>
                </td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>

<script>
    var t = $('#shipping_table').DataTable({
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