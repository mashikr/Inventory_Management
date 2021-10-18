<template>
    <tbody>
        <tr v-for="cart,i in cartproducts" :key="cart.id">
            <td>{{ cart.product_name }}</td>
            <td>
                <span>{{ cart.quantity }}</span>
                <button class="btn btn-sm btn-success ml-1" @click="increment(i)">+</button>
                <button class="btn btn-sm btn-danger"  @click="decrement(i)">-</button>
            </td>
            <td>{{ cart.unit }}</td>
            <td>{{ cart.unit * cart.quantity }}</td>
            <td><button class="btn btn-sm btn-danger"  @click="remove(i)">X</button></td>
        </tr>
    </tbody>
</template>

<script>
export default {
    props: ['cartproducts', 'index'],
    methods: {
        increment(index) {
            this.$emit('increase', index);
        },
        decrement(index) {
            this.$emit('decrement', index);
        },
        remove(index) {
            this.$emit('remove', index);
        },
    },
}
</script>

<style scoped>
tbody {
    user-select: none;
}
</style>