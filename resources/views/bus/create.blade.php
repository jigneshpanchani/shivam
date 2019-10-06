@extends('layouts.template')

@section('title', 'Add Bus')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Add Bus Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('bus.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="bus_add" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('bus.store') }}">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="name">Bus Number<span class="req"> * </span></label>
                            <input type="text" name="bus_number" value="{{old('bus_number')}}" class="md-input masked_input" id="bus_number" data-inputmask="'mask': 'AA - 99 - AA - 9999'" data-inputmask-showmaskonhover="false" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">

                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label>Opening Balance (₹)<span class="req"> * </span></label>
                            <input type="number" name="balance" value="{{ old('balance') ? old('balance') : 0 }}" class="md-input" required />
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="parsley-row">
                            <label for="name">Owner Name<span class="req"> * </span></label>
                            <input type="text" name="owner_name" value="{{old('owner_name')}}" class="md-input" id="owner_name" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="contact_no">Type<span class="req"> * </span></label>
                            <input type="text" name="type" value="{{old('type')}}" class="md-input" id="type" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-form-row parsley-row">
                            <label for="root">Root<span class="req"> * </span></label>
                            <input type="text" name="root" value="{{old('root')}}" class="md-input" id="root" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-3">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Fuel Capacity (Ltr.)</span>
                            <input type="number" name="fuel_capacity" id="fuel_capacity" value="{{old('fuel_capacity')}}" class="md-input" min="0" />
                        </div>
                        <br>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Seat Capacity</span>
                            <input type="number" name="seat" id="seat" value="{{old('seat')}}" class="md-input" min="0" />
                        </div>
                    </div>
                    <div class="uk-width-2-3">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{old('note')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-2">
                        <div class="parsley-row">
                            <label for="fitness">Fitness Details</label>
                            <textarea class="md-input" name="fitness" cols="10" rows="4">{{old('fitness')}}</textarea>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="parsley-row">
                            <label for="insurance">Insurance Details</label>
                            <textarea class="md-input" name="insurance" cols="10" rows="4">{{old('insurance')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Save</button>
                        <a href="{{ route('bus.index') }}" class="md-btn md-btn-danger">Cancel</a>
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
