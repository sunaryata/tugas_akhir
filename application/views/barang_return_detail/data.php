<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-dark">
	<div class="card-header bg-white py-3">
		<div class="row">
			<div class="col">
				<h4 class="h5 align-middle m-0 font-weight-bold text-dark">
					Riwayat Data Barang Return
				</h4>
			</div>
			<div class="col-auto">
				<a href="<?= base_url('barangreturn/add_detail/' . $id_barang_return) ?>" class="btn btn-sm btn-primary btn-icon-split">
					<span class="icon">
						<i class="fa fa-plus"></i>
					</span>
					<span class="text">
						Input Item
					</span>
				</a>
			</div>
		</div>
	</div>
	<?php
	$dataSession = $this->session->userdata('login_session');
	?>

	<div class="table-responsive">
		<table class="table table-striped w-100 dt-responsive nowrap" id="dataTable">
			<thead>
				<tr>
					<th>No. </th>
					<th>Barang</th>
					<th>Jumlah Barang</th>
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$no = 1;
				if ($barangmasuk) :
					foreach ($barangmasuk as $bm) :
				?>
						<tr>
							<td><?= $no++; ?></td>
							<td><?= $bm['nama_barang']; ?></td>
							<td><?= $bm['jumlah_masuk']; ?></td>

							<td>
								<?php
								if ($dataSession['role'] == "pimpinan" or $dataSession['role'] == "admin") {
								?>
									<button type="button" class="btn btn-primary btn-circle btn-sm" title="Update" data-toggle="modal" data-target="#exampleModal" onclick="update('<?= $bm['id_detail_barang_return'] ?>')"><i class="fa fa-edit"></i></button>
									<a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangreturn/deleteitem/') . $bm['id_detail_barang_return'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
								<?php
								} elseif ($dataSession['role'] == "admin" or $dataSession['role'] == "kasir") {
								?>
									<a href="<?= base_url('barangreturn/edit/') . $bm['id_barang_return'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
								<?php
								} else {
								}
								?>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php else : ?>
					<tr>
						<td colspan="8" class="text-center">
							Data Kosong
						</td>
					</tr>
				<?php endif; ?>
			</tbody>
		</table>
	</div>
</div>

<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="" id="form-edit" method="post">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Update</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="id_barang">Barang</label>
						<select class="form-control" name="id_barang" id="id_barang" disabled>
							<option value="">Pilih Barang</option>
							<?php foreach ($barang as $key => $value) { ?>
								<option value="<?= $value['id_barang'] ?>"><?= $value['nama_barang'] ?></option>
							<?php } ?>
						</select>
					</div>
					<div class="form-group">
						<label for="stok">Stok</label>
						<input type="number" class="form-control" name="stok" id="stok" readonly>
					</div>
					<div class="form-group">
						<label for="jumlah_barang">Jumlah Barang</label>
						<input type="number" class="form-control" name="jumlah_barang" id="jumlah_barang" min="1" onkeyup="change_jumlah_barang()">
					</div>
					<div class="form-group">
						<label for="total_stok">Total Stok</label>
						<input type="number" class="form-control" name="total_stok" id="total_stok" readonly>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
	let jumlah_barang = 0;

	function update(id_barang_return_detail) {
		$('#form-edit').attr('action', `<?= base_url('barangreturn/edit_detail') ?>/${id_barang_return_detail}`);
		$.ajax({
			type: "get",
			url: `<?= base_url('barangreturn/api_detail_barang_masuk') ?>/${id_barang_return_detail}`,
			dataType: "json",
			success: function(response) {
				console.log(response);
				jumlah_barang = response.jumlah_masuk;
				$('#stok').val(response.stok);
				$('#id_barang').val(response.id_barang);
				$('#jumlah_barang').val(response.jumlah_masuk);
			},
			error(data) {
				console.log(data.responseJSON);
			}
		});
	}

	function change_jumlah_barang() {
		const stok = $('#stok').val();
		const data_jumlah_barang = $('#jumlah_barang').val();
		console.log('ini stok',Number(stok) + Number(jumlah_barang)-Number(data_jumlah_barang));

		console.log(data_jumlah_barang - jumlah_barang);
		console.log(data_jumlah_barang, jumlah_barang);
		$('#total_stok').val(Number(stok) + Number(jumlah_barang)-Number(data_jumlah_barang));
	}
</script>
