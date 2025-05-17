<template>
  <nav class="navbar">
    <h2>🏬 Warehouse Admin</h2>
    <ul>
      <li><router-link to="/dashboard">Users</router-link></li>
      <li><router-link to="/home">Products</router-link></li>
      <li><button @click="logout">Logout</button></li>
    </ul>
  </nav>
</template>

<script>
import Swal from 'sweetalert2';

export default {
  methods: {
    logout() {
      Swal.fire({
        title: 'Logout Confirmation',
        text: "Are you sure you want to logout?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, logout',
        cancelButtonText: 'Cancel'
      }).then((result) => {
        if (result.isConfirmed) {
          // Clear stored login data
          localStorage.removeItem('token');
          localStorage.removeItem('user');

          // Redirect to login page
          this.$router.push('/login');

          Swal.fire(
            'Logged out!',
            'You have been logged out successfully.',
            'success'
          );
        }
      });
    }
  }
};
</script>

<style scoped>
.navbar {
  display: flex;
  justify-content: space-between;
  background-color: #2c3e50;
  padding: 15px 30px;
  color: white;
}
.navbar ul {
  display: flex;
  list-style: none;
  gap: 20px;
}
.navbar a {
  color: white;
  text-decoration: none;
}
.navbar a:hover {
  text-decoration: underline;
}
button {
  background: none;
  border: none;
  color: white;
  cursor: pointer;
  font: inherit;
  padding: 0;
}
button:hover {
  text-decoration: underline;
}
</style>
