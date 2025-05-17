<template>
  <div class="product-create-page">
    <div class="card">
      <h1>Add New Product</h1>
      <form @submit.prevent="createProduct" enctype="multipart/form-data" novalidate>
        <div class="form-group">
          <label for="name">Name<span class="required">*</span>:</label>
          <input
            id="name"
            v-model="product.name"
            required
            placeholder="Enter product name"
            :disabled="loading"
          />
        </div>

        <div class="form-group">
          <label for="price">Price<span class="required">*</span>:</label>
          <input
            id="price"
            type="number"
            step="0.01"
            v-model.number="product.price"
            required
            placeholder="Enter product price"
            :disabled="loading"
          />
        </div>

        <div class="form-group">
          <label for="description">Description:</label>
          <textarea
            id="description"
            v-model="product.description"
            placeholder="Add a description (optional)"
            rows="4"
            :disabled="loading"
          ></textarea>
        </div>

        <div class="form-group">
          <label for="image">Image:</label>
          <input
            id="image"
            type="file"
            @change="onFileChange"
            accept="image/*"
            :disabled="loading"
          />
        </div>

        <div v-if="errorMessage" class="error-message">{{ errorMessage }}</div>

        <div class="button-group">
          <button type="submit" :disabled="loading">
            {{ loading ? 'Adding...' : 'Add Product' }}
          </button>
          <router-link to="/home" class="btn-cancel" :class="{ disabled: loading }">Cancel</router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  name: 'ProductCreatePage',
  data() {
    return {
      product: {
        name: '',
        price: 0,
        description: '',
      },
      imageFile: null,
      loading: false,
      errorMessage: '',
    };
  },
  methods: {
    onFileChange(event) {
      this.imageFile = event.target.files[0];
    },
    createProduct() {
      if (!this.product.name.trim() || this.product.price <= 0) {
        this.errorMessage = 'Please enter a valid name and price.';
        return;
      }
      this.errorMessage = '';
      this.loading = true;

      const formData = new FormData();
      formData.append('name', this.product.name);
      formData.append('price', this.product.price);
      formData.append('description', this.product.description);
      if (this.imageFile) {
        formData.append('image', this.imageFile);
      }

      axios
        .post('http://localhost/horusreza/backend/api/product_create.php', formData, {
          headers: {
            'Content-Type': 'multipart/form-data',
          },
        })
        .then(() => {
          alert('Product added successfully.');
          this.$router.push('/home');
        })
        .catch((error) => {
          console.error('Error adding product:', error);
          this.errorMessage = 'Failed to add product.';
        })
        .finally(() => {
          this.loading = false;
        });
    },
  },
};
</script>

<style scoped>
.product-create-page {
  max-width: 600px;
  margin: 40px auto;
  padding: 0 20px;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.card {
  background-color: #fff;
  border-radius: 12px;
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
  padding: 30px 40px;
  transition: box-shadow 0.3s ease;
}
.card:hover {
  box-shadow: 0 6px 18px rgba(0, 0, 0, 0.15);
}

h1 {
  margin-bottom: 24px;
  font-weight: 700;
  color: #333;
  text-align: center;
}

form {
  display: flex;
  flex-direction: column;
}

.form-group {
  margin-bottom: 18px;
  display: flex;
  flex-direction: column;
}

label {
  font-weight: 600;
  margin-bottom: 6px;
  color: #444;
}

.required {
  color: #d33;
  margin-left: 4px;
}

input,
textarea {
  padding: 10px 12px;
  border: 1.8px solid #ccc;
  border-radius: 8px;
  font-size: 1rem;
  transition: border-color 0.3s ease;
  outline-offset: 2px;
}

input:focus,
textarea:focus {
  border-color: #007bff;
  outline: none;
  box-shadow: 0 0 6px #007bffaa;
}

.error-message {
  color: #d33;
  font-weight: 600;
  margin-bottom: 16px;
  text-align: center;
}

.button-group {
  display: flex;
  gap: 15px;
  justify-content: center;
  margin-top: 20px;
}

button[type='submit'] {
  background-color: #007bff;
  color: white;
  font-weight: 600;
  border: none;
  border-radius: 8px;
  padding: 12px 28px;
  cursor: pointer;
  transition: background-color 0.3s ease;
}

button[type='submit']:hover:not(:disabled) {
  background-color: #0056b3;
}

button[type='submit']:disabled {
  background-color: #aac8f7;
  cursor: not-allowed;
}

.btn-cancel {
  text-decoration: none;
  color: #555;
  border: 2px solid #bbb;
  border-radius: 8px;
  padding: 10px 26px;
  font-weight: 600;
  text-align: center;
  line-height: 1.4;
  transition: border-color 0.3s ease, color 0.3s ease;
  user-select: none;
}

.btn-cancel:hover:not(.disabled) {
  border-color: #007bff;
  color: #007bff;
}

.btn-cancel.disabled {
  pointer-events: none;
  opacity: 0.6;
}
</style>
