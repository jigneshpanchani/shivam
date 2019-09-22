@extends('layouts.template')

@section('title', 'Edit Bus')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Edit Bus Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('bus.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="bus_edit" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('bus.update', $result['id']) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="name">Bus Number<span class="req"> * </span></label>
                            <input type="text" name="bus_number" value="{{ (!empty($result['bus_number'])) ? $result['bus_number'] : old('bus_number') }}" class="md-input masked_input" id="bus_number" data-inputmask="'mask': 'AA - 99 - AA - 9999'" data-inputmask-showmaskonhover="false" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="name">Owner Name<span class="req"> * </span></label>
                            <input type="text" name="owner_name" value="{{ (!empty($result['owner_name'])) ? $result['owner_name'] : old('owner_name') }}" class="md-input" id="owner_name" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="contact_no">Type<span class="req"> * </span></label>
                            <input type="text" name="type" value="{{ (!empty($result['type'])) ? $result['type'] : old('type') }}" class="md-input" id="type" />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="root">Root<span class="req"> * </span></label>
                            <input type="text" name="root" value="{{ (!empty($result['root'])) ? $result['root'] : old('root') }}" class="md-input" id="root" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-3">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Fuel Capacity (Ltr.)</span>
                            <input type="number" name="fuel_capacity" id="fuel_capacity" value="{{ (!empty($result['fuel_capacity'])) ? $result['fuel_capacity'] : old('fuel_capacity') }}" class="md-input" min="0" />
                        </div>
                        <br>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Seat Capacity</span>
                            <input type="number" name="seat" id="seat" value="{{ (!empty($result['seat'])) ? $result['seat'] : old('seat') }}" class="md-input" id="seat" min="0"/>
                        </div>
                    </div>
                    <div class="uk-width-2-3">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{ (!empty($result['note'])) ? $result['note'] : old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Update</button>
                        <a href="{{ route('bus.edit', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
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