@extends('layouts.dashboard-layouts')

@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">Daftar Perangkat Nagari</h4>
                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalCreate">
                        Tambah Perangkat
                    </button>

                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Kontak</th>
                                    <th>Foto</th>
                                    <th>Facebook</th>
                                    <th>Instagram</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($perangkat as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->jabatan }}</td>
                                        <td>{{ $item->kontak }}</td>
                                        <td>
                                            @if ($item->image)
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Foto"
                                                    width="50">
                                            @else
                                                <span class="text-muted">Tidak ada foto</span>
                                            @endif
                                        </td>
                                        <td>{{ $item->facebook }}</td>
                                        <td>{{ $item->instagram }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#modalEdit{{ $item->id }}">
                                                Edit
                                            </button>

                                            <form action="{{ route('perangkat.destroy', $item->id) }}" method="POST"
                                                class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                    class="btn btn-sm btn-danger btn-delete">Hapus</button>
                                            </form>



                                        </td>
                                    </tr>
                                    <!-- Modal Edit Perangkat -->
                                    <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1"
                                        aria-labelledby="modalEditLabel{{ $item->id }}" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <form action="{{ route('perangkat.update', $item->id) }}" method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="modalEditLabel{{ $item->id }}">
                                                            Edit Perangkat Nagari</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Tutup"></button>
                                                    </div>
                                                    <div class="modal-body row">
                                                        <div class="mb-3 col-md-6">
                                                            <label for="nama{{ $item->id }}"
                                                                class="form-label">Nama</label>
                                                            <input type="text" name="nama"
                                                                id="nama{{ $item->id }}" class="form-control"
                                                                value="{{ $item->nama }}" required>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="nip{{ $item->id }}"
                                                                class="form-label">NIP</label>
                                                            <input type="text" name="nip"
                                                                id="nip{{ $item->id }}" class="form-control"
                                                                value="{{ $item->nip }}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="jabatan{{ $item->id }}"
                                                                class="form-label">Jabatan</label>
                                                            <input type="text" name="jabatan"
                                                                id="jabatan{{ $item->id }}" class="form-control"
                                                                value="{{ $item->jabatan }}" required>
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="kontak{{ $item->id }}"
                                                                class="form-label">Kontak</label>
                                                            <input type="text" name="kontak"
                                                                id="kontak{{ $item->id }}" class="form-control"
                                                                value="{{ $item->kontak }}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="facebook{{ $item->id }}"
                                                                class="form-label">Facebook</label>
                                                            <input type="text" name="facebook"
                                                                id="facebook{{ $item->id }}" class="form-control"
                                                                value="{{ $item->facebook }}">
                                                        </div>
                                                        <div class="mb-3 col-md-6">
                                                            <label for="instagram{{ $item->id }}"
                                                                class="form-label">Instagram</label>
                                                            <input type="text" name="instagram"
                                                                id="instagram{{ $item->id }}" class="form-control"
                                                                value="{{ $item->instagram }}">
                                                        </div>
                                                        <div class="mb-3 col-md-12">
                                                            <label for="image{{ $item->id }}"
                                                                class="form-label">Foto</label>
                                                            <input type="file" name="image"
                                                                id="image{{ $item->id }}" class="form-control">
                                                            @if ($item->image)
                                                                <small>Foto saat ini:</small><br>
                                                                <img src="{{ asset('storage/' . $item->image) }}"
                                                                    alt="Foto" width="80">
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Batal</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Perangkat -->
    <div class="modal fade" id="modalCreate" tabindex="-1" aria-labelledby="modalCreateLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <form action="{{ route('perangkat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalCreateLabel">Tambah Perangkat Nagari</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body row">
                        <div class="mb-3 col-md-6">
                            <label for="nama" class="form-label">Nama</label>
                            <input type="text" name="nama" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" name="nip" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="jabatan" class="form-label">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" required>
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="kontak" class="form-label">Kontak</label>
                            <input type="text" name="kontak" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="facebook" class="form-label">Facebook</label>
                            <input type="text" name="facebook" class="form-control">
                        </div>
                        <div class="mb-3 col-md-6">
                            <label for="instagram" class="form-label">Instagram</label>
                            <input type="text" name="instagram" class="form-control">
                        </div>
                        <div class="mb-3 col-md-12">
                            <label for="image" class="form-label">Foto</label>
                            <input type="file" name="image" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault(); // supaya form tidak langsung submit

                    const form = this.closest('form');

                    Swal.fire({
                        title: 'Yakin ingin menghapus?',
                        text: "Data yang dihapus tidak bisa dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
