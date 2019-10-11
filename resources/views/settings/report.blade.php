@extends('layouts.template')

@section('title', $title)

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">{{ $title }}</h4>
                </div>
                <div class="uk-width-medium-1-6 uk-text-right">
                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('report') }}"><i class="uk-icon-arrow-circle-left"></i> Filter</a>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="dt_colVis_buttons"></div>
                    <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">

                        @if(isset($expenses))
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bus</th>
                                <th>Expense (₹)</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($expenses) > 0)
                                @foreach($expenses as $row)
                                    @php
                                        $detail = array();
                                        foreach($row['expenses'] as $exp){
                                            if(($expId != 'all') && ($exp['expense_id'] != $expId)){
                                                continue;
                                            }
                                            $detail[] = $expenseArr[$exp['expense_id']] .' : '. number_format($exp['amount']);
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                        <td>{{ $row['bus']['bus_number'] }}</td>
                                        <td>{{ number_format($row['expense']) }}</td>
                                        <td>{{ implode(', ', $detail) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="uk-text-center">No record found</td></tr>
                            @endif
                            </tbody>
                        @endif

                        @if(isset($incomes))
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bus</th>
                                <th>Income (₹)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($incomes) > 0)
                                @foreach($incomes as $row)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                        <td>{{ $row['bus']['bus_number'] }}</td>
                                        <td>{{ number_format($row['income']) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="3" class="uk-text-center">No record found</td></tr>
                            @endif
                            </tbody>
                        @endif

                        @if(isset($salaries))
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Type</th>
                                <th>Amount (₹)</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(count($salaries) > 0)
                                @foreach($salaries as $row)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                                        <td>{{ $row['staff']['name'] }}</td>
                                        <td>{{ $row['staff']['department'] }}</td>
                                        <td>{{ ($row['income_type'] == 'S') ? 'Salary' : 'Withdrawal' }}</td>
                                        <td>{{ number_format($row['amount']) }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="uk-text-center">No record found</td></tr>
                            @endif
                            </tbody>
                        @endif

                        @if(isset($works))
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bus</th>
                                <th>Income (₹)</th>
                                <th>Expense (₹)</th>
                                <th>Total (₹)</th>
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
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="5" class="uk-text-center">No record found</td></tr>
                            @endif
                            </tbody>
                        @endif

                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <!-- datatables -->
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables buttons-->
    <script src="{{ asset('bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/custom/datatables/buttons.uikit.js') }}"></script>
    <script src="{{ asset('bower_components/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.print.js') }}"></script>

    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <!--  datatables functions -->
    <script src="{{ asset('assets/js/pages/plugins_datatables.min.js') }}"></script>
@endpush
