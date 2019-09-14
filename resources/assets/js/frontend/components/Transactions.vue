<template>
    <div class="box-static box-bordered p-30">
        <div class="box-title mb-30">
            <h2 class="fs-20">
                Transactions
            </h2>
        </div>
        <div v-if="loading">
            <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
        </div>
        <div v-if="!loading">
            <small v-if="!list.length">No transactions found&hellip;</small>
            <div v-if="list.length" class="table-responsive">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Currency</th>
                        <th>Amount</th>
                        <th>Transaction Type</th>
                        <th>Status</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="a in list">
                        <td>
                            {{ a.created_at }}
                        </td>
                        <td>{{ a.transaction_type === 3 ? currencyShort : 'BTC' }}</td>
                        <td>{{ a.transaction_amount }}</td>
                        <td><span class="badge p-1" v-bind:class="{'badge-success' : a.transaction_type == 1, 'badge-info' : a.transaction_type == 2, 'badge-primary' : a.transaction_type == 3, 'badge-secondary text-white' : a.transaction_type == 4}">{{ a.type }}</span></td>
                        <td><span class="badge p-1" v-bind:class="['badge-' + a.status_label]">{{ a.status }}</span></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                loading: false,
                list: [],
                currencyShort: window.currencyShort
            }
        },
        methods: {
            refreshList: function() {
                var $this = this;
                $this.loading = true;
                $.get('/api/getTransactions', function(response) {
                    $this.list = response;
                    $this.loading = false;
                });
            }
        },
        created: function() {
            this.refreshList();
        }
    }
</script>
