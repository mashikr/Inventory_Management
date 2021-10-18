<template>
    <div class="card p-3">
        <div class="d-flex justify-content-between">
            <span>Total Quantity:</span> <span>{{ total_quantity }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Sub Total:</span> <span>{{ sub_total }}</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Vat:</span> <span><input type="number" v-model="vat" style="width: 45px" @change="sendData()">%</span>
        </div>
        <div class="d-flex justify-content-between">
            <span>Total:</span> <span>{{ total }}</span>
        </div>
    </div>
</template>

<script>
export default {
    props: ['products'],
    data() {
        return {
            total_quantity: 0,
            sub_total: 0,
            vat: 15,
        }
    },
    created() {
        this.products.forEach(item => {
            this.total_quantity += item.quantity;
            this.sub_total += item.quantity*item.selling_price;
        });
        this.sendData();
    },
    computed: {
        total() {
            return this.sub_total + (this.sub_total * this.vat / 100);
        }
    },
    methods: {
        sendData() {
            this.$emit('calculate', {
                total_quantity: this.total_quantity,
                sub_total: this.sub_total,
                vat: parseInt(this.vat),
                total: this.total,
            })
        }
    }
}
</script>