<template>
  <div class="login-container">
    <h2>Login</h2>
    <form @submit.prevent="login" class="form">
      <input
        type="text"
        v-model="username"
        placeholder="Username"
        required
      />

      <div class="password-wrapper">
        <input
          :type="showPassword ? 'text' : 'password'"
          v-model="password"
          placeholder="Password"
          required
        />
        <!-- Ganti ikon dengan FontAwesome -->
        <span class="toggle" @click="togglePassword">
          <i :class="showPassword ? 'fas fa-eye-slash' : 'fas fa-eye'"></i>
        </span>
      </div>

      <button type="submit">Login</button>
    </form>

    <div class="register-link">
      <p>Belum punya akun?</p>
      <button @click="goToRegister">Register</button>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      username: '',
      password: '',
      showPassword: false
    };
  },
  methods: {
    togglePassword() {
      this.showPassword = !this.showPassword;
    },
    login() {
      if (this.username && this.password) {
        const params = new URLSearchParams();
        params.append('username', this.username);
        params.append('password', this.password);

        axios.post('http://localhost/horusreza/backend/api/login.php', params)
          .then(response => {
            if (response.data.status === 'success') {
              Swal.fire({
                title: 'Berhasil!',
                text: 'Login berhasil!',
                icon: 'success',
                confirmButtonText: 'Lanjut'
              }).then(() => {
                this.$router.push('/dashboard');
              });
            } else {
              Swal.fire({
                title: 'Login Gagal',
                text: response.data.message,
                icon: 'error'
              });
            }
          })
          .catch(error => {
            console.error(error);
            Swal.fire({
              title: 'Error',
              text: 'Terjadi kesalahan saat login',
              icon: 'error'
            });
          });
      } else {
        Swal.fire({
          title: 'Oops!',
          text: 'Harap isi semua kolom',
          icon: 'warning'
        });
      }
    },
    goToRegister() {
      this.$router.push('/register');
    }
  }
};
</script>

<style scoped>
.login-container {
  max-width: 400px;
  width: 90%;
  margin: 60px auto;
  padding: 30px;
  border: 1px solid #ccc;
  border-radius: 12px;
  background-color: #fdfdfd;
  box-shadow: 0 4px 10px rgba(0, 0, 0, 0.08);
  text-align: center;
}

h2 {
  margin-bottom: 20px;
  color: #333;
}

input {
  width: 100%;
  padding: 12px;
  margin-bottom: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
  font-size: 16px;
  box-sizing: border-box;
}

.password-wrapper {
  position: relative;
}

.password-wrapper input {
  width: 100%;
  padding-right: 40px; /* Beri ruang untuk ikon */
}

.toggle {
  position: absolute;
  top: 50%;
  right: 12px;
  transform: translateY(-50%);
  font-size: 18px;
  cursor: pointer;
  color: #555;
  user-select: none;
}

button {
  padding: 12px;
  width: 100%;
  background-color: #007bff;
  color: white;
  border: none;
  font-size: 16px;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.3s;
}

button:hover {
  background-color: #0056b3;
}

.register-link {
  margin-top: 24px;
}

.register-link p {
  margin-bottom: 8px;
  font-size: 14px;
}

.register-link button {
  background-color: #28a745;
  padding: 10px 20px;
  width: auto;
}

.register-link button:hover {
  background-color: #218838;
}

/* 📱 Responsive Design */
@media (max-width: 480px) {
  .login-container {
    margin: 30px auto;
    padding: 20px;
  }

  h2 {
    font-size: 20px;
  }

  input {
    font-size: 14px;
    padding: 10px;
  }

  button {
    font-size: 14px;
    padding: 10px;
  }

  .register-link button {
    font-size: 13px;
    padding: 8px 16px;
  }

  .toggle {
    font-size: 16px;
    right: 10px;
  }
}
</style>
