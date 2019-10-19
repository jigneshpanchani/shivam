@extends('layouts.template')

@section('title', 'Add Partner Work')

@section('content')
    <div class="uk-grid" data-uk-grid-margin>
        <div class="uk-width-medium">
            <div class="uk-grid" data-uk-grid-margin>
                <div class="uk-width-medium-5-6">
                    <h4 class="heading_a uk-margin-bottom">Add Partner Work</h4>
                </div>
                <div class="uk-width-medium-1-6 uk-text-right">
                    <a class="md-btn md-btn-primary md-btn-small md-btn-wave-light md-btn-icon" href="{{ route('account.index') }}"><i class="uk-icon-arrow-circle-left"></i> List</a>
                </div>
            </div>
            <div class="md-card">
                <div class="md-card-content">
                    <form id="form_validation" class="uk-form-stacked" method="post" action="{{ route('account.store') }}" data-parsley-validate>
                        {{ csrf_field() }}
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <select id="partner_id" name="partner_id" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Partner" required>
                                        <option value="">Select Partner</option>
                                        @foreach($partners as $pid=>$pname)
                                            <option value="{{ $pid }}" {{ ($pid==old('partner_id'))?'selected':'' }}>{{ $pname }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-2"></div>
                            <div class="uk-width-medium-1-4">
                                <div class="parsley-row">
                                    <label for="date">Reporting Date</label>
                                    <input type="text" name="date" id="date" class="md-input" value="{{ date('d-m-Y') }}"
                                           data-parsley-americandate
                                           data-parsley-americandate-message="This value should be a valid date (DD-MM-YYYY)"
                                           data-uk-datepicker="{format:'DD-MM-YYYY'}" required/>
                                </div>
                            </div>
                        </div>
                        <br><br>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-2">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <h3 class="heading_a">Add to company</h3>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <div data-dynamic-fields="field_template_a"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-2">
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <h3 class="heading_a">Withdrawal</h3>
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <div data-dynamic-fields="field_template_b"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-3">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon">Total Add Amount (₹)</span>
                                    <input type="text" name="total_add" id="total_add" value="{{ old('total_add') ? old('total_add') : 0 }}" class="md-input uk-text-right" readonly/>
                                </div>
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon">Total Withdrawal (₹)</span>
                                    <input type="text" name="total_withdrawal" id="total_withdrawal" value="{{ old('total_withdrawal') ? old('total_withdrawal') : 0 }}" class="md-input uk-text-right" readonly/>
                                </div>
                            </div>
                            <div class="uk-width-medium-2-3">
                                <div class="parsley-row">
                                    <label for="note">Extra Note</label>
                                    <textarea class="md-input" name="note" cols="10" rows="3">{{old('note')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid uk-margin-medium-top">
                            <div class="uk-width-1-1 uk-text-right">
                                <button type="submit" class="md-btn md-btn-primary">Save</button>
                                <a href="{{ route('account.index') }}" class="md-btn md-btn-danger">Cancel</a>
                            </div>
                        </div>
                    </form>
                    <script id="field_template_a" type="text/x-handlebars-template">
                        <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                            <div class="uk-width-9-10">
                                <div class="uk-grid">
                                    <div class="uk-width-1-3">
                                        <select class="add_bid" name="add_bid[]" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Bus">
                                            <option value="">Select Bus</option>
                                            @foreach($buses as $bid=>$bus)
                                                <option value="{{ $bid }}" {{ ($bid==old('add_bid'))?'selected':'' }}>{{ str_replace(' - ', '.', $bus) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="uk-input-group">
                                            <label>Amount (₹)<span class="req"> * </span></label>
                                            <input type="number" name="add_amount[]" class="md-input add_amount" min="0" />
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="parsley-row">
                                            <label>Detail</label>
                                            <input type="text" name="add_detail[]" class="md-input add_detail" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-10 uk-text-center">
                                <div class="uk-vertical-align uk-height-1-1">
                                    <div class="uk-vertical-align-middle">
                                        <a href="forms_dynamic.html#" class="btnSectionClone"><i class="material-icons md-36">&#xE146;</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </script>
                    <script id="field_template_b" type="text/x-handlebars-template">
                        <div class="uk-grid uk-grid-medium form_section" data-uk-grid-match>
                            <div class="uk-width-9-10">
                                <div class="uk-grid">
                                    <div class="uk-width-1-3">
                                        <select class="wd_bid" name="wd_bid[]" data-md-selectize data-md-selectize-bottom data-uk-tooltip="{pos:'top'}" title="Select Expense">
                                            <option value="">Select Bus</option>
                                            @foreach($buses as $bid=>$bus)
                                                <option value="{{ $bid }}" {{ ($bid==old('wd_bid'))?'selected':'' }}>{{ str_replace(' - ', ' ', $bus) }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="uk-input-group">
                                            <label>Amount (₹)<span class="req"> * </span></label>
                                            <input type="number" name="wd_amount[]" class="md-input wd_amount" min="0" />
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="parsley-row">
                                            <label>Detail</label>
                                            <input type="text" name="wd_detail[]" class="md-input wd_detail" value="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-1-10 uk-text-center">
                                <div class="uk-vertical-align uk-height-1-1">
                                    <div class="uk-vertical-align-middle">
                                        <a href="forms_dynamic.html#" class="btnSectionClone plusBtn"><i class="material-icons md-36">&#xE146;</i></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </script>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('bower_components/handlebars/handlebars.min.js') }}"></script>
    <script src="{{ asset('js/pages/form_validation.js') }}"></script>
    <script type="text/javascript">
        $(document).ready( function () {

            $(document).on('click', '.btnSectionRemove', function () {
                totalIncome();
                totalExpense();
            });
            $(document).on('keyup', '.add_amount', function () {
                totalIncome();
            });
            $(document).on('keyup', '.wd_amount', function () {
                totalExpense();
            });

            function totalIncome() {
                let income = 0;
                $(document).find('.add_amount').each(function (key, value){
                    if(parseInt($(this).val()) > 0){
                        income = income + parseInt($(this).val());
                    }
                });
                $('#total_add').val(income);
                totalAmount();
            }
            function totalExpense() {
                let expense = 0;
                $(document).find('.wd_amount').each(function (key, value){
                    if(parseInt($(this).val()) > 0) {
                        expense = expense + parseInt($(this).val());
                    }
                });
                $('#total_withdrawal').val(expense);
                totalAmount();
            }
            function totalAmount() {
               let income = $('#total_add').val();
               let expense = $('#total_withdrawal').val();
               let total = parseInt(income) - parseInt(expense);
               $('#total').val(total)
            }

        });
    </script>
    <script type="text/javascript">
        $(document).ready( function () {


            $('body').on('change', '#partner_id', function () {
                let pId = $('option:selected', this).val();
                //getPartnerData(pId);
            });

            function appendArr() {
                //var member = '<?php json_encode($staff); ?>';
                $('select').selectize({
                    //maxItems: null,
                    valueField: 'id',
                    labelField: 'title',
                    searchField: 'title',
                    options: [{
                        id: 1,
                        title: 'case1'
                    }, {
                        id: 2,
                        title: 'case2'
                    }],
                    create: false
                });
            }
            function getStaffData(pId) {
                $.ajax({
                    url: "<?= route('partner-bus'); ?>",
                    type: 'POST',
                    data: { "partnerId": pId, "_token": "{{ csrf_token() }}" },
                    success: function (data){
                        appendArr(data.bus);
                    }
                });
            }
        });
    </script>
@endpush
