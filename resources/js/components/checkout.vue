<template>
    <div class="row">
        <notifications group="foo"/>
        <div class="col-md-8 mb-4">
            <div class="card">
                <div class="card-body">
                    <b-form @submit.stop.prevent="onSubmit">
                        <b-row>
                            <b-col lg="6">
                                <b-form-group id="example-input-group-1" label="Name" label-for="example-input-1">
                                    <b-form-input id="example-input-1" name="example-input-1" v-model="$v.form.name.$model" :state="validateState('name')" aria-describedby="input-1-live-feedback"></b-form-input>
                                    <b-form-invalid-feedback id="input-1-live-feedback">This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
                                </b-form-group>
                            </b-col>

                            <b-col lg="6">
                                <b-form-group id="example-input-group-2" label="Email" label-for="example-input-2">
                                    <b-form-input type="email" id="example-input-2" name="example-input-2" v-model="$v.form.email.$model" :state="validateState('email')" aria-describedby="input-2-live-feedback"></b-form-input>
                                    <b-form-invalid-feedback id="input-2-live-feedback">This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
                                </b-form-group>
                            </b-col>

                            <b-col>
                                <b-form-group id="example-input-group-3" label="Address" label-for="example-input-3">
                                    <b-form-input id="example-input-3" name="example-input-3" v-model="$v.form.address.$model" :state="validateState('address')" aria-describedby="input-3-live-feedback" placeholder="1234 Main St"></b-form-input>
                                    <b-form-invalid-feedback id="input-3-live-feedback">This is a required field and must be at least 3 characters.</b-form-invalid-feedback>
                                </b-form-group>
                                <hr class="mt-4 mb-4"/>
                                <b-button type="submit" variant="primary" size="lg" block>Continue to checkout</b-button>
                            </b-col>
                        </b-row>
                    </b-form>
                </div>
            </div>
        </div>
        <div class="col-md-4 mb-4">
            <h4 class="d-flex justify-content-between align-items-center mb-3">
                <span class="text-muted">Your cart</span>
                <span class="badge badge-secondary badge-pill">3</span>
            </h4>
            <ul class="list-group mb-3 z-depth-1">
                <li v-for="pizza in items" class="list-group-item d-flex justify-content-between lh-condensed">
                    <div>
                        <h6 class="my-0">{{ pizza.item_property.product_name }}</h6>
                    </div>
                    <span class="text-muted">${{ pizza.price }}x{{ pizza.count }}</span>
                </li>

                <li class="list-group-item d-flex justify-content-between">
                    <span>Total: </span>
                    <strong>${{ totalPrice(items) }}</strong>
                </li>
            </ul>
        </div>
    </div>
</template>

<script>
    import {validationMixin} from "vuelidate";
    import {email, minLength, required} from "vuelidate/lib/validators";

    export default {
        mixins: [validationMixin],
        data: function () {
            return {
                form: {
                    name: "",
                    email: "",
                    address: "",
                },
                items: [],
            };
        },
        validations: {
            form: {
                name: {
                    required,
                    minLength: minLength(3),
                },
                email: {
                    required,
                    email,
                    minLength: minLength(3),
                },
                address: {
                    required,
                    minLength: minLength(3),
                },
            },
        },
        mounted() {
            var app = this;
            axios.get("/api/basket")
                .then(function (resp) {
                    app.items = resp.data;
                })
                .catch(function (resp) {
                    alert("Could not load products");
                });
        },
        methods: {
            validateState(name) {
                const {$dirty, $error} = this.$v.form[name];
                return $dirty ? !$error : null;
            },
            totalPrice(e) {
                let count = 0;
                if (e.length > 0) e.map((a) => (count += Number(a.price)));
                return count.toFixed(2);
            },
            onSubmit() {
                var app = this;
                this.$v.form.$touch();
                if (this.$v.form.$anyError) {
                    return;
                }
                axios.post("/api/basket/checkout", app.form)
                    .then(function (resp) {
                        app.$notify({
                            group: 'foo',
                            title: 'The order is formed, our manager will contact you shortly.'
                        });
                        setTimeout(function () {
                            window.location = "/";
                        },2000)
                    })
                    .catch(function (resp) {
                        alert("Could not ordering...");
                    });
            },
        },
    };
</script>
