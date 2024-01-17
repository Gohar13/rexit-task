<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

</head>
<body>
<div class="container">
    <hr>
    <table id="dtBasicExample" class="table table-striped table-bordered table-sm" cellspacing="0" width="100%">
        <thead>
        <tr>
            <th class="th-sm">category</th>
            <th class="th-sm">firstname</th>
            <th class="th-sm">lastname</th>
            <th class="th-sm">email</th>
            <th class="th-sm">gender</th>
            <th class="th-sm">birthDate</th>
        </tr>
        </thead>
        <tbody>
        <?php

        foreach ($result as $key => $value) {
            ?>
            <tr>
                <th scope="row"><?= $value['category'] ?></th>
                <td><?= $value['firstname'] ?></td>
                <td><?= $value['lastname'] ?></td>
                <td><?= $value['email'] ?></td>
                <td><?= $value['gender'] ?></td>
                <td><?= $value['birthdate'] ?></td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    </table>
</div>

<script src='https://code.jquery.com/jquery-3.7.0.js'></script>
<script src='https://cdn.datatables.net/1.13.5/js/jquery.dataTables.min.js'></script>
<script src='https://cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js'></script>
<script src='https://cdn.datatables.net/1.13.5/js/dataTables.bootstrap5.min.js'></script>

<script>
    $(document).ready(function () {
        $('#dtBasicExample').DataTable({
            paging: true,
            searching: false
        });
        $('.dataTables_length').addClass('bs-select');
    });
</script>

</body>
</html>
