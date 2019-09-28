@extends('layouts.template')
@section('title', 'Daily Work List')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Daily Work List</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('work.create') }}"><i class="uk-icon-plus-circle"></i> Add</a>
        </div>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="dt_colVis_buttons"></div>
            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="20%">Date</th>
                    <th width="30%">Bus</th>
                    <th width="20%">Income(₹)</th>
                    <th width="20%">Expense(₹)</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($works) > 0)
                @foreach($works as $row)
                    <tr>
                        <td>{{ date('d/m/Y', strtotime($row['work_date'])) }}</td>
                        <td>{{ $row['bus']['bus_number'] }}</td>
                        <td>{{ $row['income'] }}</td>
                        <td>{{ $row['expense'] }}</td>
                        <td>
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

    <script type="text/javascript">
        $(document).ready(function () {
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
                            url: "work/"+rowId,
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
        });
    </script>
@endpush