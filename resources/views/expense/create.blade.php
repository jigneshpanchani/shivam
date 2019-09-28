@extends('layouts.template')

@section('title', 'Add Expense')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Add Expense Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('expense.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="bus_add" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('expense.store') }}">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="parsley-row">
                            <label for="name">Title<span class="req"> * </span></label>
                            <input type="text" name="name" value="{{old('name')}}" class="md-input" id="name" required/>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{old('note')}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Save</button>
                        <a href="{{ route('expense.index') }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
@endpush
