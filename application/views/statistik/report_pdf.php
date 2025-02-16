<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <title>Report PDF</title>
    <style>
        table {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 11px !important;
            border-collapse: collapse;
            width: 100%;
        }

        table td,
        table th {
            border: 1px solid #ddd;
            padding: 10px;
        }

        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        table tr:hover {
            background-color: #ddd;
        }

        table th {
            padding-top: 12px;
            padding-bottom: 12px;
            text-align: left;
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
    <div>
        <h2 style="text-align: center;"><strong>Laporan PDF</strong></h2>
        <h3>Tanggal: <?= $tgl1; ?> - <?= $tgl2; ?></h3>
        <table>
            <thead>
                <tr>
                    <th scope="col">No</th>
                    <th scope="col">No. Ticket</th>
                    <th scope="col">Nama</th>
                    <th scope="col">Tanggal Submit</th>
                    <th scope="col">Tanggal Deadline</th>
                    <th scope="col">Last Update</th>
                    <th scope="col">Prioritas</th>
                    <th scope="col">Status</th>
                    <th scope="col">Lokasi</th>
                    <th scope="col">Kategori</th>
                    <th scope="col">Sub Kategori</th>
                    <th scope="col">Teknisi</th>
                    <th scope="col">Work Detail</th>
                    <th scope="col">Progress</th>
                    <th scope="col">Tanggal Proses</th>
                    <th scope="col">Solved</th>
                </tr>
            </thead>
            <tbody>
                <?php $no = 1; ?>
                <?php if (!empty($report)) { ?>
                    <?php foreach ($report as $row) : ?>
                        <?php if ($row->status == 0) {
                            $status = "Ticket Rejected";
                        } else if ($row->status == 1) {
                            $status = "Ticket Submited";
                        } else if ($row->status == 2) {
                            $status = "Category Changed";
                        } else if ($row->status == 3) {
                            $status = "Technician selected";
                        } else if ($row->status == 4) {
                            $status = "On Process";
                        } else if ($row->status == 5) {
                            $status = "Pending";
                        } else if ($row->status == 6) {
                            $status = "Solve";
                        } else if ($row->status == 7) {
                            $status = "Late Finished";
                        }
                        ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $row->id_ticket; ?></td>
                            <td><?= $row->nama; ?></td>
                            <td><?= $row->tanggal; ?></td>
                            <td><?= $row->deadline; ?></td>
                            <td><?= $row->last_update; ?></td>
                            <td><?= $row->nama_prioritas; ?></td>
                            <td><?= $status; ?></td>
                            <td><?= $row->lokasi; ?></td>
                            <td><?= $row->nama_kategori; ?></td>
                            <td><?= $row->nama_sub_kategori; ?></td>
                            <td><?= $row->nama_teknisi; ?></td>
                            <td><?= $row->problem_detail; ?></td>
                            <td><?= $row->progress; ?>%</td>
                            <td>
                                <?php if($row->tanggal_proses == null || $row->tanggal_proses == '') { ?> 
                                -
                                <?php } else { ?> 
                                    <?= $row->tanggal_proses; ?>
                                <?php } ?>
                            </td>
                            <td>
                                <?php if($row->tanggal_solved == null || $row->tanggal_solved == '') { ?> 
                                -
                                <?php } else { ?> 
                                    <?= $row->tanggal_solved; ?>
                                <?php } ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php } else { ?>
                    <tr>
                        <td colspan="13" align="center">-- No Data Found -- </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>

</html>