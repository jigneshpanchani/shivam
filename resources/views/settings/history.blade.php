@extends('layouts.template')

@section('title', 'Remove Oldest Work Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">Remove Oldest Work Report</h4>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <form id="form_validation" class="uk-form-stacked" method="post" action="{{ route('remove-history') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-large-1-3 uk-width-1-1">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
                                    <label for="uk_dp_start">Start Date</label>
                                    <input type="text" name="start_date" id="uk_dp_start" class="md-input" value="{{ old('start_date') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="uk-width-large-1-3 uk-width-medium-1-1">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon"><i class="uk-input-group-icon uk-icon-calendar"></i></span>
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
                                <button type="submit" class="md-btn md-btn-primary">Delete</button>
                                <a href="{{ route('work.index') }}" class="md-btn md-btn-danger">Cancel</a>
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
