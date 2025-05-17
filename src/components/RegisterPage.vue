<template>
  <div class="register-container">
    <h2>Register</h2>
    <form @submit.prevent="register" class="form">
      <input type="text" v-model="username" placeholder="Username" required />
      <input type="password" v-model="password" placeholder="Password" required />
      <input type="email" v-model="email" placeholder="Email" required />
      <input type="text" v-model="nama" placeholder="Nama Lengkap" required />
      <button type="submit">Register</button>
    </form>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      username: '',
      password: '',
      email: '',
      nama: ''
    };
  },
  methods: {
    register() {
      if (!this.username || !this.password || !this.email || !this.nama) {
        alert("Harap isi semua kolom");
        return;
      }

      // Validasi email
      const emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
      if (!emailPattern.test(this.email)) {
        alert("Email tidak valid");
        return;
      }

      const params = new URLSearchParams();
      params.append('username', this.username);
      params.append('password', this.password);
      params.append('email', this.email);
      params.append('nama', this.nama);

      axios.post('http://localhost/horusreza/backend/api/create_user.php', params)
        .then(() => {
          alert('Registrasi berhasil!');
          this.login(); 
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan saat registrasi');
        });
    },
    login() {
      const params = new URLSearchParams();
      params.append('username', this.username);
      params.append('password', this.password);

      axios.post('http://localhost/horusreza/backend/api/login.php', params)
        .then(response => {
          if (response.data.status === 'success') {
            alert('Login berhasil!');
            this.$router.push('/dashboard');
          } else {
            alert('Login gagal: ' + response.data.message);
          }
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan saat login');
        });
    }
  }
};
</script>


<style scoped>
.register-container {
  max-width: 400px;
  margin: 50px auto;
  padding: 24px;
  background: #fdfdfd;
  border: 1px solid #ccc;
  border-radius: 10px;
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
button {
  width: 100%;
  padding: 10px;
  border: none;
  color: white;
  background-color: #007bff;
  border-radius: 5px;
  cursor: pointer;
}
button:hover {
  background-color: #0056b3;
}
</style>
