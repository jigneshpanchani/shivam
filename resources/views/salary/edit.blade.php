@extends('layouts.template')

@section('title', 'Edit Salary')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Edit Salary</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('salary.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_edit" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('salary.update', $result['id']) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="name">Name</label>
                            <input type="text" name="name" value="{{$result['staff']['name']}}" class="md-input" disabled/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row parsley-row">
                            <label for="department">Department</label>
                            <input name="department" value="{{$result['staff']['department']}}" class="md-input" disabled/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row parsley-row">
                            <label for="val_date">Salary Date <span class="req"> * </span></label>
                            <input type="text" name="date" id="val_date" class="md-input" value="{{ (!empty($result['date'])) ? date('d-m-Y', strtotime($result['date'])) : date('d-m-Y', strtotime(old('date'))) }}"
                                   data-parsley-americandate
                                   data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                   data-uk-datepicker="{format:'DD-MM-YYYY'}" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row parsley-row">
                            <label>Salary (₹)<span class="req"> * </span></label>
                            <input type="number" name="amount" value="{{ (!empty($result['amount'])) ? $result['amount'] : old('amount') }}" class="md-input" id="amount" min="0" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Update</button>
                        <a href="{{ route('salary.edit', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
@endpush