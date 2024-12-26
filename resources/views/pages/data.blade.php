@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
    <div class="col-12">
        <div class="card card-flush h-xl-100">
            <div class="card-header pt-7">
                <h3 class="card-title align-items-start flex-column">
                    <span class="card-label fw-bold text-gray-800">Itemset</span>
                    <span class="text-gray-500 mt-1 fw-semibold fs-6">{{ $data->total() }} Total Data</span>
                </h3>
                <div class="card-toolbar">
                    <div class="d-flex flex-stack flex-wrap gap-4">
                        <form method="GET" class="position-relative my-1">
                            <input type="hidden" name="page" value="{{ request('page', 1) }}">
                            <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4"></i>
                            <input type="text" name="q" value="{{ request('q') }}" class="form-control w-200px fs-7 ps-12" placeholder="Search" />
                        </form>
                        <a href="#" class="btn btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#add">
                          <i class="ki-outline ki-plus fs-1"></i>                        
                        </a>
                        <a href="#" class="btn btn-icon btn-dark" data-bs-toggle="modal" data-bs-target="#import">
                          <i class="ki-outline ki-file-up fs-1"></i>                      
                        </a>
                        <button id="{{ route('data.destroy.all') }}" class="btn btn-icon btn-danger btn-del">
                          <i class="ki-outline ki-trash fs-1"></i>                      
                        </button>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" id="add">
                  <div class="modal-dialog modal-dialog-centered modal-lg">
                      <form method="POST" action="{{ route('data.store') }}" class="modal-content" id="form">
                        @csrf
                          <div class="modal-header">
                              <h3 class="modal-title">Add New Itemset</h3>
                              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class="row">
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Family Number ID</label>
                                <input type="number" name="family_number_id" class="form-control form-control-solid @error('family_number_id') is-invalid @enderror"  value="{{ old('family_number_id') }}" placeholder="Family Number ID" required/>
                                @error('family_number_id')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Name</label>
                                <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"  value="{{ old('name') }}" placeholder="Name" required/>
                                @error('name')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">District</label>
                                <select name="district" id="district" class="form-control form-control-solid @error('district') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                                  <option></option>
                                  <option value="MEDAN AMPLAS" {{ old('district') == 'MEDAN AMPLAS' ? 'selected' : '' }}>MEDAN AMPLAS</option>
                                  <option value="MEDAN AREA" {{ old('district') == 'MEDAN AREA' ? 'selected' : '' }}>MEDAN AREA</option>
                                  <option value="MEDAN BARAT" {{ old('district') == 'MEDAN BARAT' ? 'selected' : '' }}>MEDAN BARAT</option>
                                  <option value="MEDAN BARU" {{ old('district') == 'MEDAN BARU' ? 'selected' : '' }}>MEDAN BARU</option>
                                  <option value="MEDAN BELAWAN" {{ old('district') == 'MEDAN BELAWAN' ? 'selected' : '' }}>MEDAN BELAWAN</option>
                                  <option value="MEDAN DELI" {{ old('district') == 'MEDAN DELI' ? 'selected' : '' }}>MEDAN DELI</option>
                                  <option value="MEDAN DENAI" {{ old('district') == 'MEDAN DENAI' ? 'selected' : '' }}>MEDAN DENAI</option>
                                  <option value="MEDAN HELVETIA" {{ old('district') == 'MEDAN HELVETIA' ? 'selected' : '' }}>MEDAN HELVETIA</option>
                                  <option value="MEDAN JOHOR" {{ old('district') == 'MEDAN JOHOR' ? 'selected' : '' }}>MEDAN JOHOR</option>
                                  <option value="MEDAN KOTA" {{ old('district') == 'MEDAN KOTA' ? 'selected' : '' }}>MEDAN KOTA</option>
                                  <option value="MEDAN LABUHAN" {{ old('district') == 'MEDAN LABUHAN' ? 'selected' : '' }}>MEDAN LABUHAN</option>
                                  <option value="MEDAN MAIMUN" {{ old('district') == 'MEDAN MAIMUN' ? 'selected' : '' }}>MEDAN MAIMUN</option>
                                  <option value="MEDAN MARELAN" {{ old('district') == 'MEDAN MARELAN' ? 'selected' : '' }}>MEDAN MARELAN</option>
                                  <option value="MEDAN PERJUANGAN" {{ old('district') == 'MEDAN PERJUANGAN' ? 'selected' : '' }}>MEDAN PERJUANGAN</option>
                                  <option value="MEDAN PETISAH" {{ old('district') == 'MEDAN PETISAH' ? 'selected' : '' }}>MEDAN PETISAH</option>
                                  <option value="MEDAN POLONIA" {{ old('district') == 'MEDAN POLONIA' ? 'selected' : '' }}>MEDAN POLONIA</option>
                                  <option value="MEDAN SELAYANG" {{ old('district') == 'MEDAN SELAYANG' ? 'selected' : '' }}>MEDAN SELAYANG</option>
                                  <option value="MEDAN SUNGGAL" {{ old('district') == 'MEDAN SUNGGAL' ? 'selected' : '' }}>MEDAN SUNGGAL</option>
                                  <option value="MEDAN TEMBUNG" {{ old('district') == 'MEDAN TEMBUNG' ? 'selected' : '' }}>MEDAN TEMBUNG</option>
                                  <option value="MEDAN TIMUR" {{ old('district') == 'MEDAN TIMUR' ? 'selected' : '' }}>MEDAN TIMUR</option>
                                  <option value="MEDAN TUNTUNGAN" {{ old('district') == 'MEDAN TUNTUNGAN' ? 'selected' : '' }}>MEDAN TUNTUNGAN</option>
                                </select>
                                @error('district')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                            <div class="row">
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Income</label>
                                <select name="income" id="income" class="form-control form-control-solid @error('income') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                                  <option></option>
                                  <option value="Rp 0 - 1.000.000" {{ old('income') == 'Rp 0 - 1.000.000' ? 'selected' : '' }}>Rp 0 - 1.000.000</option>
                                  <option value="Rp 1.000.000 - 3.000.000" {{ old('income') == 'Rp 1.000.000 - 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                  <option value="Rp 3.000.000 - 4.500.000" {{ old('income') == 'Rp 3.000.000 - 4.500.000' ? 'selected' : '' }}>Rp 3.000.000 - 4.500.000</option>
                                  <option value="Rp 4.500.000 - 6.000.000" {{ old('income') == 'Rp 4.500.000 - 6.000.000' ? 'selected' : '' }}>Rp 4.500.000 - 6.000.000</option>
                                  <option value="> Rp 6.000.000" {{ old('income') == '> Rp 6.000.000' ? 'selected' : '' }}>> Rp 6.000.000</option>
                                </select>
                                @error('income')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Spending</label>
                                <select name="spending" id="spending" class="form-control form-control-solid @error('spending') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                                  <option></option>
                                  <option value="Rp 0 - 1.000.000" {{ old('spending') == 'Rp 0 - 1.000.000' ? 'selected' : '' }}>Rp 0 - 1.000.000</option>
                                  <option value="Rp 1.000.000 - 3.000.000" {{ old('spending') == 'Rp 1.000.000 - 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                                  <option value="Rp 3.000.000 - 4.500.000" {{ old('spending') == 'Rp 3.000.000 - 4.500.000' ? 'selected' : '' }}>Rp 3.000.000 - 4.500.000</option>
                                  <option value="Rp 4.500.000 - 6.000.000" {{ old('spending') == 'Rp 4.500.000 - 6.000.000' ? 'selected' : '' }}>Rp 4.500.000 - 6.000.000</option>
                                  <option value="> Rp 6.000.000" {{ old('spending') == '> Rp 6.000.000' ? 'selected' : '' }}>> Rp 6.000.000</option>
                                </select>
                                @error('spending')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                            <div class="row">
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Job</label>
                                <input type="text" name="job" class="form-control form-control-solid @error('job') is-invalid @enderror"  value="{{ old('job') }}" placeholder="Job" required/>
                                @error('job')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="form-label">Disability Type</label>
                                <select name="disability_type" id="disability_type" class="form-control form-control-solid @error('disability_type') is-invalid @enderror" data-control="select2" data-placeholder="Select an option">
                                  <option></option>
                                  <option value="Disabilitas Fisik" {{ old('disability_type') == 'Disabilitas Fisik' ? 'selected' : '' }}>Disabilitas Fisik</option>
                                  <option value=" Disabilitas Rungu/Wicara" {{ old('disability_type') == ' Disabilitas Rungu/Wicara' ? 'selected' : '' }}> Disabilitas Rungu/Wicara</option>
                                  <option value="Disabilitas Mental/Jiwa" {{ old('disability_type') == 'Disabilitas Mental/Jiwa' ? 'selected' : '' }}>Disabilitas Mental/Jiwa</option>
                                  <option value="Disabilitas Lainnya" {{ old('disability_type') == 'Disabilitas Lainnya' ? 'selected' : '' }}>Disabilitas Lainnya</option>
                                </select>
                                @error('disability_type')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                            <div class="row">
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Residence Condition</label>
                                <select name="residence_condition" id="residence_condition" class="form-control form-control-solid @error('residence_condition') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                                  <option></option>
                                  <option value="Papan" {{ old('residence_condition') == 'Papan' ? 'selected' : '' }}>Papan</option>
                                  <option value="Semi Permanen" {{ old('residence_condition') == 'Semi Permanen' ? 'selected' : '' }}>Semi Permanen</option>
                                  <option value="Permanen" {{ old('residence_condition') == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                                </select>
                                @error('residence_condition')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                              <div class="col mb-5">
                                <label for="exampleFormControlInput1" class="required form-label">Electricity Capacity</label>
                                <select name="electricity_capacity" id="electricity_capacity" class="form-control form-control-solid @error('electricity_capacity') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                                  <option></option>
                                  <option value="450 watt" {{ old('electricity_capacity') == '450 watt' ? 'selected' : '' }}>450 watt</option>
                                  <option value="900 watt" {{ old('electricity_capacity') == '900 watt' ? 'selected' : '' }}>900 watt</option>
                                  <option value="> 900 watt" {{ old('electricity_capacity') == '> 900 watt' ? 'selected' : '' }}>> 900 watt</option>
                                </select>
                                @error('electricity_capacity')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                @enderror
                              </div>
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" id="submit" class="btn btn-dark">
                                <span class="indicator-label">Save</span>
                                <span class="indicator-progress" style="display: none;">Loading... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                              </button>
                          </div>
                      </form>
                  </div>
                </div>

                <div class="modal fade" tabindex="-1" id="import">
                  <div class="modal-dialog modal-dialog-centered">
                      <form method="POST" action="{{ route('data.import') }}" enctype="multipart/form-data" class="modal-content" id="form">
                        @csrf
                          <div class="modal-header">
                              <h3 class="modal-title">Import Itemset</h3>
                              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class="col mb-5">
                                <div id="dropZone" class="drop-zone border-2 border-dashed rounded p-4 text-center bg-light py-20 cursor-pointer">
                                    <p class="mb-0 fs-5 fw-semibold">Drag and drop a file here or click to select</p>
                                    <input type="file" name="file" id="fileInput" class="form-control d-none @error('file') is-invalid @enderror" required/>
                                </div>
                                @error('file')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                              <button type="submit" id="submit" class="btn btn-dark">
                                <span class="indicator-label">Submit</span>
                                <span class="indicator-progress" style="display: none;">Loading... 
                                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
                              </button>
                          </div>
                      </form>
                  </div>
                </div>
            </div>
            <div class="card-body pt-2 table-responsive">
                <table class="table align-middle table-row-dashed fs-6 gy-3">
                    <thead>
                        <tr class="text-start text-gray-500 fw-bold fs-7 text-uppercase gs-0">
                            <th class="min-w-100px">Family Number ID</th>
                            <th class="text-end min-w-200px">Name</th>
                            <th class="text-end min-w-150px">District</th>
                            <th class="text-end min-w-200px">Income</th>
                            <th class="text-end min-w-200px">Spending</th>
                            <th class="text-end min-w-100px">Job</th>
                            <th class="text-end min-w-200px">Disability Type</th>
                            <th class="text-end min-w-100px">Residence Condition</th>
                            <th class="text-end min-w-100px">electricity Capacity</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody class="fw-bold text-gray-600">
                      @if ($data->total() == 0)
                        <tr class="max-w-10px">
                          <td colspan="9" class="text-center">
                            No data available in table
                          </td>
                        </tr>
                      @else
                        @foreach ($data as $item)
                          <tr>
                              <td>
                                  <span class="text-gray-800">{{ $item->family_number_id }}</span>
                              </td>
                              <td class="text-end">{{ $item->name }}</td>
                              <td class="text-end">{{ $item->district }}</td>
                              <td class="text-end">{{ $item->income }}</td>
                              <td class="text-end">{{ $item->spending }}</td>
                              <td class="text-end">{{ $item->job }}</td>
                              <td class="text-end">{{ $item->disability_type }}</td>
                              <td class="text-end">{{ $item->residence_condition }}</td>
                              <td class="text-end">{{ $item->electricity_capacity }}</td>
                              <td class="text-end">
                                <a href="#" class="btn btn-icon btn-light btn-active-light-primary toggle h-25px w-25px" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">
                                  <i class="ki-outline ki-dots-vertical fs-1"></i>
                                </a>
                                <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4" data-kt-menu="true">
                                  <div class="menu-item px-3">
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#edit{{$item->id}}" class="menu-link px-3">Edit</a>
                                  </div>
                                  <div class="menu-item px-3">
                                    <a id="{{ route('data.destroy', $item->id) }}" class="menu-link px-3 btn-del">Hapus</a>
                                  </div>
                                </div>
                              </td>
                          </tr>
                        @endforeach
                      @endif  
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
              <div class="d-flex flex-stack flex-wrap my-3">
                <div class="fs-6 fw-semibold text-gray-700">
                    Showing {{ $data->firstItem() ?? 0 }} to {{ $data->lastItem() }} of {{ $data->total() }}  records
                </div>
                <ul class="pagination">
                    @if ($data->onFirstPage())
                        <li class="page-item previous">
                            <a href="#" class="page-link"><i class="previous"></i></a>
                        </li>
                    @else
                        <li class="page-item previous">
                            <a href="{{ $data->previousPageUrl() }}" class="page-link bg-light"><i class="previous"></i></a>
                        </li>
                    @endif
            
                    @php
                        $start = max($data->currentPage() - 2, 1);
                        $end = min($start + 4, $data->lastPage());
                    @endphp
            
                    @if ($start > 1)
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
            
                    @foreach ($data->getUrlRange($start, $end) as $page => $url)
                        <li class="page-item{{ ($page == $data->currentPage()) ? ' active' : '' }}">
                            <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                        </li>
                    @endforeach
            
                    @if ($end < $data->lastPage())
                        <li class="page-item disabled">
                            <span class="page-link">...</span>
                        </li>
                    @endif
            
                    @if ($data->hasMorePages())
                        <li class="page-item next">
                            <a href="{{ $data->nextPageUrl() }}" class="page-link bg-light"><i class="next"></i></a>
                        </li>
                    @else
                        <li class="page-item next">
                            <a href="#" class="page-link"><i class="next"></i></a>
                        </li>
                    @endif
            </div>
        </div>
    </div>
</div>

@foreach ($data as $item)
<div class="modal fade" tabindex="-1" id="edit{{$item->id}}">
  <div class="modal-dialog modal-dialog-centered modal-lg">
      <form method="POST" action="{{ route('data.update', $item->id) }}" class="modal-content" id="form">
        @csrf
          <div class="modal-header">
              <h3 class="modal-title">Edit Itemset</h3>
              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
              </div>
          </div>
          <div class="modal-body">
            <div class="row">
              <div class="col mb-5">
                <label for="family_number_id" class="required form-label">Family Number ID</label>
                <input type="number" name="family_number_id" class="form-control form-control-solid @error('family_number_id') is-invalid @enderror" value="{{ old('family_number_id', $item->family_number_id) }}" placeholder="Family Number ID" required />
                @error('family_number_id')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col mb-5">
                <label for="name" class="required form-label">Name</label>
                <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror" value="{{ old('name', $item->name) }}" placeholder="Name" required />
                @error('name')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col mb-5">
                <label for="district" class="required form-label">District</label>
                <select name="district" id="district{{$item->id}}" class="form-control form-control-solid @error('district') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                  <option></option>
                  <option value="MEDAN AMPLAS" {{ old('district', $item->district) == 'MEDAN AMPLAS' ? 'selected' : '' }}>MEDAN AMPLAS</option>
                  <option value="MEDAN AREA" {{ old('district', $item->district) == 'MEDAN AREA' ? 'selected' : '' }}>MEDAN AREA</option>
                  <option value="MEDAN BARAT" {{ old('district', $item->district) == 'MEDAN BARAT' ? 'selected' : '' }}>MEDAN BARAT</option>
                  <option value="MEDAN BARU" {{ old('district', $item->district) == 'MEDAN BARU' ? 'selected' : '' }}>MEDAN BARU</option>
                  <option value="MEDAN BELAWAN" {{ old('district', $item->district) == 'MEDAN BELAWAN' ? 'selected' : '' }}>MEDAN BELAWAN</option>
                  <option value="MEDAN DELI" {{ old('district', $item->district) == 'MEDAN DELI' ? 'selected' : '' }}>MEDAN DELI</option>
                  <option value="MEDAN DENAI" {{ old('district', $item->district) == 'MEDAN DENAI' ? 'selected' : '' }}>MEDAN DENAI</option>
                  <option value="MEDAN HELVETIA" {{ old('district', $item->district) == 'MEDAN HELVETIA' ? 'selected' : '' }}>MEDAN HELVETIA</option>
                  <option value="MEDAN JOHOR" {{ old('district', $item->district) == 'MEDAN JOHOR' ? 'selected' : '' }}>MEDAN JOHOR</option>
                  <option value="MEDAN KOTA" {{ old('district', $item->district) == 'MEDAN KOTA' ? 'selected' : '' }}>MEDAN KOTA</option>
                  <option value="MEDAN LABUHAN" {{ old('district', $item->district) == 'MEDAN LABUHAN' ? 'selected' : '' }}>MEDAN LABUHAN</option>
                  <option value="MEDAN MAIMUN" {{ old('district', $item->district) == 'MEDAN MAIMUN' ? 'selected' : '' }}>MEDAN MAIMUN</option>
                  <option value="MEDAN MARELAN" {{ old('district', $item->district) == 'MEDAN MARELAN' ? 'selected' : '' }}>MEDAN MARELAN</option>
                  <option value="MEDAN PERJUANGAN" {{ old('district', $item->district) == 'MEDAN PERJUANGAN' ? 'selected' : '' }}>MEDAN PERJUANGAN</option>
                  <option value="MEDAN PETISAH" {{ old('district', $item->district) == 'MEDAN PETISAH' ? 'selected' : '' }}>MEDAN PETISAH</option>
                  <option value="MEDAN POLONIA" {{ old('district', $item->district) == 'MEDAN POLONIA' ? 'selected' : '' }}>MEDAN POLONIA</option>
                  <option value="MEDAN SELAYANG" {{ old('district', $item->district) == 'MEDAN SELAYANG' ? 'selected' : '' }}>MEDAN SELAYANG</option>
                  <option value="MEDAN SUNGGAL" {{ old('district', $item->district) == 'MEDAN SUNGGAL' ? 'selected' : '' }}>MEDAN SUNGGAL</option>
                  <option value="MEDAN TEMBUNG" {{ old('district', $item->district) == 'MEDAN TEMBUNG' ? 'selected' : '' }}>MEDAN TEMBUNG</option>
                  <option value="MEDAN TIMUR" {{ old('district', $item->district) == 'MEDAN TIMUR' ? 'selected' : '' }}>MEDAN TIMUR</option>
                  <option value="MEDAN TUNTUNGAN" {{ old('district', $item->district) == 'MEDAN TUNTUNGAN' ? 'selected' : '' }}>MEDAN TUNTUNGAN</option>
                </select>
                @error('district')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col mb-5">
                <label for="income" class="required form-label">Income</label>
                <select name="income" id="income{{$item->id}}" class="form-control form-control-solid @error('income') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                  <option></option>
                  <option value="Rp 0 - 1.000.000" {{ old('income', $item->income) == 'Rp 0 - 1.000.000' ? 'selected' : '' }}>Rp 0 - 1.000.000</option>
                  <option value="Rp 1.000.000 - 3.000.000" {{ old('income', $item->income) == 'Rp 1.000.000 - 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                  <option value="Rp 3.000.000 - 4.500.000" {{ old('income', $item->income) == 'Rp 3.000.000 - 4.500.000' ? 'selected' : '' }}>Rp 3.000.000 - 4.500.000</option>
                  <option value="Rp 4.500.000 - 6.000.000" {{ old('income', $item->income) == 'Rp 4.500.000 - 6.000.000' ? 'selected' : '' }}>Rp 4.500.000 - 6.000.000</option>
                  <option value="> Rp 6.000.000" {{ old('income', $item->income) == '> Rp 6.000.000' ? 'selected' : '' }}>> Rp 6.000.000</option>
                </select>
                @error('income')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col mb-5">
                <label for="spending" class="required form-label">Spending</label>
                <select name="spending" id="spending{{$item->id}}" class="form-control form-control-solid @error('spending') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                  <option></option>
                  <option value="Rp 0 - 1.000.000" {{ old('spending', $item->spending) == 'Rp 0 - 1.000.000' ? 'selected' : '' }}>Rp 0 - 1.000.000</option>
                  <option value="Rp 1.000.000 - 3.000.000" {{ old('spending', $item->spending) == 'Rp 1.000.000 - 3.000.000' ? 'selected' : '' }}>Rp 1.000.000 - 3.000.000</option>
                  <option value="Rp 3.000.000 - 4.500.000" {{ old('spending', $item->spending) == 'Rp 3.000.000 - 4.500.000' ? 'selected' : '' }}>Rp 3.000.000 - 4.500.000</option>
                  <option value="Rp 4.500.000 - 6.000.000" {{ old('spending', $item->spending) == 'Rp 4.500.000 - 6.000.000' ? 'selected' : '' }}>Rp 4.500.000 - 6.000.000</option>
                  <option value="> Rp 6.000.000" {{ old('spending', $item->spending) == '> Rp 6.000.000' ? 'selected' : '' }}>> Rp 6.000.000</option>
                </select>
                @error('spending')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col mb-5">
                <label for="job" class="required form-label">Job</label>
                <input type="text" name="job" class="form-control form-control-solid @error('job') is-invalid @enderror" value="{{ old('job', $item->job) }}" placeholder="Job" required />
                @error('job')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col mb-5">
                <label for="disability_type" class="required form-label">Disability Type</label>
                <select name="disability_type" id="disability_type{{$item->id}}" class="form-control form-control-solid @error('disability_type') is-invalid @enderror" data-control="select2" data-placeholder="Select an option">
                  <option></option>
                  <option value="Disabilitas Fisik" {{ old('disability_type', $item->disability_type) == 'Disabilitas Fisik' ? 'selected' : '' }}>Disabilitas Fisik</option>
                  <option value="Disabilitas Rungu/Wicara" {{ old('disability_type', $item->disability_type) == 'Disabilitas Rungu/Wicara' ? 'selected' : '' }}>Disabilitas Rungu/Wicara</option>
                  <option value="Disabilitas Mental/Jiwa" {{ old('disability_type', $item->disability_type) == 'Disabilitas Mental/Jiwa' ? 'selected' : '' }}>Disabilitas Mental/Jiwa</option>
                  <option value="Disabilitas Lainnya" {{ old('disability_type', $item->disability_type) == 'Disabilitas Lainnya' ? 'selected' : '' }}>Disabilitas Lainnya</option>
                </select>
                @error('disability_type')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
            <div class="row">
              <div class="col mb-5">
                <label for="residence_condition" class="required form-label">Residence Condition</label>
                <select name="residence_condition" id="residence_condition{{$item->id}}" class="form-control form-control-solid @error('residence_condition') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                  <option></option>
                  <option value="Papan" {{ old('residence_condition', $item->residence_condition) == 'Papan' ? 'selected' : '' }}>Papan</option>
                  <option value="Semi Permanen" {{ old('residence_condition', $item->residence_condition) == 'Semi Permanen' ? 'selected' : '' }}>Semi Permanen</option>
                  <option value="Permanen" {{ old('residence_condition', $item->residence_condition) == 'Permanen' ? 'selected' : '' }}>Permanen</option>
                </select>
                @error('residence_condition')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="col mb-5">
                <label for="electricity_capacity" class="required form-label">Electricity Capacity</label>
                <select name="electricity_capacity" id="electricity_capacity{{$item->id}}" class="form-control form-control-solid @error('electricity_capacity') is-invalid @enderror" data-control="select2" data-placeholder="Select an option" required>
                  <option></option>
                  <option value="450 watt" {{ old('electricity_capacity', $item->electricity_capacity) == '450 watt' ? 'selected' : '' }}>450 watt</option>
                  <option value="900 watt" {{ old('electricity_capacity', $item->electricity_capacity) == '900 watt' ? 'selected' : '' }}>900 watt</option>
                  <option value="> 900 watt" {{ old('electricity_capacity', $item->electricity_capacity) == '> 900 watt' ? 'selected' : '' }}>> 900 watt</option>
                </select>
                @error('electricity_capacity')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" id="submit" class="btn btn-dark">
                <span class="indicator-label">Save</span>
                <span class="indicator-progress" style="display: none;">Loading... 
                <span class="spinner-border spinner-border-sm align-middle ms-2"></span></span>
              </button>
          </div>
      </form>
  </div>
</div>
@endforeach
@endsection

@section('script')
<script>
  const dropZone = document.getElementById('dropZone');
  const fileInput = document.getElementById('fileInput');

  dropZone.addEventListener('click', () => {
      fileInput.click();
  });

  dropZone.addEventListener('dragover', (event) => {
      event.preventDefault();
      dropZone.classList.add('drag-over');
  });

  dropZone.addEventListener('dragleave', () => {
      dropZone.classList.remove('drag-over');
  });

  dropZone.addEventListener('drop', (event) => {
      event.preventDefault();
      dropZone.classList.remove('drag-over');
      if (event.dataTransfer.files.length) {
          fileInput.files = event.dataTransfer.files;
      }
  });

  fileInput.addEventListener('change', () => {
      const fileName = fileInput.files[0] ? fileInput.files[0].name : 'Drag and drop a file here or click to select';
      dropZone.querySelector('p').textContent = fileName;
  });
</script>

<script>
  document.querySelectorAll('form').forEach(function(form) {
    form.addEventListener('submit', function(event) {
      var submitButton = form.querySelector('button[type="submit"]');
      submitButton.querySelector('.indicator-label').style.display = 'none';
      submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
      submitButton.setAttribute('disabled', 'disabled');
    });
  });
</script>
<script>
  document.getElementById('form').addEventListener('submit', function() {
    var submitButton = document.getElementById('submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection

