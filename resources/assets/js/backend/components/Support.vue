<template>
    <div>

        <div class="table-responsive" v-bind:class="{blockLoading: loading}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Date</th>
                    <th>User</th>
                    <th>Transaction ID</th>
                    <th>Transaction Hash</th>
                    <th>Message</th>
                </tr>
                </thead>
                <tbody v-if="!list.length">
                <tr>
                    <td colspan="12">
                        <small v-if="!list.length">No support requests found&hellip;</small>
                    </td>
                </tr>
                </tbody>
                <tbody v-if="list.length">
                <tr v-for="a in list">
                    <td>
                        {{ a.created_at }}
                    </td>
                    <td>
                        <a v-if="a.user" v-bind:href="'/admin/auth/user/' + a.user.id + '/edit'">{{ a.user.email }}</a>
                    </td>
                    <td class="text-center">{{ a.transaction_id }}</td>
                    <td class="text-center">{{ a.transaction_hash }}</td>
                    <td>{{ a.message }}</td>
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
                lastPage: '?'
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
                $.post('/admin/support/search', {
                        _token: $('meta[name="csrf-token"]').attr('content'),
                        filter: filter
                    }
                    , function (response) {
                        $this.list = response.data;
                        $this.currentPage = response.current_page;
                        $this.lastPage = response.last_page;
                        $this.loading = false;
                    });
            }
        },
        created: function() {
            this.refreshList();
        }
    }
</script>
