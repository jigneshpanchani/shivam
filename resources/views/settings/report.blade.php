@extends('layouts.template')

@section('title', 'Report')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">Report</h4>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <form id="form_validation" class="uk-form-stacked" method="post" action="{{ route('report-generate') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-1">
                                <div class="parsley-row">
                                    <label>Report By : </label>
                                    @foreach($typeArr as $key => $val)
                                    <span class="icheck-inline">
                                        <input type="radio" name="report_type" value="{{ $key }}" id="report_type_{{$key}}" data-md-icheck required />
                                        <label for="report_type_{{$key}}" class="inline-label">{{ ucwords($val) }}</label>
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="uk_dp_start">Start Date</label>
                                    <input type="text" name="start_date" id="uk_dp_start" class="md-input" value="{{ old('start_date') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="uk_dp_end">End Date</label>
                                    <input type="text" name="end_date" id="uk_dp_end" class="md-input" value="{{ old('end_date') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" autocomplete="off" required/>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row list_view list_E">
                                    <select id="expense_id" name="expense_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Expense Type" >
                                        <option value="">Select Expense</option>
                                        <option value="0">All Expenses</option>
                                        @foreach($expenseArr as $eid => $type)
                                            <option value="{{ $eid }}" {{ ($eid==old('expense_id'))?'selected':'' }}>{{ ucwords($type) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="parsley-row list_view list_S">
                                    <select id="staff_id" name="staff_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Staff Member" >
                                        <option value="">Select Member</option>
                                        <option value="0">All Members</option>
                                        @foreach($staffArr as $sid => $name)
                                            <option value="{{ $sid }}" {{ ($sid==old('staff_id'))?'selected':'' }}>{{ ucwords($name) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="parsley-row list_view list_W">
                                    <select id="bus_id" name="bus_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Bus" >
                                        <option value="">Select Bus</option>
                                        <option value="0">All Buses</option>
                                        @foreach($busArr as $bid => $number)
                                            <option value="{{ $bid }}" {{ ($bid==old('bus_id'))?'selected':'' }}>{{ $number }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid uk-margin-medium-top">
                            <div class="uk-width-1-1 uk-text-right">
                                <button type="submit" class="md-btn md-btn-primary">Go</button>
                                <a href="{{ route('report') }}" class="md-btn md-btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th width="20%">Date</th>
                            <th width="25%">Bus</th>
                            <th width="15%">Income(₹)</th>
                            <th width="15%">Expense(₹)</th>
                            <th width="15%">Total(₹)</th>
                            <th width="10%">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @if(count($works) > 0)
                            @foreach($works as $row)
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                    <td>{{ $row['bus']['bus_number'] }}</td>
                                    <td>{{ number_format($row['income']) }}</td>
                                    <td>{{ number_format($row['expense']) }}</td>
                                    <td>{{ number_format($row['income'] - $row['expense']) }}</td>
                                    <td>
                                        <a href="{{ route('work.show', $row['id']) }}" class="uk-margin-left" title="Preview"><i class="uk-icon-eye uk-icon-small"></i></a>
                                        <a href="{{ route('work.edit', $row['id']) }}" class="uk-margin-left" title="Edit"><i class="uk-icon-edit uk-icon-small"></i></a>
                                        <a href="javascript:void(0);" title="Delete" data-id="{{ $row['id'] }}" class="uk-margin-left deleteRecord"><i class="material-icons md-24">&#xE872;</i></a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr><td colspan="5" class="uk-text-center">No record found</td></tr>
                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
    <script type="text/javascript">
        $(document).ready( function () {
            $('.list_view').hide();
            $(document).on('ifChecked', 'input[type=radio]', function () {
                $('.list_view').hide();
                $('.list_'+$(this).val()).show();
            });
        });
    </script>
@endpush
