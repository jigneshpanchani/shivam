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
                            <div class="uk-width-medium-2-3">
                                <div class="parsley-row">
                                    <span class="icheck-inline">
                                        <input type="radio" name="amount_type" value="C" id="amount_type_1" data-md-icheck />
                                        <label for="amount_type_1" class="inline-label">Deposit</label>
                                    </span>
                                    <span class="icheck-inline">
                                        <input type="radio" name="amount_type" value="D" id="amount_type_2" data-md-icheck checked />
                                        <label for="amount_type_2" class="inline-label">Withdrawal</label>
                                    </span>
                                </div>
                                <div class="md-card">
                                    <div class="md-card-content">
                                        <div class="uk-grid" data-uk-grid-margin>
                                            <div class="uk-width-medium-1-1">
                                                <div data-dynamic-fields="field_template_a"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="uk-width-medium-1-3">
                                <div class="parsley-row">
                                    <label for="note">Extra Note</label>
                                    <textarea class="md-input" name="note" cols="10" rows="4">{{old('note')}}</textarea>
                                </div>
                            </div>
                        </div>
                        <div class="uk-grid" data-uk-grid-margin>
                            <div class="uk-width-medium-1-3">
                                <div class="uk-input-group">
                                    <span class="uk-input-group-addon">Total Amount (₹)</span>
                                    <input type="text" name="total_amount" id="total_amount" value="{{ old('total_amount') ? old('total_amount') : 0 }}" class="md-input uk-text-right" readonly/>
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
                                        <select class="bus_list" name="bid[]">
                                            <option value="">Select Bus</option>
                                        </select>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="uk-input-group">
                                            <label>Amount (₹)<span class="req"> * </span></label>
                                            <input type="number" name="amount[]" class="md-input amount" min="0" />
                                        </div>
                                    </div>
                                    <div class="uk-width-1-3">
                                        <div class="parsley-row">
                                            <label>Detail</label>
                                            <input type="text" name="detail[]" class="md-input detail" value="" />
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
                totalAmount();
            });
            $(document).on('keyup click', '.amount', function () {
                totalAmount();
            });
            $('body').on('change', '#partner_id', function () {
                let partnerId = $('option:selected', this).val();
                getPartnerData(partnerId);
            });

            $(document).on('click', '.plusBtn', function () {
                $('#partner_id').trigger('change');
            });

            function totalAmount() {
                let amount = 0;
                $(document).find('.amount').each(function (key, value){
                    if(parseInt($(this).val()) > 0){
                        amount = amount + parseInt($(this).val());
                    }
                });
                $('#total_amount').val(amount);
            }
            function getPartnerData(partnerId) {
                $.ajax({
                    url: "<?= route('partner-buses'); ?>",
                    type: 'POST',
                    data: { "partnerId": partnerId, "_token": "{{ csrf_token() }}" },
                    success: function (data){
                        let optionHtml = '<option value="">Select Bus</option>';
                        $.each(data.buses, function(key, val){
                            optionHtml += '<option value="'+key+'">'+val+'</option>';
                        });
                        $('.bus_list').html(optionHtml);
                        /*let options = [];
                        $.each(data.buses, function(key, val){
                            options.push({id: key, title: val})
                        });
                        $('.bus_list').selectize({
                            valueField: 'id',
                            labelField: 'title',
                            searchField: 'title',
                            options: options,
                            create: false
                        });*/
                    }
                });
            }

        });
    </script>
@endpush
