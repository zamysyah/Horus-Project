<template>
  <div class="home-page">
    <div class="header">
      <h1>📦 Warehouse Products</h1>
      <router-link to="/product/create" class="add-product-button">+ Add New Product</router-link>
    </div>

    <div v-if="loading" class="loading">Loading products...</div>

    <div v-else>
      <div v-if="products.length === 0" class="empty-state">
        <p>No products found in inventory.</p>
      </div>
      <div v-else class="product-grid">
        <div v-for="product in products" :key="product.id" class="product-card">
          <img
            v-if="product.image"
            :src="getImageUrl(product)"
            alt="Product Image"
            class="product-image"
          />
          <div class="product-info">
            <h2>
              <router-link :to="'/product/' + product.id">{{ product.name }}</router-link>
            </h2>
            <p class="price">{{ currency(product.price) }}</p>
          </div>
          <div class="actions">
            <router-link :to="'/product/edit/' + product.id" class="edit-button">Edit</router-link>
            <button @click="deleteProduct(product.id)" class="delete-button">Delete</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'HomePage',
  data() {
    return {
      products: [],
      loading: true,
    };
  },
  methods: {
    currency(value) {
      return '$' + parseFloat(value).toFixed(2);
    },
    getImageUrl(product) {
      if (!product.image) return '';
      let imagePath = product.image.startsWith('/') ? product.image.substring(1) : product.image;
      if (!imagePath.startsWith('uploads/')) {
        imagePath = 'uploads/' + imagePath;
      }
      const backendBaseUrl = 'http://localhost/horusreza/backend/';
      return backendBaseUrl + imagePath;
    },
    fetchProducts() {
      axios.get('http://localhost/horusreza/backend/api/product_read.php')
        .then(response => {
          this.products = response.data.products || [];
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        })
        .finally(() => {
          this.loading = false;
        });
    },
    deleteProduct(id) {
      if (confirm('Are you sure you want to delete this product?')) {
        axios.delete('http://localhost/horusreza/backend/api/product_delete.php', { data: { id } })
          .then(() => this.fetchProducts())
          .catch(error => console.error('Error deleting product:', error));
      }
    },
  },
  created() {
    this.fetchProducts();
  },
  watch: {
    $route(to) {
      if (to.path === '/home') {
        this.fetchProducts();
      }
    }
  }
};
</script>

<style scoped>
.home-page {
  padding: 30px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  background-color: #f9f9f9;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 25px;
}

h1 {
  font-size: 28px;
  color: #2c3e50;
  margin: 0;
}

.add-product-button {
  padding: 10px 20px;
  background-color: #3498db;
  color: white;
  border-radius: 6px;
  text-decoration: none;
  font-weight: bold;
  transition: background-color 0.2s ease;
}

.add-product-button:hover {
  background-color: #2980b9;
}

.loading {
  text-align: center;
  font-size: 18px;
  color: #7f8c8d;
}

.empty-state {
  text-align: center;
  padding: 40px;
  font-size: 18px;
  color: #95a5a6;
}

.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 20px;
}

.product-card {
  background-color: #ffffff;
  border-radius: 10px;
  box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
  padding: 15px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  transition: transform 0.2s ease;
}

.product-card:hover {
  transform: translateY(-5px);
}

.product-image {
  max-height: 150px;
  object-fit: cover;
  border-radius: 6px;
  margin-bottom: 10px;
  background-color: #ecf0f1;
}

.product-info h2 {
  font-size: 18px;
  color: #34495e;
  margin: 5px 0;
}

.price {
  font-size: 16px;
  font-weight: bold;
  color: #2ecc71;
}

.actions {
  display: flex;
  justify-content: space-between;
  margin-top: 15px;
}

.edit-button,
.delete-button {
  padding: 6px 12px;
  border: none;
  border-radius: 4px;
  font-size: 14px;
  text-align: center;
  cursor: pointer;
  text-decoration: none;
}

.edit-button {
  background-color: #f39c12;
  color: white;
}

.edit-button:hover {
  background-color: #d68910;
}

.delete-button {
  background-color: #e74c3c;
  color: white;
}

.delete-button:hover {
  background-color: #c0392b;
}
</style>
