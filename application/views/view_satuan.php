<div class="row">
    <div class="col-md-12">
        <div class="box box-danger">
            <div class="box-header with-border color-header">
                <h3 class="box-title"><i class="fa fa-th"></i> Data Kategori Satuan</h3>
                <div class="box-tools pull-right">
                    <a class="btn btn-default btn-sm" href="<?php echo base_url('Satuan'); ?>">
                        <span class="fa fa-refresh"></span> Refresh</a>
                    <button type="button" class="btn btn-sm btn-success btnTambah" id="btnTambah">
                        <span class="fa fa-plus"></span> Tambah</button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <table class="table table-striped table-bordered table-condensed" id="mydata">
                            <thead>
                                <tr>
                                    <th style="width:30px;text-align: center;">#No</th>
                                    <th>Kategori Satuan</th>
                                    <th style="width:120px;text-align: center;">Action</th>
                                </tr>
                            </thead>
                            <tbody id="tbl_data">
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Kategori -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" 
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="formModalLabel">Tambah Kategori Satuan</h4>
            </div>
            <div class="modal-body">
                <form action="" method="post" id="form_add">
                    <input type="hidden" id="id_satuan" name="id_satuan">
                    <div class="form-group">
                        <label>Nama Satuan</label>
                        <input type="text" class="form-control" name="nama_satuan" id="nama_satuan" placeholder="Nama Satuan">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" id="btnSimpan" 
                            data-loading-text="<i class='fa fa-circle-o-notch fa-spin'></i> Processing">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- End Modal Add Kategori -->

<script type="text/javascript">
    $(document).ready(function() {
        var bEdit = false;
        tampil_data();
    });

        // menampilkan data di tabel
        function tampil_data() {
            $.ajax({
                type: 'POST',
                url: '<?php echo base_url("satuan/tampilkanData"); ?>',
                dataType: 'json',
                success: function(response) {
                    var html = "";
                    var i;
                    var no = 0;
                    for (i = 0; i < response.length; i++) {
                        no++;
                        html += '<tr>' +
                            '<td>' + no + '</td>' +
                            '<td>' + response[i].nama_satuan + '</td>' +
                            '<td><center>' +
                            '<span><button edit-id="' + response[i].id_satuan + '" class="btn btn-success btn-xs btn_edit"><i class="fa fa-edit"></i> Edit</button><button style="margin-left: 5px;" data-id="' + response[i].id_kategori + '" class="btn btn-danger btn-xs btn_hapus"><i class="fa-trash"></i> Hapus</button></span>' +
                            '</center></td>' +
                            '</tr>';
                    }
                    $('#tbl_data').html(html);
                    $('#mydata').DataTable();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    alert(xhr.status);
                    alert(thrownError);
                }
            });
        }

        // Memanggil Modal Kategori
        $(document).on("click", "#btnTambah", function(e) {
            e.preventDefault();
            bEdit = false;
            $('#form_add')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $("#formModal").modal('show');
            $('.modal-title').text('Tambah Satuan Barang');
        });

        $("#tbl_data").on('click', '.btn_edit', function() {
    var id_satuan = $(this).attr('edit-id');
    bEdit = true;
    $.ajax({
        url: '<?php echo base_url('satuan/tampilkanDataByID'); ?>',
        type: 'POST',
        data: {
            id_satuan: id_satuan
        },
        dataType: 'json',
        success: function(response) {
            $('#form_add')[0].reset();
            $('.form-group').removeClass('has-error');
            $('.help-block').empty();
            $('.modal-title').text('Edit Satuan Barang');
            $('input[name="nama_satuan"]').val(response.nama_satuan);
            $('input[name="id_satuan"]').val(response.id_satuan);
            $("#formModal").modal('show');
        },
        error: function(xhr, status, error) {
            console.log(xhr.responseText);
        }
    });
});

        // Kirim Data Proses Save/Update ke Controller
        $(document).on("click", "#btnSimpan", function(e) {
            e.preventDefault();
            var $this = $(this);
            var id_satuan = $("#id_satuan").val();
            var nama_satuan = $("#nama_satuan").val();
            var sURL = '';

            if (bEdit) {
                sURL = '<?php echo base_url('satuan/perbaruiData'); ?>';
            } else {
                sURL = '<?php echo base_url('satuan/tambahData'); ?>';
            }

            $.ajax({
                url: sURL,
                type: "post",
                dataType: "json",
                data: {
                    id_satuan: id_satuan,
                    nama_satuan: nama_satuan
                },
                beforeSend: function() {
                    $this.button('loading');
                },
                complete: function() {
                    $this.button('reset');
                },
                success: function(data) {
                    if (data.response == "success") {
                        $('#form_add')[0].reset();
                        $('.form-group').removeClass('has-error');
                        $('.help-block').empty();
                        $("#formModal").modal('hide');
                        Swal.fire({
                            text: 'Data berhasil di Simpan',
                            icon: 'success',
                            title: 'Saving Success',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#mydata').DataTable().destroy();
                        tampil_data();
                    } else {
                        Swal.fire('Error!', 'Ops! <br>' + data.message, 'error');
                    }
                }
            });
        });

        // Hapus Data
    $("#tbl_data").on('click', '.btn_hapus', function(e) {
      e.preventDefault();
      var id_satuan = $(this).attr('data-id');
      Swal.fire({
        title: 'Hapus Data?',
        text: 'Anda Yakin Menghapus Data Satuan ini?',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        cancelButtonText: 'Tidak',
        confirmButtonText: 'Ya',
        showLoaderOnConfirm: true,
        preConfirm: () => {
          return new Promise(function(resolve, reject) {
            $.ajax({
                url: 'satuan/hapusData',
                type: 'POST',
                dataType: "json",
                data: {
                  id_satuan: id_satuan
                }
              })
              .done(function(data) {
                resolve(data)
              })
              .fail(function() {
                reject()
              });
          })
        },
        allowOutsideClick: () => !swal.isLoading()
      }).then((result) => {
        if (result.value) {
          $('#mydata').DataTable().clear().destroy();
          tampil_data();
          Swal.fire({
            icon: 'success',
            title: 'Data Telah Berhasil di Hapus',
            showConfirmButton: false,
            timer: 1500
          });
        }
      });
    });
    </script>
</body>
</html>