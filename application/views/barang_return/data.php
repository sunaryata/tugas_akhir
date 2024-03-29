<?= $this->session->flashdata('pesan'); ?>
<div class="card shadow-sm border-bottom-dark">
    <div class="card-header bg-white py-3">
        <div class="row">
            <div class="col">
                <h4 class="h5 align-middle m-0 font-weight-bold text-dark">
                    Riwayat Data Barang return
                </h4>
            </div>
            <div class="col-auto">
                <a href="<?= base_url('barangreturn/add') ?>" class="btn btn-sm btn-primary btn-icon-split">
                    <span class="icon">
                        <i class="fa fa-plus"></i>
                    </span>
                    <span class="text">
                        Input Barang return
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
                    <th>No Transaksi</th>
                    <th>Tanggal return</th>
                    <th>User</th>
                    <th>Nama Supplier</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $no = 1;
                if ($barangreturn) :
                    foreach ($barangreturn as $bk) :
                ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= $bk['id_barang_return']; ?></td>
                            <td><?= $bk['tanggal_return']; ?></td>
                            <td><?= $bk['nama']; ?></td>
                            <td><?= $bk['nama_supplier']; ?></td>

                            <td>
                                <?php
                                if ($dataSession['role'] == "pimpinan" or $dataSession['role'] == "admin") {
                                ?>
									<a href="<?= base_url('barangreturn/detail/') . $bk['id_barang_return'] ?>" class="btn btn-primary btn-circle btn-sm" title="detail"><i class="fa fa-eye"></i></a>
                                    <a onclick="return confirm('Yakin ingin hapus?')" href="<?= base_url('barangreturn/delete/') . $bk['id_barang_return'] ?>" class="btn btn-danger btn-circle btn-sm"><i class="fa fa-trash"></i></a>
                                <?php
                                } elseif ($dataSession['role'] == "admin" or $dataSession['role'] == "kasir") {
                                ?>
                                    <a href="<?= base_url('barangreturn/edit/') . $bk['id_barang_return'] ?>" class="btn btn-warning btn-circle btn-sm"><i class="fa fa-edit"></i></a>
                                <?php
                                } else {
                                }
                                ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="7" class="text-center">
                            Data Kosong
                        </td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>