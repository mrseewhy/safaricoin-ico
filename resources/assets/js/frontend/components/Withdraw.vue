<template>
    <div class="box-static box-bordered p-30 mb-2">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                Withdraw Bitcoin
            </h2>
        </div>
        <form v-on:submit.prevent="onSubmit">
            <div class="alert alert-warning">
                Please note that you will be charged 0.001 BTC transaction fees!
            </div>
            <div class="row">
                <div class="col-md-5">
                    <input v-model="address" type="text" class="form-control" placeholder="Wallet Address" required>
                </div>
                <div class="col-md-5">
                    <input v-model="amount" type="number" class="form-control" placeholder="Amount to withdrawal" required min="0.002" step="0.001" v-bind:max="max">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary btn-block" :disabled="max <= 0">Submit</button>
                </div>
            </div>
        </form>
        <div class="modal" tabindex="-1" role="dialog" id="withdrawModal">
            <div class="modal-dialog" role="document" v-bind:class="{ blockLoading: loading }">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Withdraw Bitcoin</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="!thanks">
                            Are you sure you want to withdraw <strong>{{ amount }}</strong> BTC to address <strong>{{ address }}</strong> ?
                        </p>
                        <div class="alert alert-info" v-if="!thanks">
                            Total amount you will receive is {{ (amount - withdrawFee).toFixed(3) }} BTC
                            <br><small>({{ withdrawFee }} BTC transaction fee)</small>
                        </div>
                        <div class="alert alert-info" v-if="thanks">
                            Thank you! Your request has been submitted. We will inform you as soon as amount is sent to your wallet.
                        </div>
                        <div class="alert alert-danger" v-if="error">
                            {{ errorMessage }}
                        </div>
                    </div>
                    <div class="modal-footer" v-if="!thanks">
                        <button id="submitBuy" type="button" class="btn btn-primary" v-on:click="withdraw" :disabled="loading">Yes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal" :disabled="loading">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: [
            'max'
        ],
        data: function () {
            return {
                loading: false,
                address: "",
                amount: "",
                currencyShort: window.currencyShort,
                withdrawFee: window.withdrawFee,
                thanks: false,
                error: false,
                errorMessage: ""
            }
        },
        methods: {
            onSubmit: function() {
                this.thanks = false;
                this.loading = false;
                this.error = false;
                $('#withdrawModal').modal('show');
            },
            withdraw: function() {
                var $this = this;
                $this.loading = true;
                $.post('/api/manualWithdraw', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    address: $this.address,
                    amount: $this.amount,
                }, function(response) {
                    if (response.message) {
                        alert(response.message);
                    }
                    $this.loading = false;
                    $this.thanks = true;
                }).fail(function(response) {
                    if (response.responseJSON.message) {
                        $this.errorMessage = response.responseJSON.message;
                    }
                    $this.loading = false;
                    $this.thanks = false;
                    $this.error = true;
                });
            }
        }
    }
</script>
