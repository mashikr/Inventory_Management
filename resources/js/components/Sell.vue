<template>
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b class="h5">Sell Items</b>
                </div>
                <div class="table-overflow">
                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">Name</th>
                        <th scope="col">Qty</th>
                        <th scope="col">Unit</th>
                        <th scope="col">Total</th>
                        <th scope="col">Remove</th>
                        </tr>
                    </thead>
                  
                    <cart-table :cartproducts="cartproducts" :key="change" @increase="increase($event)" @decrement="decrease($event)" @remove="removeItem($event)"></cart-table>
                   
                    </table>
                </div>
                <hr>
                <div class="p-3">
                    <sell-calculate :products="cartproducts" :key="change" @calculate="calculation($event)"></sell-calculate>
                    <hr>

                    <div class="form-group dropdown">
                        <input type="text" class="form-control" placeholder="Search Customer" v-model="searchCustomer" @keyup="searchCustomers">
                        <div class="dropdown-menu" :class="{ show: customers.length }">
                            <button class="dropdown-item" type="button" v-for="customer,i in customers" :key="customer.id" @click="addCustomer(i)"><b>{{ customer.name }}</b>, {{ customer.address }}</button>
                        </div>
                    </div>

                    <div class="mt-3">
                        <form action="" @submit.prevent="addSell">
                            <div class="form-group">
                                <label for="customername">Customer Name</label>
                                <input type="text" class="form-control" name="customername" v-model="form.customer_name" id="customername" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <input type="text" class="form-control" v-model="form.address" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone no</label>
                                <input type="text" class="form-control" v-model="form.phone" required>
                                <div class="invalid-feedback"></div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <div class="form-group">
                                        <label for="pay">Pay</label>
                                        <input type="number" class="form-control" name="pay" v-model="form.pay" required>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-group">
                                        <label for="back">Back</label>
                                        <input type="number" class="form-control" v-model="back" disabled>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                </div>
                            </div>

                            <input type="submit" name="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <b class="h5">Products</b>
                </div>

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true" @click="productCategoryTab('')">All Product</a>
                    </li>
                    <li class="nav-item" role="presentation" v-for="category in categories" :key="category.id" @click="productCategoryTab(category.category)">
                        <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile" aria-selected="false">{{ category.category }}</a>
                    </li>
                </ul>
                <div class="text-center py-3" v-if="!filterProducts.length">
                    <i class="fas fa-spinner fa-pulse fa-3x"></i>
                </div>
                <div class="tab-content" id="myTabContent" v-else>
                    <div class="form-group">
                        <input type="text" class="form-control" v-model="searchItem" @keyup="searchProduct()" placeholder="Search Products">
                    </div>
                    <div class="row">
                        <div class="card-columns">
                            <div class="card cursor-pointer" @click="cartproduct(product)"  v-for="product in filterProducts" :key="product.id">
                                <img :src="product.image" alt="Product Image" class="card-img-top">
                                <div class="p-2">
                                    <h6 class="text-center font-weight-bold">{{ product.product_name }}</h6>
                                    <p class="text-center mb-0 font-weight-bold text-info">{{ product.selling_price }}৳</p>
                                    <p class="text-center mb-0 font-weight-bold text-success">Stock: {{ product.product_quantity }}</p> 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import CartTable from './Sell/CartTable.vue'
import SellCalculate from './Sell/SellCalculate.vue'
export default {
    components: {
        cartTable : CartTable,
        SellCalculate: SellCalculate
    },
    computed: {
        back() {
            if(this.form.pay) {
                return this.form.pay - this.calculationData.total;
            }
            return 0;
        }
    },
    data() {
      return {
          form: {
              customer_id: null,
              customer_name: null,
              address: null,
              phone: null,
              pay: null,
          },
          categories: {},
          products: {},
          filterProducts: {},
          searchItem: '',
          cartproducts: [],
          change: 0,
          calculationData: {},
          searchCustomer: '',
          customers:{},
      }  
    },
    created() {
        if(!User.loggedIn()) {
            this.$router.push({name: '/'});
        }
        axios.get('/api/category')
        .then(response => this.categories = response.data)
        .catch(error => {
            Notification.error(error.response.data.message);
        })
        axios.get('/api/product')
        .then(response => this.products =this.filterProducts = response.data)
        .catch(error => {
            Notification.error(error.response.data.message);
        })

    },
    methods: {
        productCategoryTab(category) {
            this.filterProducts = [];
            if(category) {
                this.products.forEach(product => {
                    if(product.category == category) {
                        this.filterProducts.push(product);
                    }
                });
            } else {
                this.filterProducts = this.products;
            }
        },
        searchProduct() {
            this.filterProducts = [];
            if(this.searchItem) {
                this.products.forEach(product => {
                    if(product.product_name.toLowerCase().match(this.searchItem.toLowerCase())) {
                        this.filterProducts.push(product);
                    }
                });
            } else {
                this.filterProducts = this.products;
            }
        },
        cartproduct(product) {
            let check = this.cartproducts.find(item => {
                return item.id == product.id;
            })
            if(check) {
               Notification.error("This Product already in cart.");
            } else {
                product.quantity = 1;
                product.unit = product.selling_price
                this.cartproducts.push(product);
                this.change++;
            }
        },
        increase(i) {
            if( this.cartproducts[i].quantity ==  this.cartproducts[i].product_quantity) {
                Notification.error("Stock Fillup.");
            } else {
                this.cartproducts[i].quantity = this.cartproducts[i].quantity+1;
                this.change++;
            }
        },
        decrease(i) {
            if(this.cartproducts[i].quantity == 1) {
                Notification.error("Atleast one item select.");
            } else {
                this.cartproducts[i].quantity = this.cartproducts[i].quantity-1;
                this.change--;
            }
        },
        removeItem(i) {
            this.cartproducts.splice(i, 1);
        },
        calculation(cal) {
            this.calculationData = cal;
        },
        searchCustomers() {
            if(this.searchCustomer.trim()) {
                axios.post("/api/customer/search", {token: this.searchCustomer})
                .then(res => {
                    //console.log(res.data);
                    this.customers = res.data;
                })
                .catch(error =>  Notification.error(error.response.data.message))
            } else {
                 this.customers = {};
            }
        },
        addCustomer(i) {
            this.form.customer_id = this.customers[i].id;
            this.form.customer_name = this.customers[i].name;
            this.form.address = this.customers[i].address;
            this.form.phone = this.customers[i].phone;
            this.searchCustomer = '';
            this.customers = {};
        },
        addSell() {
            if(this.cartproducts.length && this.form.customer_name && this.form.pay) {
                let sellData = {
                    customer: this.form,
                    products: this.cartproducts,
                    calculation: this.calculationData
                }

                axios.post("/api/sell", sellData)
                    .then(res => {
                        Notification.success();
                        this.$router.push({name: 'SellList'});
                    })
                    .catch(error =>  Notification.error(error.response.data.message))
            } else {
                Notification.error("Product or Customer data empty.")
            }
        }
    },
    
}
</script>

<style scoped>
.table-overflow {
    overflow-x: auto;
}
.active {
    background-color: #52CDFF !important;
    color: white !important;
}
.cursor-pointer {
    cursor: pointer;
}
</style>