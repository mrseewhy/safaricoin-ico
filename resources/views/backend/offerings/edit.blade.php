@extends ('backend.layouts.app')

@section ('title', $id ? 'Edit round' : 'Create new round')

@section('content')
<form method="post" action="{{ route('admin.offerings.edit', $offering->id) }}" class="form-horizontal">
    {{ csrf_field() }}
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-5">
                    <h4 class="card-title mb-0">
                        {{ $id ? 'Edit round' : 'Create new round' }}
                    </h4>
                </div>
            </div>

            <hr />

            <div class="row mt-4 mb-4">
                <div class="col">
                    <div class="form-group row">
                        <label for="start_date" class="col-md-2 form-control-label">
                            Start Date
                        </label>
                        <div class="col-md-10">
                            <input name="start_date" placeholder="yyyy-mm-dd" type="text" id="start_date" class="form-control picker" value="{{ $offering->start_date }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="end_date" class="col-md-2 form-control-label">
                            End Date
                        </label>
                        <div class="col-md-10">
                            <input name="end_date" placeholder="yyyy-mm-dd" type="text" id="end_date" class="form-control picker" value="{{ $offering->end_date }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="coins_total" class="col-md-2 form-control-label">
                            Amount of Coins
                        </label>
                        <div class="col-md-10">
                            <input name="coins_total" placeholder="1000" type="number" id="coins_total" class="form-control" value="{{ $offering->coins_total }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="coins_rate" class="col-md-2 form-control-label">
                            Coin rate(1 coin = ? USD)
                        </label>
                        <div class="col-md-10">
                            <input name="coins_rate" placeholder="1" type="number" step="any" id="coins_rate" class="form-control" value="{{ $offering->coins_rate }}" required>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Save changes</button>
            <button type="button" class="btn btn-secondary" onclick="document.location.href='{{ route('admin.offerings') }}';">Cancel</button>
        </div>
    </div>
</form>
@endsection
@push('after-scripts')
    <script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>
    <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
    <script>
        $('.picker').daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    </script>
@endpush