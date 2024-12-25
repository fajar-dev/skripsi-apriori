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
                        <div class="position-relative my-1">
                            <i class="ki-outline ki-magnifier fs-2 position-absolute top-50 translate-middle-y ms-4"></i>
                            <input type="text" data-kt-table-widget-4="search" class="form-control w-200px fs-7 ps-12" placeholder="Search" />
                        </div>
                        <a href="#" class="btn btn-icon btn-secondary" data-bs-toggle="modal" data-bs-target="#add">
                          <i class="ki-outline ki-plus fs-1"></i>                        
                        </a>
                        <a href="#" class="btn btn-icon btn-dark" data-bs-toggle="modal" data-bs-target="#import">
                          <i class="ki-outline ki-file-up fs-1"></i>                      
                        </a>
                    </div>
                </div>
                <div class="modal fade" tabindex="-1" id="add">
                  <div class="modal-dialog modal-dialog-centered">
                      <form method="POST" action="{{ route('data.store') }}" class="modal-content" id="form">
                        @csrf
                          <div class="modal-header">
                              <h3 class="modal-title">Add New Itemset</h3>
                              <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                                  <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                              </div>
                          </div>
                          <div class="modal-body">
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Name</label>
                              <input type="number" name="family_number_id" class="form-control form-control-solid @error('family_number_id') is-invalid @enderror"  value="{{ old('family_number_id') }}" placeholder="Fmily Number id" required/>
                              @error('family_number_id')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Name</label>
                              <input type="text" name="name" class="form-control form-control-solid @error('name') is-invalid @enderror"  value="{{ old('name') }}" placeholder="Name" required/>
                              @error('name')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">District</label>
                              <input type="text" name="district" class="form-control form-control-solid @error('district') is-invalid @enderror"  value="{{ old('district') }}" placeholder="District" required/>
                              @error('district')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror 
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Income</label>
                              <input type="number" name="income" class="form-control form-control-solid @error('income') is-invalid @enderror"  value="{{ old('income') }}" placeholder="Income" required/>
                              @error('income')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            </div>
                            <div class="mb-5">
                              <label for="exampleFormControlInput1" class="required form-label">Spending</label>
                              <input type="number" name="spending" class="form-control form-control-solid @error('spending') is-invalid @enderror"  value="{{ old('spending') }}" placeholder="Spending" required/>
                              @error('spending')
                                <div class="invalid-feedback">
                                  {{ $message }}
                                </div>
                              @enderror
                            
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
@endsection

