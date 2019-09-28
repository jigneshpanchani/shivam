@extends('layouts.template')

@section('title', 'Edit Work Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Edit Work Report</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('work.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_edit" id="form_validation" class="uk-form-stacked" method="post" action="{{ route('work.update', $result['id']) }}">
                {{ method_field('PUT') }}
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <select id="bus_id" name="bus_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Bus" required>
                                <option value="">Select Bus</option>
                                @foreach($buses as $bus)
                                    <option value="{{ $bus->id }}" {{ ($bus->id==((!empty($result['bus_id'])) ? $result['bus_id'] : old('bus_id')))?'selected':'' }}>{{ $bus->bus_number }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2"></div>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="work_date">Reporting Date</label>
                            <input type="text" name="work_date" id="work_date" class="md-input"
                                   value="{{ (!empty($result['work_date'])) ? date('d-m-Y', strtotime($result['work_date'])) : date('d-m-Y', strtotime(old('work_date'))) }}"
                                   data-parsley-americandate
                                   data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                   data-uk-datepicker="{format:'DD-MM-YYYY'}" required/>
                        </div>
                    </div>
                </div>
                <br><br>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h3 class="heading_a">Income</h3>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-1">
                                        <?php foreach($result['incomes'] as $rowInc){ ?>
                                            <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                                                <div class="uk-width-9-10">
                                                    <div class="uk-grid">
                                                        <div class="uk-width-1-2">
                                                            <div class="uk-input-group">
                                                                <label>Amount (₹)<span class="req"> * </span></label>
                                                                <input type="number" name="income_amount[]" class="md-input income_amount" min="0" value="{{ $rowInc->amount }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-1-2">
                                                            <div class="parsley-row">
                                                                <label>Detail</label>
                                                                <input type="text" name="income_detail[]" class="md-input income_detail" value="{{ $rowInc->detail }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-10 uk-text-center" style="padding-left: 5px !important;">
                                                    <div class="uk-vertical-align uk-height-1-1">
                                                        <div class="uk-vertical-align-middle">
                                                            <a href="javascript:void(0)" class="btnSectionRemove">
                                                                <i class="material-icons md-24 deleteBtn">&#xE872;</i>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <br>
                                        <div data-dynamic-fields="field_template_a"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h3 class="heading_a">Expense</h3>
                                <div class="uk-grid" data-uk-grid-margin>
                                    <div class="uk-width-medium-1-1">
                                        <?php foreach($result['expenses'] as $rowExp){ ?>
                                            <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                                                <div class="uk-width-9-10">
                                                    <div class="uk-grid">
                                                        <div class="uk-width-1-3">
                                                            <select class="expense_id" name="expense_id[]" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Expense" required>
                                                                <option value="">Select Expense</option>
                                                                @foreach($expenseTypes as $expense)
                                                                    <option value="{{ $expense->id }}" {{ ($expense->id==((!empty($rowExp->expense_id)) ? $rowExp->expense_id : old('expense_id')))?'selected':'' }}>{{ $expense->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="uk-width-1-3">
                                                            <div class="uk-input-group">
                                                                <label>Amount (₹)<span class="req"> * </span></label>
                                                                <input type="number" name="expense_amount[]" class="md-input expense_amount" min="0" value="{{ $rowExp->amount }}" required />
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-1-3">
                                                            <div class="parsley-row">
                                                                <label>Detail</label>
                                                                <input type="text" name="expense_detail[]" class="md-input expense_detail" value="{{ $rowExp->detail }}" />
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="uk-width-1-10 uk-text-center">
                                                    <div class="uk-vertical-align uk-height-1-1">
                                                        <div class="uk-vertical-align-middle">
                                                            <a href="javascript:void(0)" class="btnSectionRemove"><i class="material-icons md-24 deleteBtn">&#xE872;</i></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php } ?>
                                        <br>
                                        <div data-dynamic-fields="field_template_b"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{ (!empty($result['note'])) ? $result['note'] : old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <button type="submit" class="md-btn md-btn-primary">Update</button>
                        <a href="{{ route('work.edit', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>

            <script id="field_template_a" type="text/x-handlebars-template">
                <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                    <div class="uk-width-9-10">
                        <div class="uk-grid">
                            <div class="uk-width-1-2">
                                <div class="uk-input-group">
                                    <label>Amount (₹)<span class="req"> * </span></label>
                                    <input type="number" name="income_amount[]" class="md-input income_amount" min="0" required />
                                </div>
                            </div>
                            <div class="uk-width-1-2">
                                <div class="parsley-row">
                                    <label>Detail</label>
                                    <input type="text" name="income_detail[]" class="md-input income_detail" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-10 uk-text-center" style="padding-left: 5px !important;">
                        <div class="uk-vertical-align uk-height-1-1">
                            <div class="uk-vertical-align-middle">
                                <a href="javascript:void(0)" class="btnSectionClone"><i class="material-icons md-36">&#xE146;</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </script>
            <script id="field_template_b" type="text/x-handlebars-template">
                <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                    <div class="uk-width-9-10">
                        <div class="uk-grid">
                            <div class="uk-width-1-3">
                                <select class="expense_id" name="expense_id[]" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Expense" required>
                                    <option value="">Select Expense</option>
                                    @foreach($expenseTypes as $expense)
                                        <option value="{{ $expense->id }}" {{ ($expense->id==old('expense_id'))?'selected':'' }}>{{ $expense->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="uk-input-group">
                                    <label>Amount (₹)<span class="req"> * </span></label>
                                    <input type="number" name="expense_amount[]" class="md-input expense_amount" min="0" required />
                                </div>
                            </div>
                            <div class="uk-width-1-3">
                                <div class="parsley-row">
                                    <label>Detail</label>
                                    <input type="text" name="expense_detail[]" class="md-input expense_detail" value="" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-10 uk-text-center">
                        <div class="uk-vertical-align uk-height-1-1">
                            <div class="uk-vertical-align-middle">
                                <a href="javascript:void(0)" class="btnSectionClone plusBtn"><i class="material-icons md-36">&#xE146;</i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </script>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bower_components/handlebars/handlebars.min.js') }}"></script>
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            $(document).on('click', '.deleteBtn', function () {
                $(this).closest('.form_section').remove();
            });
        });
    </script>
@endpush