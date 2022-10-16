<table id="processing_table" class="table table-hoverable mt-5">
    <thead>
        <th>No</th>
        <th>Order No.</th>
        <th>Customer Name</th>
        <th>Status</th>
        <th>Delete</th>
        <th>Details</th>
    </thead>
    <tbody>
        <?php
        foreach ($orders_processing as $key => $order) {
        ?>
            <tr>
                <td></td>
                <td><?= $order['order_no'] ?></td>
                <td><?= $order['cust_name'] ?></td>
                <td><?= $order['status'] ?></td>
                <td></td>
                <td></td>
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
        }],
        order: [
            [2, 'asc']
        ]
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