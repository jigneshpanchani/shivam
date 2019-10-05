@extends('layouts.template')

@section('title', 'Show Work Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Show Work Report</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('work.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_edit" id="form_validation" class="uk-form-stacked" method="post" action="#">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <select id="bus_id" name="bus_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Bus Number" disabled>
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
                                   data-uk-datepicker="{format:'DD-MM-YYYY'}" readonly/>
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
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid">
                                                        <div class="uk-width-1-2">
                                                            <div class="uk-input-group">
                                                                <label>Amount (₹)</label>
                                                                <input type="number" name="income_amount[]" class="md-input income_amount" min="0" value="{{ $rowInc->amount }}" readonly />
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
                                            </div>
                                        <?php } ?>
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
                                                <div class="uk-width-1-1">
                                                    <div class="uk-grid">
                                                        <div class="uk-width-1-3">
                                                            <select class="expense_id" name="expense_id[]" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Expense Type" disabled>
                                                                <option value="">Select Expense</option>
                                                                @foreach($expenseTypes as $expense)
                                                                    <option value="{{ $expense->id }}" {{ ($expense->id==((!empty($rowExp->expense_id)) ? $rowExp->expense_id : old('expense_id')))?'selected':'' }}>{{ $expense->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="uk-width-1-3">
                                                            <div class="uk-input-group">
                                                                <label>Amount (₹)</label>
                                                                <input type="number" name="expense_amount[]" class="md-input expense_amount" min="0" value="{{ $rowExp->amount }}" readonly />
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
                                            </div>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-3">
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Total Income (₹)</span>
                            <input type="text" name="total_income" id="total_income" value="{{ old('total_income') ? old('total_income') : 0 }}" class="md-input uk-text-right" readonly/>
                        </div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Total Expense (₹)</span>
                            <input type="text" name="total_expense" id="total_expense" value="{{ old('total_expense') ? old('total_expense') : 0 }}" class="md-input uk-text-right" readonly/>
                        </div>
                        <div class="uk-input-group">
                            <span class="uk-input-group-addon">Total (₹)</span>
                            <input type="text" name="total" id="total" value="{{ old('total') ? old('total') : 0 }}" class="md-input uk-text-right" readonly/>
                        </div>
                    </div>
                    <div class="uk-width-medium-2-3">
                        <div class="parsley-row">
                            <label for="note">Extra Note</label>
                            <textarea class="md-input" name="note" cols="10" rows="4">{{ (!empty($result['note'])) ? $result['note'] : old('note') }}</textarea>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <a href="{{ route('work.show', $result['id']) }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bower_components/handlebars/handlebars.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            calculateAmount();
            function calculateAmount() {
                let income = 0;
                let expense = 0;
                $(document).find('.income_amount').each(function (key, value){
                    if(parseInt($(this).val()) > 0){
                        income = income + parseInt($(this).val());
                    }
                });
                $(document).find('.expense_amount').each(function (key, value){
                    if(parseInt($(this).val()) > 0) {
                        expense = expense + parseInt($(this).val());
                    }
                });
                $('#total_expense').val(expense);
                $('#total_income').val(income);
                $('#total').val(income - expense)
            }
        });
    </script>
@endpush