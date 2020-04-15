<template>
    <div class="row catalog">
        <notifications group="foo"/>
        <div v-for="pizza in items" class="col-md-3 col-sm-6">
            <div class="product-grid">
                <div class="product-image">
                    <a href="#">
                        <img v-on:click.prevent="showDescription(pizza)" class="pic-1" :src="'/img/' + pizza.src + '.jpeg'"/>
                    </a>
                    <span v-if="pizza.discount" class="product-new-label">Sale</span>
                    <span v-if="pizza.discount" class="product-discount-label">{{ pizza.discount }}%</span>
                </div>
                <ul class="rating">
                    <li v-for="i in 5" v-bind:class="{ disable: i > pizza.rating }" class="fa fa-star"></li>
                </ul>
                <div class="product-content">
                    <h3 class="title">
                        <a v-on:click.prevent="showDescription(pizza)" href="#">{{ pizza.product_name }}</a>
                    </h3>
                    <div class="price">
                        ${{ pizza.discount_value }}
                        <span>${{ pizza.price }}</span>
                    </div>
                    <a v-on:click.prevent="addToCard(pizza.id)" class="add-to-cart" href="#">+ Add To Cart</a>
                </div>
            </div>
        </div>
        <div class="modal" tabindex="-1" role="dialog">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Modal title</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p class="description-block"></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary">Save changes</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal fade" id="ModalLong" tabindex="-1" role="dialog" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">{{ item.product_name }}</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p v-if="item.composition" class="description-block"><b>Composition: </b>{{ item.composition }}</p>
                        <br v-if="item.desc" >
                        <small v-if="item.desc" class="description-block">{{ item.desc }}</small>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>

<script>
    export default {
        data: function () {
            return {
                items: [],
                item: ""
            };
        },
        mounted() {
            var app = this;
            axios.get("/api/products")
                .then(function (resp) {
                    app.items = resp.data;
                })
                .catch(function (resp) {
                    alert("Could not load products");
                });
        },
        methods: {
            addToCard(id) {
                var app = this;
                axios.put("/api/basket/" + id)
                    .then(function (resp) {
                        app.$root.$emit("small_basket_update");
                    })
                    .catch(function (resp) {
                        //alert("Could not delete products");
                    });
            },
            showDescription(item) {
                this.item = item;
                $('#ModalLong').modal('show');
            }
        },
    };
</script>
