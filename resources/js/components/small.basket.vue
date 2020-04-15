<template>
    <li class="cart">
        <div class="cart-wrap" v-out="toggle">
            <notifications group="foo"/>
            <b-button variant="link" v-on:click="toggle = !toggle">
                <b-icon :icon="items.length > 0 ? 'bucket-fill' : 'bucket'" font-scale="1" aria-hidden="true"></b-icon>
                <span>{{ items.length }} - Items in Cart</span>
            </b-button>
            <div :class="toggle ? 'cart-dropdown active' : 'cart-dropdown'">
                <div class="cart-body">
                    <div v-if="items.length == 0" class="item">
                        <span class="empty">Empty</span>
                    </div>
                    <div class="item" v-for="(item, index) in items" :key="index">
                        <div class="img">
                            <img class="img-responsive" :src="'/img/' + item.item_property.src + '.jpeg'" :alt="item.item_property.product_name"/>
                        </div>
                        <div class="detail">
                            <div class="title">
                                <strong>{{ item.item_property.product_name }}</strong>
                            </div>
                        </div>
                        <div class="count">
                            <strong>{{ item.price }}</strong>
                            <span class="text-muted">x</span>
                            <strong>{{ item.item_count }}</strong>
                        </div>
                        <div class="action">
                            <b-button size="sm" variant="outline-danger" v-on:click="removeFromCard(item.id)">
                                <b-icon icon="trash-fill" font-scale="1" aria-hidden="true"></b-icon>
                            </b-button>
                        </div>
                    </div>
                </div>
                <div v-if="items.length > 0" class="cart-footer">
                    <span class="total">Total price: <b>{{ totalPrice(items) }}$</b></span>
                    <a href="/checkout" class="btn btn-success btn-sm">Checkout</a>
                </div>
            </div>
        </div>
    </li>
</template>

<script>
    export default {
        data: function () {
            return {
                items: [],
                toggle: false,
            };
        },
        mounted() {
            var app = this;
            app.basketMount();
            this.$root.$on("small_basket_update", function () {
                app.$notify({
                    group: 'foo',
                    title: 'Item added'
                });
                app.basketMount();
            });
        },
        methods: {
            totalPrice(e) {
                let count = 0;
                if (e.length > 0) e.map((a) => (count += Number(a.price)));
                return count.toFixed(2);
            },
            handleFocus() {
                this.toggle = true;
            },
            handleFocusOut() {
                this.toggle = false;
            },
            removeFromCard(id) {
                var app = this;
                axios
                    .delete("/api/basket/" + id)
                    .then(function (resp) {
                        app.basketMount();
                    })
                    .catch(function (resp) {
                        //alert("Could not delete item");
                    });
            },
            basketMount() {
                var app = this;
                axios
                    .get("/api/basket")
                    .then(function (resp) {
                        app.items = resp.data;
                    })
                    .catch(function (resp) {
                        alert("Could not load small basket");
                    });
            },
        },
    };
</script>

<style lang="scss">
    .cart {
        position: relative;
        display: flex;

        &-wrap {
            & > button {
                display: flex;
                align-items: center;

                & > svg {
                    margin-right: 5px;
                }
            }
        }

        &-dropdown {
            display: none;

            position: absolute;
            top: 100%;
            right: 0;
            z-index: 10000;

            flex-direction: column;
            min-width: 320px;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;

            &.active {
                display: flex;
            }
        }

        &-body {
            display: flex;
            flex-wrap: wrap;
            width: 100%;
            line-height: 1.2;
            z-index: 0;

            .item {
                position: relative;
                display: flex;
                align-items: center;
                width: 100%;
                padding: 0 10px;
                padding-top: 10px;
                margin-top: 10px;

                &:before {
                    position: absolute;
                    content: "";
                    top: 0;
                    left: 0;
                    display: block;
                    width: 100%;
                    height: 0;
                    border: 0;
                    border-top: 1px solid rgba(0, 0, 0, 0.1);
                }

                &:first-child {
                    margin-top: 0;

                    &:before {
                        display: none;
                    }
                }

                &:last-child {
                    padding-bottom: 10px;
                }
            }

            .empty {
                padding: 15px;
                margin-bottom: 0;
            }

            .img {
                margin-right: 10px;

                img {
                    width: 48px;
                    height: auto;
                }
            }

            .count {
                display: flex;
                margin-left: auto;
                padding: 0 10px;
            }

            .action {
                position: relative;
                z-index: 1;
            }
        }

        &-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px;
            background-color: rgba(0, 0, 0, 0.03);
            border-top: 1px solid rgba(0, 0, 0, 0.125);
        }
    }
</style>
