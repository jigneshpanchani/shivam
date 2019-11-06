@extends('layouts.template')

@section('title', 'Partner Account Detail')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-5-6">
            <h4 class="heading_a uk-margin-bottom">{{ ucfirst($result['name']) }}'s Account Detail</h4>
        </div>
        <div class="uk-width-medium-1-6 uk-text-right">
            <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('partner.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
        </div>
    </div>
    <div class="md-card">
        <div class="md-card-content large-padding">
            <form name="staff_info" class="uk-form-stacked" method="post" action="">
                {{ csrf_field() }}
                <div class="uk-grid" data-uk-grid-margin>
                    <div class="uk-width-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h4 class="heading_a">Deposit</h4>
                                <table class="uk-table uk-table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount (₹)</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($deposits) && count($deposits) > 0)
                                        @foreach($deposits as $row)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                                                <td>{{ number_format($row['credit']) }}</td>
                                                <td>
                                                    @foreach($row['details'] as $detail)
                                                        @php
                                                            echo $detail['amount'] . (!empty($detail['detail']) ? ' : '.$detail['detail'] : '') .'<br/>';
                                                        @endphp
                                                    @endforeach
                                                    {{ (!empty($row['note'])) ? ('Note : '.$row['note']) : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="3" class="uk-text-center">No record found</td></tr>
                                    @endif
                                    </tbody>
                                    @if(count($deposits) > 0)
                                        <tfoot>
                                        <th>Total (₹)</th>
                                        <th>{{ number_format($deposit_total) }}</th>
                                        <th></th>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-1-2">
                        <div class="md-card">
                            <div class="md-card-content">
                                <h4 class="heading_a">Withdrawal</h4>
                                <table class="uk-table uk-table-hover">
                                    <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Amount (₹)</th>
                                        <th>Details</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @if(isset($withdrawals) && count($withdrawals) > 0)
                                        @foreach($withdrawals as $row)
                                            <tr>
                                                <td>{{ date('d/m/Y', strtotime($row['date'])) }}</td>
                                                <td>{{ number_format($row['debit']) }}</td>
                                                <td>
                                                    @foreach($row['details'] as $detail)
                                                        @php
                                                            echo $detail['amount'] . (!empty($detail['detail']) ? ' : '.$detail['detail'] : '') .'<br/>';
                                                        @endphp
                                                    @endforeach
                                                    {{ (!empty($row['note'])) ? ('Note : '.$row['note']) : '' }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr><td colspan="3" class="uk-text-center">No record found</td></tr>
                                    @endif
                                    </tbody>
                                    @if(count($withdrawals) > 0)
                                        <tfoot>
                                        <th>Total (₹)</th>
                                        <th>{{ number_format($withdrawal_total) }}</th>
                                        <th></th>
                                        </tfoot>
                                    @endif
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="uk-grid">
                    <div class="uk-width-1-1 uk-text-right">
                        <a href="{{ route('partner.index') }}" class="md-btn md-btn-danger">Cancel</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection