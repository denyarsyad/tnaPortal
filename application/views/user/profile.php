<div class="container-fluid">
	<h1 class="h3 mb-3 text-gray-800 font-weight-bold">Profil Saya</h1>

	<div class="row">
		<div class="col-xl-4 col-lg-7">
			<div class="card shadow mb-4">
				<div class="card-header py-3">
					<div class="card-body">
						<div style="text-align: center;">
							<div style="font-size: 25.5px; color: black">
								<i class="fas fa-user-circle fa-10x"></i>
							</div>
							<h3 class="font-weight-bold text-primary">
								<?= $profile['nama'] ?>
							</h3>
							<h6 class="m-0 font-weight text-primary">
								<?= $profile['level'] ?>
							</h6>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="col-xl-8 col-lg-7">
			<div class="card shadow mb-4">
				<div class="card-body">
					<h6 class="m-0 font-weight text-primary">
						<i class="fas fa-fw fa-id-card"></i>
						ID Number
					</h6>
					<div class="font-weight">
						<?= $profile['nik'] ?><br>
					</div><hr>

					<h6 class="m-0 font-weight text-primary">
						<i class="fas fa-fw fa-envelope"></i>
						Email
					</h6>
					<div class="font-weight">
						<?= $profile['email'] ?><br>
					</div><hr>

					<h6 class="m-0 font-weight text-primary">
						<i class="fas fa-fw fa-university"></i>
						Departemen
					</h6>
					<div class="font-weight">
						<?= $profile['nama_dept'] ?><br>
					</div><hr>

					<h6 class="m-0 font-weight text-primary">
						<i class="fas fa-fw fa-users"></i>
						Sub Departemen
					</h6>
					<div class="font-weight">
						<?= $profile['nama_bagian_dept'] ?><br>
					</div><hr>

					<h6 class="m-0 font-weight text-primary">
						<i class="fas fa-fw fa-suitcase"></i>
						Jabatan
					</h6>
					<div class="font-weight">
						<?= $profile['nama_jabatan'] ?><br>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>