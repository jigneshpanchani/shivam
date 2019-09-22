@extends('layouts.template')
@section('title', 'Staff List')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">Staff List</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('staff.create') }}"><i class="uk-icon-plus-circle"></i> Add</a>
        </div>
    </div>
    <div class="md-card uk-margin-medium-bottom">
        <div class="md-card-content">
            <div class="dt_colVis_buttons"></div>
            <table id="dt_tableExport" class="uk-table" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th width="20%">Name</th>
                    <th width="15%">Position</th>
                    <th width="15%">Salary (₹)</th>
                    <th width="15%">Contact No</th>
                    <th width="25%">Address</th>
                    <th width="10%">Action</th>
                </tr>
                </thead>
                <tbody>
                @if(count($staff) > 0)
                @foreach($staff as $row)
                    <tr>
                        <td>{{ $row['name'] }}</td>
                        <td>{{ $row['department'] }}</td>
                        <td>{{ $row['salary'] }}</td>
                        <td>{{ $row['contact_no'] }}</td>
                        <td>{{ $row['address'] }}</td>
                        <td>
                            <a href="javascript:void(0);" title="Preview" data-id="{{ $row['id'] }}" data-info="{{ json_encode($row) }}" class="uk-margin-left viewRecord" data-uk-modal="{target:'#modal_overflow'}"><i class="material-icons md-24">&#xE8F4;</i></a>
                            <a href="{{ route('staff.edit', $row['id']) }}" class="uk-margin-left" title="Edit"><i class="uk-icon-edit uk-icon-small"></i></a>
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

    <button class="md-btn" id="modal_btn" data-uk-modal="{target:'#modal_overflow'}" style="display: none;"></button>
    <div id="modal_overflow" class="uk-modal">
        <div class="uk-modal-dialog">
            <button type="button" class="uk-modal-close uk-close"></button>
            <h2 class="heading_a">Staff detail </h2>
            <hr>
            <p><strong>Name : </strong><span id="pre_name"></span></p>
            <p><strong>Position : </strong><span id="pre_department"></span></p>
            <p><strong>Contact No : </strong><span id="pre_contact_no"></span></p>
            <p><strong>Aadhar Card No : </strong><span id="pre_aadhar_card_no"></span></p>
            <p><strong>Salary (₹) : </strong><span id="pre_salary"></span></p>
            <p><strong>Address : </strong><span id="pre_address"></span></p>
            <p><strong>Extra Notes : </strong><span id="pre_note"></span></p>
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
                            url: "staff/"+rowId,
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