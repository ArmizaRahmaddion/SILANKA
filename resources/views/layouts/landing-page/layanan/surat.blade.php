@extends('layouts.landing-page.layout')
@section('content')
    <!-- Page Title -->
    <div class="page-title">
        <div class="heading">
            <div class="container">
                <div class="row d-flex justify-content-center text-center">
                    <div class="col-lg-8">
                        <h1>FORM PENGAJUAN SURAT</h1>
                        <p class="mb-0">Odio et unde deleniti. Deserunt numquam exercitationem. Officiis quo odio sint
                            voluptas consequatur ut a odio voluptatem. Sit dolorum debitis veritatis natus dolores.
                            Quasi ratione sint. Sit quaerat ipsum dolorem.</p>
                    </div>
                </div>
            </div>
        </div>
        <nav class="breadcrumbs">
            <div class="container">
                <ol>
                    <li><a href="{{ url('/') }}">Beranda</a></li>
                    <li class="current">E-Surat</li>
                </ol>
            </div>
        </nav>
    </div><!-- End Page Title -->

    <section id="form-pengajuan-surat" class="py-5 bg-light">
        <div class="container">

            <div class="row justify-content-center mb-4">
                <div class="col-lg-8 text-center">
                    <h2 class="fw-bold mb-3">Pilih Jenis Surat</h2>
                    <p class="text-muted mb-0">Silakan pilih jenis surat yang ingin diajukan. Gunakan kotak pencarian untuk
                        mempermudah.</p>
                </div>
            </div>

            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="input-group shadow-sm">
                        <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                        <input type="text" id="filterSurat" class="form-control border-start-0"
                            placeholder="Cari jenis surat...">
                        <button class="btn btn-outline-secondary" type="button" id="clearFilter" title="Reset">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>
            </div>

            {{-- @php
                $defaultMeta = [
                    'title' => null,
                    'desc' => '-',
                    'icon' => 'bi-file-earmark-text',
                ];

                $metaSurat = [
                    'surat.sktm' => [
                        'title' => 'Surat Keterangan Tidak Mampu',
                        'desc' => 'Keterangan resmi kondisi ekonomi.',
                        'icon' => 'bi-people',
                    ],
                    'surat.skkm' => [
                        'title' => 'Surat Keterangan Meninggal Dunia',
                        'desc' => 'Dokumen keterangan kematian.',
                        'icon' => 'bi-heartbreak',
                    ],
                    'surat.skaw' => [
                        'title' => 'Surat Keterangan Ahli Waris',
                        'desc' => 'Keterangan legal ahli waris.',
                        'icon' => 'bi-diagram-3',
                    ],
                    'surat.skd' => [
                        'title' => 'Surat Keterangan Domisili',
                        'desc' => 'Domisili tempat tinggal resmi.',
                        'icon' => 'bi-geo-alt',
                    ],
                    'surat.sku' => [
                        'title' => 'Surat Keterangan Usaha',
                        'desc' => 'Legalitas dan aktivitas usaha.',
                        'icon' => 'bi-briefcase',
                    ],
                ];

                $jenisSurat = collect($JenisSurat)->map(function ($row) use ($metaSurat, $defaultMeta) {
                    $routeName = $row->route ?? ($row->kode_surat ? 'surat.' . $row->kode_surat : null);

                    $meta =
                        $routeName && isset($metaSurat[$routeName])
                            ? $metaSurat[$routeName]
                            : array_merge($defaultMeta, [
                                'title' => $row->nama_surat ? ucwords($row->nama_surat) : 'Surat Tidak Dikenal',
                            ]);

                    return [
                        'id' => $row->id,
                        'nama_surat' => $row->nama_surat,
                        'route' => $routeName,
                        'title' => $meta['title'],
                        'desc' => $meta['desc'],
                        'icon' => $meta['icon'],
                    ];
                });
            @endphp --}}

            <div class="row g-4" id="suratGrid">
                @forelse ($JenisSurat as $item)
                    <div class="col-6 col-md-6 col-lg-4 surat-item" data-title="{{ strtolower($item->nama_surat) }}">
                        <div class="card h-100 border-0 shadow-sm surat-card position-relative">
                            <div class="card-body d-flex flex-column text-center p-4">

                                {{-- Icon --}}
                                <div class="surat-icon-wrapper mx-auto mb-3">
                                    <i class="bi {{ $item->icon }} surat-icon"></i>
                                </div>

                                {{-- Title --}}
                                <h6 class="fw-semibold mb-2 text-truncate" title="{{ $item->nama_surat }}">
                                    {{ $item->nama_surat }}
                                </h6>

                                {{-- Description --}}
                                <p class="small text-muted mb-3 flex-grow-1">
                                    {{ $item->description ?? 'Tidak ada deskripsi.' }}
                                </p>

                                {{-- Action --}}
                                <a href="{{ route('surat.' . strtolower($item->kode_surat)) }}"
                                    class="stretched-link btn btn-sm btn-outline-primary mt-auto">
                                    Ajukan
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <p class="text-center text-muted mb-0">
                            <i class="bi bi-info-circle me-1"></i>
                            Tidak ada jenis surat tersedia.
                        </p>
                    </div>
                @endforelse
            </div>


            <div id="noResult" class="text-center d-none mt-4">
                <p class="text-muted mb-0"><i class="bi bi-info-circle me-1"></i>Tidak ada jenis surat yang cocok.</p>
            </div>
        </div>

        <style>
            #form-pengajuan-surat .surat-card {
                transition: all .25s ease;
                border-radius: 1rem;
                background: #fff;
            }

            #form-pengajuan-surat .surat-card:hover {
                transform: translateY(-6px);
                box-shadow: 0 0.75rem 1.5rem rgba(0, 0, 0, .08);
            }

            #form-pengajuan-surat .surat-icon-wrapper {
                width: 64px;
                height: 64px;
                border-radius: 50%;
                background: linear-gradient(135deg, #eef2ff, #ffffff);
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: inset 0 0 0 1px #e5e7eb;
            }

            #form-pengajuan-surat .surat-icon {
                font-size: 1.6rem;
                color: #0d6efd;
            }

            @media (min-width: 1400px) {
                #suratGrid .col-lg-3 {
                    flex: 0 0 20%;
                    max-width: 20%;
                }
            }
        </style>

        <script>
            (function() {
                const input = document.getElementById('filterSurat');
                const clearBtn = document.getElementById('clearFilter');
                const items = Array.from(document.querySelectorAll('.surat-item'));
                const noResult = document.getElementById('noResult');

                function filter() {
                    const q = input.value.trim().toLowerCase();
                    let visible = 0;
                    items.forEach(el => {
                        const match = el.dataset.title.includes(q);
                        el.classList.toggle('d-none', !match);
                        if (match) {
                            visible++;
                        }
                    });
                    noResult.classList.toggle('d-none', visible !== 0);
                }

                input.addEventListener('input', filter);
                clearBtn.addEventListener('click', function() {
                    input.value = '';
                    filter();
                    input.focus();
                });
            })();
        </script>
    </section>
@endsection
