@extends('layouts.template')

@section('title', 'Working Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">Daily Working Report</h4>
                </div>
                <div class="uk-width-medium-1-6 uk-text-right">
                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('staff.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <form id="form_validation" class="uk-form-stacked" method="post" action="forms_dynamic.html" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="val_date">Salary Date</label>
                                    <input type="text" name="date" id="val_date" class="md-input" value="{{ date('d-m-Y') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" required/>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div data-dynamic-fields="field_template_a"></div>
                        <div class="uk-grid uk-margin-medium-top">
                            <div class="uk-width-1-1 uk-text-right">
                                <button type="submit" class="md-btn md-btn-primary">Save</button>
                                <a href="{{ route('staff.index') }}" class="md-btn md-btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <script id="field_template_a" type="text/x-handlebars-template">
                        <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                            <div class="uk-width-9-10">
                                <div class="uk-grid">
                                    <div class="uk-width-1-4">
                                        <select id="department" name="department" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Staff Member" required>
                                            <option value="">Select Member</option>
                                            @foreach($staff as $member)
                                                <option value="{{ $member->id }}" data-department="{{ $member->department }}" data-salary="{{ $member->salary }}">{{ $member->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="uk-width-1-4">
                                        <div class="parsley-row">
                                            <label>Department</label>
                                            <input type="text" class="md-input department" name="d_form_department[]" value="- - - -" disabled>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-6">
                                        <div class="parsley-row">
                                            <label>Salary</label>
                                            <input type="text" class="md-input salary" name="d_form_salary[]" value="0" disabled>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-6">
                                        <div class="parsley-row">
                                            <label>Withdrawal</label>
                                            <input type="text" class="md-input withdrawal" name="d_form_withdrawal[]" value="0" disabled>
                                        </div>
                                    </div>
                                    <div class="uk-width-1-6">
                                        <div class="parsley-row uk-text-right">
                                            <label>Salary</label>
                                            {{--<input type="text" class="md-input" name="d_form_salary[]" required>--}}
                                            {{--<input type="text" name="d_form_salary[]" value="{{old('contact_no')}}" class="md-input masked_input" data-inputmask="'mask': '99,99,999'" data-inputmask-showmaskonhover="false" />--}}
                                            <input class="md-input masked_input label-fixed" id="masked_currency" type="text" data-inputmask="'alias': 'currency', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': true, 'prefix': '₹ ', 'placeholder': '0'" data-inputmask-showmaskonhover="false" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-10 uk-text-center">
                                <div class="uk-vertical-align uk-height-1-1">
                                    <div class="uk-vertical-align-middle">
                                        <a href="forms_dynamic.html#" class="btnSectionClone plusBtn"><i class="material-icons md-36">&#xE146;</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="bower_components/handlebars/handlebars.min.js"></script>
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
    <script src="{{ asset('js/pages/jquery.inputmask.bundle.js') }}"></script>
    <script src="{{ asset('js/pages/forms_advanced.js') }}"></script>

    <script type="text/javascript">
        $(document).ready( function () {

            $(document).on('click', '.plusBtn', function () {
                currencyApply();
                select2jsApply();
            });

            function select2jsApply() {
                //$('select').selectize.reload();
            }
            function currencyApply(){
                $('.masked_input').inputmask({'alias': 'currency', 'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 'digitsOptional': true, 'prefix': '₹ ', 'placeholder': '0'});
            }

            $('body').on('change', 'select', function () {
                let department = $('option:selected', this).attr('data-department');
                let salary = $('option:selected', this).attr('data-salary');
                let html = $(this).parent().parent();
                html.find('.department').val(department);
                html.find('.salary').val(salary);
            });
        });
    </script>
@endpush
