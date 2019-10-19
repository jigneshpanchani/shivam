@extends('layouts.template')

@section('title', 'Edit Partner')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Edit Partner Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('partner.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_edit" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('partner.update', $result['id']) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="name">Name<span class="req"> * </span></label>
                            <input type="text" name="name" value="{{ (!empty($result['name'])) ? $result['name'] : old('name') }}" class="md-input" id="name" required/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="uk-form-row parsley-row">
                            <label for="contact_no">Contact No.<span class="req"> * </span></label>
                            <input name="contact_no" value="{{ (!empty($result['contact_no'])) ? $result['contact_no'] : old('contact_no') }}" class="md-input masked_input" id="contact_no" type="text" data-inputmask="'mask': '9999 999 999'" data-inputmask-showmaskonhover="false" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-2">
                        <div class="parsley-row">
                            <label for="address">Address<span class="req"> * </span></label>
                            <textarea class="md-input" name="address" cols="10" rows="3" required>{{ (!empty($result['address'])) ? $result['address'] : old('address') }}</textarea>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="3">{{ (!empty($result['note'])) ? $result['note'] : old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-1">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h4 class="heading_a">Select Bus *</h4>
                                <div class="uk-grid" data-uk-grid-margin>
                                    @foreach($buses as $id=>$bus)
                                        @php $status = (in_array($id, $busArr)) ? 'checked' : ''; @endphp
                                        <span class="icheck-inline">
                                            <input type="checkbox" name="bus[{{ $id }}]" id="bus_{{ $id }}" {{ $status }} data-md-icheck />
                                            <label for="bus_{{ $id }}" class="inline-label">{{ str_replace(' - ', ' ', $bus) }}</label>&nbsp;&nbsp;
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Update</button>
                        <a href="{{ route('partner.edit', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
@endpush