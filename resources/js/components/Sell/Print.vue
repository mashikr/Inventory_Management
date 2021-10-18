<template>
    <div id="print">
        <div class="text-center">
            <h3>Cash Memo</h3>
            <h4>Apu Shop</h4>
            <h6>Maijdee, Noakhali 1201</h6>
        </div>
        <hr>
        <div class="d-flex justify-content-between px-3">
            <div>
                <span><b>Customer:</b> {{ sells.customer_name }}</span>
                <span><b>Address:</b> {{ sells.customer_address }}</span>
                <span><b>phone:</b> {{ sells.customer_phone }}</span>
            </div>
            <p><b>Date:</b> {{ sells.date }}</p>
        </div>
        <hr>
        <table class="table table-striped">
            <thead>
                <tr>
                <th scope="col">No</th>
                <th scope="col">Product Name</th>
                <th scope="col">Quantity</th>
                <th scope="col">Price</th>
                <th scope="col">Total</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="item,i in sells.products" :key="item.id">
                <td>{{ i+1 }}</td>
                <td>{{ item.name }}</td>
                <td>{{ item.quantity }}</td>
                <td>{{ item.price }}৳</td>
                <td>{{ item.price*item.quantity }}৳</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Sub Total</th>
                    <td>{{ sells.payments.sub_total }}৳</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Vat</th>
                    <td>{{ sells.payments.vat }}%</td>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <th>Total</th>
                    <td>{{ sells.payments.total }}৳</td>
                </tr>
            </tbody>
        </table>

        <div>
            <span><b>Payment:</b> {{ sells.payments.pay }}৳</span>
            <span><b>Back:</b> {{ sells.payments.back }}৳</span>
        </div>
    </div>
</template>

<script>
export default {
    created() {
        if(!User.loggedIn()) {
                this.$router.push({name: '/'});
        }
        axios.get("/api/sell/"+this.$route.params.id)
            .then(res => {
                this.sells = res.data;
            })
            .catch(error => this.errorMessage = error.response.data.message)

            $('title').text("cash memo");
            setTimeout(function() {
                $('nav').addClass('d-none').removeClass('d-flex');
                window.print();
            },10)
    },
    data() {
        return {
            sells: {}
        }
    }
}
</script>

<style scoped>
span {
    display: block;
    margin-bottom: .8rem;
}
</style>