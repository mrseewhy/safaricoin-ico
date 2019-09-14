@extends ('backend.layouts.app')

@section ('title', __('Transactions'))

@section('content')
    <script>
        window.currencyShort = '{{ env('COIN_NAME_SHORT') }}';
    </script>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ __('Transaction details') }}
                    </h4>
                </div>
            </div><!--row-->

            <div class="row mt-4">
                <div class="col" id="vue-app">
                    <div>
                        <a class="btn btn-primary" href="{{ route('admin.transactions') }}">Back to transactions</a>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">Date</div>
                        <div class="col-sm-8">{{ $transaction->created_at->toDateTimeString() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">Type</div>
                        <div class="col-sm-8">{{ $transaction->getType() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">Currency</div>
                        <div class="col-sm-8">{{ $transaction->transaction_type == 3 ? env('COIN_NAME_SHORT') : 'BTC' }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">Status</div>
                        <div class="col-sm-8">{{ $transaction->getStatus() }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-right">Amount</div>
                        <div class="col-sm-8">{{ $transaction->transaction_amount }}</div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-4 text-right"></div>
                        <div class="col-sm-8">
                            <h5>Data from gourl</h5>
                        </div>
                    </div>
                    @if(!$transaction->cryptoPayment)
                        <div class="alert alert-info">No data yet</div>
                    @else
                        @foreach($transaction->cryptoPayment->getAttributes() as $property => $value)
                            <div class="row">
                                <div class="col-sm-4 text-right">{{ $property }}</div>
                                <div class="col-sm-8">{{ $value }}</div>
                            </div>
                        @endforeach
                    @endif

                </div><!--col-->
            </div><!--row-->

        </div><!--card-body-->
    </div><!--card-->
@endsection
