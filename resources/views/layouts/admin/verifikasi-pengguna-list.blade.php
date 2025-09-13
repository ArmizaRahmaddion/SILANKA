@extends('layouts.dashboard-layouts', ['title' => 'Verifikasi Pengguna'])
@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Verifikasi Pengguna</h4>
                    </div>
                </div>
                <div class="card-body">
                    @if ($users->isEmpty())
                        <div class="alert alert-danger text-center">
                            Tidak ada pengguna yang menunggu verifikasi.
                        </div>
                    @else
                        <div class="table-responsive">
                            <table id="datatable" class="table table-striped" data-toggle="data-table">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>NIK</th>
                                        <th>Nomor HP</th>
                                        <th>Jenis Kelamin</th>
                                        <th>Tanggal Daftar</th>
                                        <th>Status</th>
                                        <th>Foto Ktp</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $user->nama_lengkap }}</td>
                                            <td>{{ $user->nik }}</td>
                                            <td>{{ $user->nomor_hp }}</td>
                                            <td>{{ $user->jenis_kelamin }}</td>
                                            <td>{{ $user->created_at->format('d M Y') }}</td>
                                            <td><span
                                                    class="badge bg-warning py-2 px-1 text-capitalize">{{ $user->status }}</span>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                    data-bs-target="#ktpModal{{ $user->id }}">
                                                    Lihat KTP
                                                </button>
                                            </td>
                                            <td>
                                                <button type="button" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                                    data-bs-target="#verifiedModal{{ $user->id }}">
                                                    Verifikasi
                                                </button>
                                                <button type="button" class="btn btn-sm btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#rejectModal{{ $user->id }}">
                                                    Tolak
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Modals untuk setiap user -->
                        @foreach ($users as $user)
                            <div class="modal fade" id="ktpModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="ktpModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="ktpModalLabel{{ $user->id }}">Foto KTP -
                                                {{ $user->nama_lengkap }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Tutup"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $user->foto_ktp) }}" alt="Foto KTP"
                                                class="img-fluid rounded border shadow">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="rejectModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="rejectModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('verifikasi.tolak', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="rejectModalLabel{{ $user->id }}">
                                                    Tolak Verifikasi - {{ $user->nama_lengkap }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label for="alasanPenolakan{{ $user->id }}"
                                                        class="form-label">Alasan Penolakan</label>
                                                    <textarea name="pesan_penolakan" id="alasanPenolakan{{ $user->id }}" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-danger">Kirim Penolakan</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="modal fade" id="verifiedModal{{ $user->id }}" tabindex="-1"
                                aria-labelledby="rejectModalLabel{{ $user->id }}" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <form action="{{ route('verifikasi.terima', $user->id) }}" method="POST">
                                            @csrf
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="verifiedModalLabel{{ $user->id }}">
                                                    Terima Verifikasi - {{ $user->nama_lengkap }}
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Tutup"></button>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Verifikasi</button>
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Batal</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
