@extends('components.layouts.app')

@section('content')
    <div class="card shadow-sm rounded-lg mb-4">
        <div class="card-header bg-white py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pendaftaran Beasiswa Anda</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-light">
                        <tr>
                            <th class="text-center">No</th>
                            <th>Nama Beasiswa</th>
                            <th class="text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayatPendaftaran as $index => $pendaftaran)
                            <tr>
                                <td class="text-center">{{ $index + 1 }}</td>
                                <td>{{ $pendaftaran->beasiswa->nama_beasiswa }}</td>
                                <td class="text-center">
                                    @if ($pendaftaran->status_verifikasi === 'disetujui')
                                        <span class="badge bg-success py-2 px-3 rounded-pill">Diterima</span>
                                    @elseif ($pendaftaran->status_verifikasi === 'ditolak')
                                        <span class="badge bg-danger py-2 px-3 rounded-pill">Ditolak</span>
                                    @else
                                        <span class="badge bg-warning text-dark py-2 px-3 rounded-pill">Diproses</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-4">Belum ada riwayat pendaftaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
