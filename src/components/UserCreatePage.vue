<template>
  <div>
    <h2>Tambah User Baru</h2>
    <form @submit.prevent="createUser">
      <div>
        <label>Username:</label>
        <input v-model="form.username" required />
      </div>
      <div>
        <label>Email:</label>
        <input v-model="form.email" required type="email" />
      </div>
      <div>
        <label>Nama:</label>
        <input v-model="form.nama" required />
      </div>
      <button type="submit">Simpan</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      form: {
        username: '',
        email: '',
        nama: ''
      }
    };
  },
  methods: {
    createUser() {
      axios.post('http://localhost/horusreza/backend/api/create_user.php', this.form)
        .then(() => {
          alert('User berhasil ditambahkan');
          this.$router.push('/dashboard'); // Kembali ke dashboard
        })
        .catch(error => {
          console.error(error);
          alert('Gagal menambahkan user');
        });
    }
  }
};
</script>
