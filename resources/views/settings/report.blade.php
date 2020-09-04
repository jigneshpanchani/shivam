@extends('layouts.template')

@section('title', $title)

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">{{ $title }}</h4>
                </div>
                <div class="uk-width-medium-1-6 uk-text-
                
                
                ">
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
                                <th style="text-align: right;">Total (₹)</th>
                            </tr>
                            </thead>
                            @if(count($expenses) > 0)
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th class="sumE">0</th>
                                <th></th>
                                <th class="sumT" style="text-align: right;">0</th>
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
                                        $detail[] = $expenseArr[$exp['expense_id']] .': '. number_format($exp['amount']) . (!empty($exp['detail']) ? ' ('.$exp['detail'].')' : '');
                                        $totalExp = $totalExp + $exp['amount'];
                                    }
                                @endphp
                                <tr>
                                    <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                    <td>{{ str_replace(' - ', '.', $row['bus']['bus_number']) }}</td>
                                    <td>{{ number_format($row['expense']) }}</td>
                                    <td><?= nl2br(implode('<br> ', $detail)); ?></td>
                                    <td style="text-align: right;">{{ number_format($totalExp) }}</td>
                                </tr>
                            @endforeach
                            @else
                                <tr><td colspan="5" class="uk-text-center">No record found</td></tr>
                            @endif
                            </tbody>
                        @endif

                        @if(isset($incomes))
                            <thead>
                            <tr>
                                <th>Date</th>
                                <th>Bus</th>
                                <th>Income (₹)</th>
                                <th>Detail</th>
                            </tr>
                            </thead>
                            @if(count($incomes) > 0)
                            <tfoot>
                            <tr>
                                <th>Total</th>
                                <th></th>
                                <th class="sumI">0</th>
                                <th></th>
                            </tr>
                            </tfoot>
                            @endif
                            <tbody>
                            @if(count($incomes) > 0)
                                @foreach($incomes as $row)
                                    @php
                                        $incDetail = array();
                                        foreach($row['incomes'] as $inc){
                                            $incDetail[] = number_format($inc['amount']) . (!empty($inc['detail']) ? ' ('.$inc['detail'].')' : '');
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                        <td>{{ str_replace(' - ', '.', $row['bus']['bus_number']) }}</td>
                                        <td>{{ number_format($row['income']) }}</td>
                                        <td><?= nl2br(implode('<br> ', $incDetail)); ?></td>
                                    </tr>
                                @endforeach
                            @else
                                <tr><td colspan="4" class="uk-text-center">No record found</td></tr>
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
                                <th style="text-align: right;">Amount (₹)</th>
                            </tr>
                            </thead>
                                @if(count($salaries) > 0)
                                    <tfoot>
                                    <tr>
                                        <th>Total</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th class="sumS" style="text-align: right;">0</th>
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
                                        <td style="text-align: right;">{{ number_format($row['amount']) }}</td>
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
                                <th style="text-align: right;">Income (₹)</th>
                                <th style="text-align: right;">Expense (₹)</th>
                                <th style="text-align: right;">Total (₹)</th>
                            </tr>
                            </thead>
                            @if(count($works) > 0)
                                <tfoot>
                                <tr>
                                    <th>Total</th>
                                    <th></th>
                                    <th class="sumI" style="text-align: right;">0</th>
                                    <th class="sumE" style="text-align: right;">0</th>
                                    <th class="sumT" style="text-align: right;">0</th>
                                </tr>
                                </tfoot>
                            @endif
                            <tbody>
                            @if(count($works) > 0)
                                @foreach($works as $row)
                                    <tr>
                                        <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                                        <td>{{ str_replace(' - ', '.', $row['bus']['bus_number']) }}</td>
                                        <td style="text-align: right;">{{ number_format($row['income']) }}</td>
                                        <td style="text-align: right;">{{ number_format($row['expense']) }}</td>
                                        <td style="text-align: right;">{{ number_format($row['income'] - $row['expense']) }}</td>
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
                    //let pageTotal = table.column( key, {'page': 'current'}).data().sum();
                    let total = table.column( key ).data().sum();
                    //let display = currencyFormat(pageTotal)+' <br>('+currencyFormat(total)+')';
                    let display = currencyFormat(total);
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
                    arr = { '2':'I', '3':'E', '4':'T' };
                }
                return arr;
            }
        });
    </script>
@endpush
