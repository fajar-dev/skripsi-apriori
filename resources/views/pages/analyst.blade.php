@extends('layouts.app')

@section('content')
<div class="row g-5 g-xl-10 mb-5 mb-xl-10">
  <div class="col-lg-8">
      <div class="card card-flush h-xl-100">
          <div class="card-header pt-7">
              <h3 class="card-title align-items-start flex-column">
                  <span class="card-label fw-bold text-gray-800">Apriori Analyst</span>
                  <span class="text-gray-500 mt-1 fw-semibold fs-6">Set the parameters</span>
              </h3>
          </div>
          <form method="GET" action="{{ route('analyst.apriori') }}" id="form">
            <div class="card-body pt-10">
              <div class="mb-5">
                <label for="exampleFormControlInput1" class="required form-label">Min Support</label>
                <input type="number" step="any" name="minSupport" class="form-control form-control-solid"  placeholder="MInimum Support" value="0.2" required/>
              </div>
              <div>
                <label for="exampleFormControlInput1" class="required form-label">Min Confidence</label>
                <input type="number" step="any" name="minConfidence" class="form-control form-control-solid" placeholder="Minimum Confidence" value="0.6" required/>
              </div>
            </div>
            <div class="card-footer d-flex justify-content-end">
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
@endsection

@section('script')
<script>
  document.getElementById('form').addEventListener('submit', function() {
    var submitButton = document.getElementById('submit');
    submitButton.querySelector('.indicator-label').style.display = 'none';
    submitButton.querySelector('.indicator-progress').style.display = 'inline-block';
    submitButton.setAttribute('disabled', 'disabled');
  });
</script>
@endsection

