<template>
    <div>
        <div class="table-responsive" v-bind:class="{blockLoading: loading}">
            <div>
                <label class="pull-right">
                    <input v-model="completed" type="checkbox" value="1" v-on:change="refreshList([])">
                    Show completed
                </label>
            </div>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Withdraw address</th>
                    <th class="text-right">Amount (w/o fee)</th>
                    <th>Status</th>
                    <th></th>
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
                <tr v-for="a in list" v-bind:id="a.id">
                    <td>
                        {{ a.created_at }}
                    </td>
                    <td>
                        <a v-if="a.user_id" v-bind:href="'/admin/auth/user/' + a.user_id + '/edit'">{{ a.email }}</a>
                    </td>
                    <td class="text-left">{{ a.withdrawal_address }}</td>
                    <td class="text-right">{{ a.transaction_amount }}</td>
                    <td>
                        <span class="badge" v-bind:class="'badge-' + getStatusClass(a.status)">{{ getStatus(a.status) }}</span>
                    </td>
                    <td class="text-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                            <button :disabled="a.status == 2" type="button" class="btn btn-success" v-on:click="toPending(a)">Pending</button>
                            <button :disabled="a.status == 5" type="button" class="btn btn-primary" v-on:click="toCompleted(a)">Completed</button>
                        </div>
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
                currentPage: '?',
                lastPage: '?',
                completed: false
            }
        },
        methods: {
            goToPage: function(page) {
                var filter = {
                    page: page
                };
                this.refreshList(filter);
            },
            refreshList: function(filter) {
                var $this = this;
                $this.loading = true;
                $.post('/admin/withdraw/search', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    completed: $this.completed,
                    filter: filter
                }
                , function (response) {
                    $this.list = response.data;
                    $this.currentPage = response.current_page;
                    $this.lastPage = response.last_page;
                    $this.loading = false;
                });
            },
            getStatus: function(status) {
                var map = {
                    "1": "New",
                    "2": "Pending",
                    "5": "Complete"
                };
                return map[status];
            },
            getStatusClass: function(status) {
                var map = {
                    "1": "warning",
                    "2": "success",
                    "5": "primary"
                };
                return map[status];
            },
            toPending: function(model) {
                this.setStatus(model, 2);
            },
            toCompleted: function(model) {
                this.setStatus(model, 5);
            },
            setStatus: function(model, status) {
                if (0 && status == 5) {
                    if (confirm("Complete transaction? Amount will be substracted from customer balance!")) {
                        this.postStatus(model, status);
                    }
                } else {
                    this.postStatus(model, status);
                }
            },
            postStatus: function(model, status) {
                var $this = this;
                $this.loading = true;
                $.post('/admin/withdraw/status', {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    id: model.id,
                    status: status
                }
                , function (response) {
                    model.status = status;
                    // remove record
                    if (status == 5 && !$this.completed) {
                        $this.list = $this.list.filter(function (item) {
                            return model.id != item.id;
                        });
                    }
                    $this.loading = false;
                }).fail(function(response){
                    if (response.responseJSON.message) {
                        alert(response.responseJSON.message);
                    }
                    $this.loading = false;
                });
            }
        },
        created: function() {
            this.refreshList();
        }
    }
</script>
