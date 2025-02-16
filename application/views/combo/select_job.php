<table class="table" width="100%">
	<tr>
		<th>#</th>
		<th>Kategori</th>
		<th>Sub Kategori</th>
		<th>User</th>
		<th>Progress</th>
	</tr>
	<?php $no = 0; foreach($dataassigment as $row) { $no++;?>
		<tr>
			<td><?= $no;?></td>
			<td><?= $row->nama_kategori;?></td>
			<td><?= $row->nama_sub_kategori;?></td>
			<td><?= $row->nama;?></td>
			<td><?= $row->progress;?></td>
		</tr>
	<?php }?>

</table>

<div class="form-group">
	<input class="form-control" name="nama" rows="3" value="<?= $nama?>" hidden></input>
	<input class="form-control" name="email" rows="3" value="<?= $email?>" hidden></input>
</div>