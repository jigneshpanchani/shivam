@extends('layouts.template')
@section('title', 'Company Account List')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Company Account List</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('account.create') }}"><i class="uk-icon-plus-circle"></i> Add</a>
        </div>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="dt_colVis_buttons"></div>
            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="25%">Date</th>
                    <th width="25%">Partner Name</th>
                    <th width="20%">Deposit (₹)</th>
                    <th width="20%">Withdrawal (₹)</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                @if(count($accounts) > 0)
                    <tfoot>
                    <th>Page Total<br>(Total)</th>
                    <th></th>
                    <th class="sumD">0</th>
                    <th class="sumW">0</th>
                    <th></th>
                    </tfoot>
                @endif
                <tbody>
                @if(count($accounts) > 0)
                @foreach($accounts as $row)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                        <td>{{ $row['partner']['name'] }}</td>
                        <td>{{ number_format($row['credit']) }}</td>
                        <td>{{ number_format($row['debit']) }}</td>
                        <td>
                            <a href="javascript:void(0);" title="Delete" data-id="{{ $row['id'] }}" class="uk-margin-left deleteRecord"><i class="material-icons md-24">&#xE872;</i></a>
                        </td>
                    </tr>
                @endforeach
                @else
                    <tr><td colspan="6" class="uk-text-center">No record found</td></tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- datatables -->
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables buttons-->
    <script src="{{ asset('bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/custom/datatables/buttons.uikit.js') }}"></script>
{{--    <script src="{{ asset('bower_components/jszip/dist/jszip.min.js') }}"></script>--}}
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.print.js') }}"></script>

    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <!--  datatables functions -->
    <script src="{{ asset('assets/js/pages/plugins_datatables.min.js') }}"></script>

    <script src="{{ asset('assets/js/pages/sum().js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            var table = $('#dt_tableExport').DataTable();
            calculateTotal();
            $('#dt_tableExport').on( 'draw.dt', function () {
                calculateTotal();
            });
            $('body').on('click', '.deleteRecord', function () {
                let rowId = $(this).attr('data-id');
                deleteRecord(rowId);
            });
            function deleteRecord(rowId){
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            url: "account/"+rowId,
                            type: 'DELETE',
                            data: {
                                "id": rowId,
                                "_token": "{{ csrf_token() }}",
                            },
                            success: function (data){
                                Swal.fire({
                                    title: data.title,
                                    text: data.msg,
                                    type: data.status
                                }).then((result) => {
                                    window.location.reload();
                                });
                            }
                        });
                    }
                })
            }
            function calculateTotal() {
                let arr = {'2':'D', '3':'W'};
                $.each(arr, function (key, value){
                    let pageTotal = table.column( key, {'page': 'current'}).data().sum();
                    let total = table.column( key ).data().sum();
                    let display = currencyFormat(pageTotal)+' <br>('+currencyFormat(total)+')';
                    $('.sum'+value).html(display);
                });
            }
            function currencyFormat(total) {
                return total.toString().replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,")
            }
        });
    </script>
@endpush