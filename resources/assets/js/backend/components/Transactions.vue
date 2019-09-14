<template>
    <div>

        <div class="table-responsive" v-bind:class="{blockLoading: loading}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Currency</th>
                    <th>Amount</th>
                    <th>Transaction Type</th>
                    <th>Transaction ID</th>
                    <th>Transaction Address</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td></td>
                    <td><input v-on:keyup="search()" v-model="filters.email" placeholder="user email.." type="text" class="form-control form-control-sm"></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><input v-on:keyup="search()" v-model="filters.txID" placeholder="transaction id.." type="text" class="form-control form-control-sm"></td>
                    <td><input v-on:keyup="search()" v-model="filters.addr" placeholder="transaction address.." type="text" class="form-control form-control-sm"></td>
                    <td></td>
                    <td></td>
                </tr>
                </thead>
                <tbody v-if="!list.length">
                <tr>
                    <td colspan="12">
                        <small v-if="!list.length">No transactions found&hellip;</small>
                    </td>
                </tr>
                </tbody>
                <tbody v-if="list.length">
                <tr v-for="a in list">
                    <td>
                        {{ a.created_at }}
                    </td>
                    <td>
                        <a v-bind:href="'/admin/auth/user/' + a.user_id + '/edit'">{{ a.user }}</a>
                    </td>
                    <td>{{ a.transaction_type === 3 ? currencyShort : 'BTC' }}</td>
                    <td>{{ a.transaction_amount }}</td>
                    <td><span class="badge p-1" v-bind:class="{'badge-success' : a.transaction_type == 1, 'badge-info' : a.transaction_type == 2, 'badge-primary' : a.transaction_type == 3, 'badge-secondary text-white' : a.transaction_type == 4}">{{ getType(a.type) }}</span></td>
                    <td class="text-center">{{ a.transaction_id }}</td>
                    <td class="text-center">{{ a.transaction_address }}</td>
                    <td><span class="badge p-1" v-bind:class="['badge-' + getStatusLabel(a.status)]">{{ getStatus(a.status) }}</span></td>
                    <td>
                        <a v-bind:href="'/admin/transactions/' + a.id" class="btn btn-sm btn-outline-primary"><i class="fa fa-eye" aria-hidden="true"></i></a>
                    </td>
                </tr>
                </tbody>
            </table>
            <div>
                <div class="pull-left">
                    Showing page {{ currentPage }} out of {{ lastPage }}
                </div>
                <div class="btn-group btn-group-sm pull-right" role="group" aria-label="Small button group">
                    <button v-on:click="goToPage(currentPage - 1)" :disabled="currentPage == 1" type="button" class="btn btn-outline-secondary"><i class="fa fa-arrow-left" aria-hidden="true"></i> Previous</button>
                    <button v-on:click="goToPage(currentPage + 1)" :disabled="currentPage >= lastPage" type="button" class="btn btn-outline-secondary">Next <i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                </div>
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
                currencyShort: window.currencyShort,
                currentPage: '?',
                lastPage: '?',
                filters: {
                    email: null,
                    txID: null,
                    addr: null
                },
                searchTimeout: null
            }
        },
        methods: {
            goToPage: function(page) {
                var filter = {
                    page: page
                };
                this.refreshList(filter);
            },
            search: function() {
                clearTimeout(this.searchTimeout);
                var $this = this;
                this.searchTimeout = setTimeout(function() {
                    $this.refreshList($this.filters);
                }, 300);
            },
            refreshList: function(filter) {
                var $this = this;
                $this.loading = true;
                $.post('/admin/transactions/search', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        filter: filter
                    }
                    , function (response) {
                        $this.list = response.data;
                        $this.currentPage = response.currentPage;
                        $this.lastPage = response.lastPage;
                        $this.loading = false;
                    });
            },
            getType: function(status) {
                var map = {
                    '1': 'Deposit',
                    '2': 'Withdrawal',
                    '3': 'Buy coins',
                    '4': 'Referral bonus',
                };
                return map[status];
            },
            getStatus: function(status) {
                var map = {
                    '1': 'New',
                    '2': 'Pending',
                    '5': 'Completed',
                };
                return map[status];
            },
            getStatusLabel: function(status) {
                var map = {
                    '1': 'secondary text-white',
                    '2': 'info',
                    '5': 'primary',
                };
                return map[status];
            }
        },
        created: function() {
            this.refreshList();
        }
    }
</script>
