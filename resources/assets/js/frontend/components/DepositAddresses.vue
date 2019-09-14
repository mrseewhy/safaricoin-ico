<template>
    <div class="panel panel-default">
        <div class="panel-heading">Deposit Addresses</div>

        <div class="panel-body">
            <div v-if="loading">
                <i class="fa fa-circle-o-notch fa-spin fa-fw"></i>
            </div>
            <div v-if="!loading">
                <small v-if="!list.length">No addresses found&hellip;</small>
                <table v-if="list.length" class="table table-responsive table-striped">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Currency</th>
                        <th>Address</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="a in list">
                        <td>
                            {{ a.created_at }}
                        </td>
                        <td>BTC</td>
                        <td>{{ a.address }}</td>
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
                list: []
            }
        },
        methods: {
            refreshList: function() {
                var $this = this;
                $this.loading = true;
                $.get('/api/getAddresses', function(response) {
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
