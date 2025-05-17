<template>
  <div class="update-container">
    <h2>Update User</h2>
    <form @submit.prevent="updateUser" class="form">
      <input type="text" v-model="username" placeholder="Username" required />
      <input type="password" v-model="password" placeholder="Password" required />
      <input type="email" v-model="email" placeholder="Email" required />
      <input type="text" v-model="nama" placeholder="Nama" required />
      <div class="button-group">
        <button type="submit">Update</button>
        <button type="button" @click="goBack">Back</button>
      </div>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      id: this.$route.params.id,
      username: '',
      password: '',
      email: '',
      nama: ''
    };
  },
  methods: {
    updateUser() {
      if (!this.username || !this.password || !this.email || !this.nama) {
        alert("Semua kolom harus diisi");
        return;
      }

      axios.put(`http://localhost/horusreza/backend/api/update_user.php?id=${this.id}`, {
        username: this.username,
        password: this.password,
        email: this.email,
        nama: this.nama
      })
      .then(() => {
        alert('User berhasil diperbarui!');
        this.$router.push('/dashboard');
      })
      .catch(error => {
        console.error(error);
        alert('Terjadi kesalahan saat memperbarui user');
      });
    },
    goBack() {
      this.$router.push('/dashboard');
    }
  },
  mounted() {
    axios.get(`http://localhost/horusreza/backend/api/get_users.php?id=${this.id}`)
    .then(response => {
      const user = response.data;
      this.username = user.username;
      this.password = ''; // Kosongkan password agar tidak tampil
      this.email = user.email;
      this.nama = user.nama;
    })
    .catch(error => {
      console.error(error);
      alert('Gagal memuat data user');
    });
  }
};
</script>

<style scoped>
.update-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 24px;
  border: 1px solid #ccc;
  border-radius: 10px;
  background-color: #f9f9f9;
}
h2 {
  text-align: center;
  margin-bottom: 20px;
}
input {
  width: 100%;
  padding: 10px;
  margin-bottom: 12px;
  border: 1px solid #ccc;
  border-radius: 5px;
}
.button-group {
  display: flex;
  justify-content: space-between;
}
button {
  padding: 10px 16px;
  border: none;
  border-radius: 5px;
  cursor: pointer;
}
button[type="submit"] {
  background-color: #28a745;
  color: white;
}
button[type="submit"]:hover {
  background-color: #218838;
}
button[type="button"] {
  background-color: #6c757d;
  color: white;
}
button[type="button"]:hover {
  background-color: #5a6268;
}
</style>
