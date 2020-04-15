<template>
    <div class="row">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th width=40% scope="col">Order list</th>
                <th scope="col">Order price</th>
                <th scope="col">Email</th>
                <th scope="col">Address</th>
                <th scope="col">Ordered at</th>
            </tr>
            </thead>
            <tr v-for="order in orders">
                <th scope="row">{{ order.id }}</th>
                <td><small v-for="(items,index) in order.items">{{ items.item_property.product_name }}<span v-if="index+1 < order.items.length">, </span></small></td>
                <td>{{ order.price }}</td>
                <td>{{ order.email }}</td>
                <td>{{ order.address }}</td>
                <td>{{ order.updated_at | moment("MM.DD.YYYY HH:MM") }}</td>
            </tr>
        </table>
    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                orders: []
            };
        },
        mounted() {
            var app = this;
            axios.get("/api/history")
                .then(function (resp) {
                    app.orders = resp.data;
                })
                .catch(function (resp) {
                    alert("Could not load history");
                });
        }
    };
</script>
