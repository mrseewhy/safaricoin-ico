<template>
    <div>
        <div class="table-responsive" v-bind:class="{blockLoading: loading}">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th class="text-right">Amount of Coins</th>
                    <th class="text-right">Coin rate(1 coin = ? USD)</th>
                    <th></th>
                </tr>
                </thead>
                <tbody v-if="!list.length">
                <tr>
                    <td colspan="12">
                        <small v-if="!list.length">No offering rounds found&hellip;</small>
                    </td>
                </tr>
                </tbody>
                <tbody v-if="list.length">
                <tr v-for="a in list" v-bind:id="a.id">
                    <td>
                        {{ a.start_date }}
                    </td>
                    <td>
                        {{ a.end_date }}
                    </td>
                    <td class="text-right">
                        {{ a.coins_total }}
                    </td>
                    <td class="text-right">
                        {{ a.coins_rate }}
                    </td>
                    <td class="text-right">
                        <div class="btn-group btn-group-sm" role="group" aria-label="Small button group">
                            <button type="button" class="btn btn-outline-primary" v-on:click="editRound(a)">
                                <i class="fa fa-pencil"></i> Edit
                            </button>
                            <button type="button" class="btn btn-outline-danger" v-on:click="deleteRound(a)">
                                <i class="fa fa-trash-o"></i> Delete
                            </button>
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
                $.post('/admin/offerings/search', {
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
            editRound: function(model) {
                document.location.href = '/admin/offerings/edit/' + model.id;
            },
            deleteRound: function(model) {
                if (confirm('Delete round?')) {
                    var $this = this;
                    $this.loading = true;
                    $.post('/admin/offerings/delete/', {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            id: model.id
                        },
                        function (response) {
                            $this.goToPage(1);
                        });
                }
            }
        },
        created: function() {
            this.refreshList();
        }
    }
</script>
