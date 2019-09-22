@extends('layouts.template')

@section('title', 'Edit Staff Detail')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Edit Staff Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('staff.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_edit" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('staff.update', $result['id']) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <select id="department" name="department" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Zone" required>
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department }}" {{ ($department==$result['department'])?'selected':'' }}>{{ $department }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="name">Full Name<span class="req"> * </span></label>
                            <input type="text" name="name" value="{{ (!empty($result['name'])) ? $result['name'] : old('name') }}" required class="md-input"/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row parsley-row">
                            <label for="contact_no">Contact No.</label>
                            <input name="contact_no" value="{{ (!empty($result['contact_no'])) ? $result['contact_no'] : old('contact_no') }}" class="md-input masked_input" id="contact_no" type="text" data-inputmask="'mask': '9999 999 999'" data-inputmask-showmaskonhover="false" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-form-row parsley-row">
                            <label for="aadhar_card_no">Aadhar Card No.</label>
                            <input name="aadhar_card_no" value="{{ (!empty($result['aadhar_card_no'])) ? $result['aadhar_card_no'] : old('aadhar_card_no') }}" class="md-input masked_input" id="aadhar_card_no" type="text" data-inputmask="'mask': '9999 - 9999 - 9999'" data-inputmask-showmaskonhover="false" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <div class="uk-input-group">
                            <label>Salary(₹)<span class="req"> * </span></label>
                            <input type="number" name="salary" value="{{ (!empty($result['salary'])) ? $result['salary'] : old('salary') }}" class="md-input" required />
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-2">
                        <div class="parsley-row">
                            <label for="address">Address<span class="req"> * </span></label>
                            <textarea required class="md-input" name="address" cols="10" rows="4">{{ (!empty($result['address'])) ? $result['address'] : old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{ (!empty($result['note'])) ? $result['note'] : old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Update</button>
                        <a href="{{ route('staff.edit', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
    <script src="{{ asset('js/pages/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/forms_advanced.js') }}"></script>
@endpush