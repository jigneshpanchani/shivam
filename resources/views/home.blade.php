@extends('layouts.template')
@section('title', 'Home')

@section('content')

    <!-- notifications -->
    @include('layouts.template.notifications')
    <!-- notifications end -->

    <!-- statistics (small charts) -->
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium-1-4">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                    <span class="uk-text-muted uk-text-small">Bus</span>
                    <h2 class="uk-margin-remove"><span class="countUpMe">{{ $bus }}</span></h2>
                </div>
            </div>
        </div>
        <div class="uk-width-medium-1-2">
            <div class="md-card">
                <div class="md-card-content">
                    {{--<span class="uk-text-muted uk-text-small">&nbsp;</span>--}}
                    <h2 class="uk-text-center uk-text-danger">શ્રી ૧I</h2>
                </div>
            </div>
        </div>
        <div class="uk-width-medium-1-4">
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_orders peity_data">64/100</span></div>
                    <span class="uk-text-muted uk-text-small">Staff Members</span>
                    <h2 class="uk-margin-remove"><span class="countUpMe">{{ $staff }}</span></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">2,5,7,3,9,7,3</span></div>
                    <span class="uk-text-muted uk-text-small">Today's Income</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $income }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">5,3,9,6,5,9,7</span></div>
                    <span class="uk-text-muted uk-text-small">Last Day Income</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $prev_income }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">4,6,4,9,5,3,8</span></div>
                    <span class="uk-text-muted uk-text-small">Last Week Income</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $last_week_income }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_visitors peity_data">6,4,9,4,3,7,2</span></div>
                    <span class="uk-text-muted uk-text-small">Last Month Income</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $last_month_income }}</span></h2>
                </div>
            </div>
        </div>
    </div>
    <div class="uk-grid uk-grid-width-large-1-4 uk-grid-width-medium-1-2 uk-grid-medium uk-sortable sortable-handler hierarchical_show" data-uk-sortable data-uk-grid-margin>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">3,5,2,7,8,6,4,3,8,2</span></div>
                    <span class="uk-text-muted uk-text-small">Today's Expense</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $expense }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,9,6,5,9,7,3,5,2</span></div>
                    <span class="uk-text-muted uk-text-small">Last Day Expense</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $prev_expense }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,9,7,3,5,2,3,8,2,6</span></div>
                    <span class="uk-text-muted uk-text-small">Last Week Expense</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $last_week_expense }}</span></h2>
                </div>
            </div>
        </div>
        <div>
            <div class="md-card">
                <div class="md-card-content">
                    <div class="uk-float-right uk-margin-top uk-margin-small-right"><span class="peity_sale peity_data">5,3,3,5,2,9,6,5,9,7</span></div>
                    <span class="uk-text-muted uk-text-small">Last Month Expense</span>
                    <h2 class="uk-margin-remove">₹<span class="countUpMe">{{ $last_month_expense }}</span></h2>
                </div>
            </div>
        </div>
    </div>

    <div class="uk-grid uk-grid-width-medium-1-4" data-uk-grid="{gutter:24}">
        @foreach($buses as $bus)
        <div>
            <div class="md-card">   {{--md-card-collapsed--}}
                <div class="md-card-toolbar">
                    <div class="md-card-toolbar-actions">
                        <i class="md-icon material-icons md-card-fullscreen-activate">&#xE5D0;</i>
                        <i class="md-icon material-icons md-card-toggle">&#xE316;</i>
                        <i class="md-icon material-icons md-card-close">&#xE14C;</i>
                    </div>
                    <h3 class="md-card-toolbar-heading-text uk-text-primary">
                        {{ trim(str_replace(' - ', ' ', substr($bus->bus_number, -9))) }}
                    </h3>
                </div>
                <div class="md-card-content">
                    <table class="uk-table uk-table-hover">
                        <tbody>
                            <tr>
                                <th class="uk-text-primary" colspan="2">{{ $bus->bus_number }}</th>
                            </tr>
                            <tr>
                                <td>Income</td>
                                <td>₹{{ number_format($bus->income) }}</td>
                            </tr>
                            <tr>
                                <td>Expense</td>
                                <td>₹{{ number_format($bus->expense) }}</td>
                            </tr>
                            <tr>
                                <td>Profit</td>
                                <td>₹{{ number_format($bus->total) }}</td>
                            </tr>
                            <tr>
                                <td>Closed Balance</td>
                                <td>₹{{ number_format($bus->silak) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endforeach
    </div>

@endsection

@push('scripts')

    <!-- chartist (charts) -->
    <script src="{{ asset('bower_components/chartist/dist/chartist.min.js') }}"></script>
    <!-- peity (small charts) -->
    <script src="{{ asset('bower_components/peity/jquery.peity.min.js') }}"></script>
    <!-- easy-pie-chart (circular statistics) -->
    <script src="{{ asset('bower_components/jquery.easy-pie-chart/dist/jquery.easypiechart.min.js') }}"></script>
    <!-- countUp -->
    <script src="{{ asset('bower_components/countUp.js/dist/countUp.min.js') }}"></script>
    <!--  dashbord functions -->
    <script src="{{ asset('assets/js/pages/dashboard.min.js') }}"></script>

@endpush