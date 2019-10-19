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
                                <th>Total (₹)</th>
                            </tr>
                            </thead>
                            @if(count($expenses) > 0)
                            <tfoot>
                            <tr>
                                <th>Page Total<br>(Total)</th>
                                <th></th>
                                <th class="sumE">0</th>
                                <th></th>
                                <th class="sumT">0</th>
                            </tr>
                            </tfoot>
                            @endif
                            <tbody>
                            @if(count($expenses) > 0)
                            @foreach($expenses as $row)
                                @php
                                    $totalExp = 0;
                                    $detail = array();
                                    foreach($row['expenses'] as $exp){
                                        if(($expId != 'all') && ($exp['expense_id'] != $expId)){
                                            continue;
                                        }
                                        $detail[] = $expenseArr[$exp['expense_id']] .': '. $exp['amount'];
                                        $totalExp = $totalExp + $exp['amount'];
                                    }
                                @endphp
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                    <td>{{ $row['bus']['bus_number'] }}</td>
                                    <td>{{ number_format($row['expense']) }}</td>
                                    <td>{{ implode(', ', $detail) }}</td>
                                    <td>{{ number_format($totalExp) }}</td>
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
                            @if(count($incomes) > 0)
                            <tfoot>
                            <tr>
                                <th>Page Total<br>(Total)</th>
                                <th></th>
                                <th class="sumI">0</th>
                            </tr>
                            </tfoot>
                            @endif
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
                                @if(count($salaries) > 0)
                                    <tfoot>
                                    <tr>
                                        <th>Page Total<br>(Total)</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="sumS">0</th>
                                    </tr>
                                    </tfoot>
                                @endif
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

                        @if(isset($works))`
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bus</th>
                                <th>Income (₹)</th>
                                <th>Expense (₹)</th>
                                <th>Total (₹)</th>
                            </tr>
                            </thead>
                            @if(count($works) > 0)
                                <tfoot>
                                <tr>
                                    <th>Page Total<br>(Total)</th>
                                    <th></th>
                                    <th class="sumI">0</th>
                                    <th class="sumE">0</th>
                                    <th class="sumT">0</th>
                                </tr>
                                </tfoot>
                            @endif
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

    <script src="{{ asset('assets/js/pages/sum().js') }}"></script>

    <script type="text/javascript">
        $(document).ready( function () {
            var table = $('#dt_tableExport').DataTable();
            calculateTotal();
            $('#dt_tableExport').on( 'draw.dt', function () {
                calculateTotal();
            });

            function calculateTotal() {
                $.each(getArr(), function (key, value){
                    let pageTotal = table.column( key, {'page': 'current'}).data().sum();
                    let total = table.column( key ).data().sum();
                    let display = currencyFormat(pageTotal)+' <br>('+currencyFormat(total)+')';
                    $('.sum'+value).html(display);
                });
            }
            function currencyFormat(total) {
                return total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
            }
            function getArr() {
                let type = '<?= $type; ?>';
                let arr = [];
                if(type == 'E'){
                    arr = { '2':'E', '4':'T' };
                }else if(type == 'I'){
                    arr = { '2':'I' };
                }else if(type == 'S'){
                    arr = { '4':'S' };
                }else{
                    arr = { '2':'E', '3':'I', '4':'T' };
                }
                return arr;
            }
        });
    </script>
@endpush
