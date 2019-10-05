@extends('layouts.template')

@section('title', 'Staff Income Detail')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">{{ ucfirst($result['name']) }} Income Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('staff.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_info" class="uk-form-stacked" method="post" action="">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-4">
                        <div class="parsley-row">
                            <label for="name">Department</label>
                            <input type="text" name="department" value="{{ $result['department'] }}" readonly class="md-input"/>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-4">
                        <div class="uk-input-group">
                            <label>Opening Balance(₹)</label>
                            <input type="number" name="balance" value="{{ $result['balance'] }}" class="md-input" readonly />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <div class="uk-form-row parsley-row">
                            <label for="contact_no">Salary (₹)</label>
                            <input type="number" name="salary" value="{{ $totalSal }}" class="md-input" readonly />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <div class="parsley-row">
                            <label for="name">Withdrawal (₹)</label>
                            <input type="number" name="name" value="{{ $totalWdl }}" class="md-input" readonly />
                        </div>
                    </div>
                    <div class="uk-width-medium-1-6">
                        <div class="parsley-row">
                            <label for="name">Total (₹)</label>
                            <input type="number" name="total" value="{{ $total }}" class="md-input" readonly />
                        </div>
                    </div>
                </div>
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h3 class="heading_a">Salary</h3>
                                <table class="uk-table uk-table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount (₹)</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($salaries) > 0)
                                        @foreach($salaries as $row)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                                                <td>{{ number_format($row['amount']) }}</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="3" class="uk-text-center">No record found</td></tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-medium-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h4 class="heading_a">Withdrawal</h4>
                                <table class="uk-table uk-table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount (₹)</th>
                                        <th>Detail</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(count($withdrawal) > 0)
                                        @foreach($withdrawal as $row)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                                                <td>{{ number_format($row['amount']) }}</td>
                                                <td>-</td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="3" class="uk-text-center">No record found</td></tr>
                                    @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <a href="{{ route('staff.index') }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection