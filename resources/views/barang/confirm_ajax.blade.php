@empty($barang)
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Error</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-danger">
                    <h5><i class="fa fa-ban icon"></i> Error!!</h5>
                    The data you are looking for is not found
                </div>
                <a href="{{ url('/barang') }}" class="btn btn-warning">Return</a>
            </div>
        </div>
    </div>
@else
    <form action="{{ url('/barang/' . $barang->barang_id . '/delete_ajax') }}" method="POST" id="form-delete">
        @csrf
        @method('DELETE')
        <div id="modal-master" class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Delete Barang</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-warning">
                        <h5><i class="icon fas fa-ban"></i> Confirm !!</h5>
                        Do you want to delete this barang?
                    </div>
                    <table class="table table-sm table-bordered table-striped">
                        <tr>
                            <th class="text-right col-3">Barang ID:</th>
                            <td class="col-9">{{ $barang->barang_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Kategori ID:</th>
                            <td class="col-9">{{ $barang->kategori_id }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Barang Kode:</th>
                            <td class="col-9">{{ $barang->barang_kode }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Barang Nama:</th>
                            <td class="col-9">{{ $barang->barang_nama }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Harga Beli:</th>
                            <td class="col-9">{{ $barang->harga_beli }}</td>
                        </tr>
                        <tr>
                            <th class="text-right col-3">Harga Jual:</th>
                            <td class="col-9">{{ $barang->harga_jual }}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" data-dismiss="modal" class="btn btn-warning">Cancel</button>
                    <button type="submit" class="btn btn-danger">Yes, delete</button>
                </div>
            </div>
        </div>
    </form>

    <script>
        $(document).ready(function () {
            $("#form-delete").validate({
                rules: {},
                submitHandler: function (form) {
                    $.ajax({
                        url: form.action,
                        type: form.method,
                        data: $(form).serialize(),
                        success: function (response) {
                            if (response.status) {
                                $('#myModal').modal('hide');
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Succeed',
                                    text: response.message
                                });
                                dataBarang.ajax.reload();
                            } else {
                                $('.error-text').text('');
                                $.each(response.msgField, function (prefix, val) {
                                    $('#error-' + prefix).text(val[0]);
                                });
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Something Went Wrong',
                                    text: response.message
                                });
                            }
                        }
                    });
                    return false;
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
    </script>
@endempty