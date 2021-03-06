@extends('layouts.template')
@section('title', 'Bus List')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Bus List</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('bus.create') }}"><i class="uk-icon-plus-circle"></i> Add</a>
        </div>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="dt_colVis_buttons"></div>
            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="25%">Bus Number</th>
                    <th width="20%">Type</th>
                    <th width="15%">Seat</th>
                    <th width="30%">Root</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($buses) > 0)
                @foreach($buses as $row)
                    <tr>
                        <td>{{ $row['bus_number'] }}</td>
                        <td>{{ $row['type'] }}</td>
                        <td>{{ $row['seat'] }}</td>
                        <td>{{ $row['root'] }}</td>
                        <td>
                            <a href="javascript:void(0);" title="Preview" data-id="{{ $row['id'] }}" data-info="{{ json_encode($row) }}" class="uk-margin-left viewRecord" data-uk-modal="{target:'#modal_overflow'}"><i class="material-icons md-24">&#xE8F4;</i></a>
                            <a href="{{ route('bus.edit', $row['id']) }}" class="uk-margin-left" title="Edit"><i class="uk-icon-edit uk-icon-small"></i></a>
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

    <button class="md-btn" id="modal_btn" data-uk-modal="{target:'#modal_overflow'}" style="display: none;"></button>
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <h2 class="heading_a">Bus detail </h2>
            <hr>
            <p><strong>Bus Number : </strong><span id="pre_bus_number"></span></p>
            <p><strong>Type : </strong><span id="pre_type"></span></p>
            <p><strong>Root : </strong><span id="pre_root"></span></p>
            <p><strong>Total Seat : </strong><span id="pre_seat"></span></p>
            <p><strong>Fuel Capacity (Ltr.) : </strong><span id="pre_fuel_capacity"></span></p>
            <p><strong>Owner Name : </strong><span id="pre_owner_name"></span></p>
            <p><strong>Notes : </strong><span id="pre_note"></span></p>
        </div>
    </div>
@endsection
@push('scripts')
    <!-- datatables -->
    <script src="{{ asset('bower_components/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- datatables buttons-->
    <script src="{{ asset('bower_components/datatables-buttons/js/dataTables.buttons.js') }}"></script>
    <script src="{{ asset('assets/js/custom/datatables/buttons.uikit.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.html5.js') }}"></script>
    <script src="{{ asset('bower_components/datatables-buttons/js/buttons.print.js') }}"></script>

    <!-- datatables custom integration -->
    <script src="{{ asset('assets/js/custom/datatables/datatables.uikit.min.js') }}"></script>

    <!--  datatables functions -->
    <script src="{{ asset('assets/js/pages/plugins_datatables.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            $('body').on('click', '.viewRecord', function () {
                let info = $(this).attr('data-info');
                let res = $.parseJSON(info);
                $.each(res, function (index, value) {
                    $('#pre_'+index).text(value);
                });
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
                            url: "bus/"+rowId,
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