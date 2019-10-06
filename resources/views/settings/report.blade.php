@extends('layouts.template')

@section('title', 'Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">Report</h4>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <form id="form_validation" class="uk-form-stacked" method="post" action="{{ route('report-generate') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row">
                                    <label>Report By : </label>
                                    @foreach($typeArr as $key => $val)
                                    <span class="icheck-inline">
                                        <input type="radio" name="report_type" value="{{ $key }}" id="report_type_{{$key}}" data-md-icheck required />
                                        <label for="report_type_{{$key}}" class="inline-label">{{ ucwords($val) }}</label>
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="uk_dp_start">Start Date</label>
                                    <input type="text" name="start_date" id="uk_dp_start" class="md-input" value="{{ old('start_date') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="uk_dp_end">End Date</label>
                                    <input type="text" name="end_date" id="uk_dp_end" class="md-input" value="{{ old('end_date') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" autocomplete="off" required/>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid uk-margin-medium-top">
                            <div class="uk-width-1-1 uk-text-right">
                                <button type="submit" class="md-btn md-btn-primary">Go</button>
                                <a href="{{ route('report') }}" class="md-btn md-btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
@endpush
