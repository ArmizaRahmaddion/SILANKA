@extends('layouts.dashboard-layouts', ['title' => 'Data Pengguna'])
@section('content-dashboard')
    <div class="col-md-12 col-lg-12">
        <div class="row row-cols-1">
            <div class="card">
                <div class="card-header d-flex justify-content-between">
                    <div class="header-title">
                        <h4 class="card-title">Data Pengguna</h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="datatable" class="table table-striped" data-toggle="data-table">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Lengkap</th>
                                    <th>Nik</th>
                                    <th>Kontak</th>
                                    <th>Jenis Kelamin</th>
                                    <th>Status</th>
                                    <th>Foto Ktp</th>
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
                                        <td><span
                                                class="badge bg-success py-2 px-1 text-capitalize">{{ $user->status }}</span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-info" data-bs-toggle="modal"
                                                data-bs-target="#ktpModal{{ $user->id }}">
                                                Lihat KTP
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
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
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
