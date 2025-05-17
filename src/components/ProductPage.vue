<template>
  <div class="product-page" v-if="product">
    <h1>{{ product.name }}</h1>
    <p><strong>Price:</strong> {{ currency(product.price) }}</p>
    <p><strong>Description:</strong> {{ product.description }}</p>
    <router-link to="/">Back to Products</router-link>
  </div>
  <div v-else>
    Loading product details...
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ProductPage',
  data() {
    return {
      product: null,
    };
  },
  methods: {
    currency(value) {
      return '$' + parseFloat(value).toFixed(2);
    },
    fetchProduct() {
      const productId = this.$route.params.id;
      axios.get(`http://localhost/horusreza/backend/api/product_read.php?id=${productId}`)
        .then(response => {
          this.product = response.data.product || null;
        })
        .catch(error => {
          console.error('Error fetching product:', error);
        });
    },
  },
  created() {
    this.fetchProduct();
  },
};
</script>

<style scoped>
.product-page {
  padding: 20px;
}
</style>
