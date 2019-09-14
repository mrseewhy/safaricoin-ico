@extends('frontend.layouts.app')

@section('content')
    <script>
        window.currencyShort = '{{ env('COIN_NAME_SHORT') }}';
        window.withdrawFee = '{{ env('WITHDRAW_FEE') }}';
    </script>

    <div class="box-static box-bordered p-30">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                Bitcoin &bull; ${{ number_format($bitcoinRate, 2) }}
            </h2>
        </div>
        <div id="btcChart" style="min-height:300px;"></div>
        <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
        <script type="text/javascript">
            google.charts.load('current', {'packages':['corechart']});
            google.charts.setOnLoadCallback(drawChart);

            function drawChart() {
                $.getJSON('https://api.coinbase.com/v2/prices/BTC-USD/historic?period=month', function(response) {
                    var array = $.map(response.data.prices, function(value, index) {
                        return [[
                            new Date(value.time),
                            parseFloat(value.price)
                        ]];
                    });
                    array.reverse();

                    var data = new google.visualization.DataTable();
                    data.addColumn('datetime', 'Date');
                    data.addColumn('number', 'BTC');
                    data.addRows(array);

                    // Set chart options
                    var options = {
                        'width':'100%',
                        'height':300,
                        curveType: 'function',
                        legend: {position: 'none'},
                        hAxis: {
                            format: 'd MMM'
                        },
                        colors: ["#ffb119"]
                    };

                    var chart = new google.visualization.AreaChart(document.getElementById('btcChart'));
                    chart.draw(data, options);
                });
            }
        </script>

    </div>

    @if($currentRound && $currentRound->isActive())
    <div class="box-static box-bordered p-30 mt-3">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                ICO round in progress
            </h2>
        </div>
        <div class="text-center">
            <div class="text-danger">
                <countdown deadline="{{ $currentRound->end_date }}"></countdown>
            </div>
            <h2 class="mt-3">{{ $currentRound->coinsLeftInRound() }} {{ env('COIN_NAME_SHORT') }}</h2>
            <div class="progress">
                <div class="progress-bar bg-warning" role="progressbar" style="width:{{ $currentRound->coinsBoughtPercentage() }}%" aria-valuenow="{{ $currentRound->coinsBoughtPercentage() }}" aria-valuemin="0" aria-valuemax="100">
                    {{ $currentRound->coinsBoughtPercentage() }}%
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="d-sm-flex align-items-stretch mt-3">
        <div class="box-static box-bordered p-30 box-h mr-2 mb-2">
            <div class="box-title mb-30">
                <h2 class="fs-20">
                    {{ __("Balances") }}
                </h2>
            </div>
            <div class="row">
                <div class="col-5">
                    <div class="p-3">Bitcoin:</div>
                </div>
                <div class="col-7">
                    <div class="bg-light p-3">{{ number_format($userWallet->balance_btc, 8) }} BTC</div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-5">
                    <div class="p-3">{{ env('COIN_NAME') }}:</div>
                </div>
                <div class="col-7">
                    <div class="bg-info text-white p-3">{{ number_format($userWallet->balance_usd, 2) }} {{ env('COIN_NAME_SHORT') }}</div>
                </div>
            </div>
        </div>

        <div class="box-static box-bordered p-30 box-h ml-2 mb-2">
            <div class="box-title mb-30">
                <h2 class="fs-20">
                    {{ __("Buy / Sell") }}
                </h2>
            </div>
            <form method="post" action="{{ route('frontend.user.deposit') }}">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col-sm-6">
                        <div class="p-2"><input name="deposit_amount" class="form-control" placeholder="0.001" type="number" min="0.00000001" step="any" required></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-2">
                            <button type="submit" class="btn btn-light btn-block">
                                <i class="fa fa-cloud-download" aria-hidden="true"></i> Deposit Bitcoin
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            @if($currentRound && $currentRound->isActive())
            <form onsubmit="buyC();return false;">
                {{ csrf_field() }}
                <div class="row mt-2">
                    <div class="col-sm-6">
                        <div class="p-2"><input id="cInput" class="form-control" placeholder="100" type="number" min="1" max="{{ number_format(floor($userWallet->balance_btc * $localRate)) }}" required></div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-2">
                            <button type="submit" class="btn btn-info btn-block" {{ floor($userWallet->balance_btc * $localRate) < 0.01 ? 'disabled' : '' }}>
                                </i> Purchase {{ env('COIN_NAME') }}
                            </button>
                        </div>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">
                            Exchange Rate: {{ number_format(1/$localRate, 8) }} BTC per 1 {{ env('COIN_NAME_SHORT') }}
                        </small>
                    </div>
                    <div class="col-12">
                        <small class="text-muted">With current rate you can purchase up to {{ number_format(floor($userWallet->balance_btc * $localRate)) }} {{ env('COIN_NAME') }}</small>
                    </div>
                </div>
            </form>
            @endif
        </div>
    </div>

    @if(env('REFERRALS_ENABLED'))
    <div class="box-static box-bordered p-30 mt-2 mb-3">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                Referral link
            </h2>
        </div>
        <h5 class="text-secondary">{{ route('frontend.auth.register') }}?ref={{ $refLink }}</h5>
    </div>
    @endif

    <div class="modal" tabindex="-1" role="dialog" id="cModal">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Purchase {{ env('COIN_NAME') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Are you sure you want to buy <strong><span id="cAmount"></span></strong> {{ env('COIN_NAME') }}
                        (<span id="bAmount"></span> BTC)?
                    </p>
                </div>
                <div class="modal-footer">
                    <button id="submitBuy" type="button" class="btn btn-primary" onclick="submitBuyC()">Yes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    @if(env('WITHDRAW_ENABLED'))
    <withdraw max="{{ $userWallet->balance_btc }}"></withdraw>
    @endif

    <transactions ref="tran"></transactions>

@endsection

@section('scripts')
    <script>
        var rate = {{ $localRate }};
        function buyC() {
            var amount = $('#cInput').val();
            var amountBtc = (amount / rate).toFixed(8);
            if (!amount) {
                return false;
            }
            $('#cAmount').html(amount);
            $('#bAmount').html(amountBtc);
            $('#cModal').modal('show');
            return false;
        }
        function submitBuyC() {
            var amount = $('#cInput').val();
            var origHtml = $("#submitBuy").html();
            $("#submitBuy").html('<i class="fa fa-circle-o-notch fa-spin fa-fw"></i>');
            $("#submitBuy").prop('disabled', true);
            $.post('/api/buyCoins', {
                amount: amount,
                _token: "{{ csrf_token() }}"
            }, function () {
                document.location.reload();
            }).fail(function(response){
                if (response.responseJSON.message) {
                    alert(response.responseJSON.message);
                    $("#submitBuy").html(origHtml);
                    $("#submitBuy").prop('disabled', false);
                    $('#cModal').modal('hide');
                }
            });
        }
    </script>
@endsection