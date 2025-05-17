<template>
  <div class="dashboard-container">
  <div class="header">
    <h1>Dashboard ({{ filteredUsers.length }} Users)</h1>
    <button class="add-user-btn" @click="goToRegister">
      + Tambah User
    </button>
  </div>


    <!-- 🔍 Search Input -->
    <input
      type="text"
      v-model="searchTerm"
      placeholder="Cari berdasarkan username, email, atau nama..."
      class="search-input"
    />

    <!-- ⏳ Loading Info -->
    <p v-if="loading" class="loading-text">Mengambil data user...</p>

    <!-- Desktop Table -->
    <table class="user-table" v-if="isDesktop && !loading">
      <thead>
        <tr>
          <th>Username</th>
          <th>Email</th>
          <th>Nama</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="user in filteredUsers" :key="user.id">
          <td>{{ user.username }}</td>
          <td>{{ user.email }}</td>
          <td>{{ user.nama }}</td>
          <td>
            <button @click="editUser(user.id)">Update</button>
            <button @click="deleteUser(user.id)">Delete</button>
          </td>
        </tr>
      </tbody>
    </table>

    <!-- Mobile Card View -->
    <div class="user-cards" v-else-if="!loading">
      <div class="user-card" v-for="user in filteredUsers" :key="user.id">
        <p><strong>Username:</strong> {{ user.username }}</p>
        <p><strong>Email:</strong> {{ user.email }}</p>
        <p><strong>Nama:</strong> {{ user.nama }}</p>
        <div class="card-actions">
          <button @click="editUser(user.id)">Update</button>
          <button @click="deleteUser(user.id)">Delete</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';
import Swal from 'sweetalert2';

export default {
  data() {
    return {
      users: [],
      isDesktop: true,
      searchTerm: '',
      loading: false
    };
  },
  computed: {
    filteredUsers() {
      if (!this.searchTerm) return this.users;
      const keyword = this.searchTerm.toLowerCase();
      return this.users.filter(user =>
        user.username.toLowerCase().includes(keyword) ||
        user.email.toLowerCase().includes(keyword) ||
        user.nama.toLowerCase().includes(keyword)
      );
    }
  },
  methods: {
    getUsers() {
      this.loading = true;
      axios.get('http://localhost/horusreza/backend/api/get_users.php')
        .then(response => {
          this.users = response.data;
        })
        .catch(error => {
          console.error(error);
          alert('Terjadi kesalahan saat mengambil data user');
        })
        .finally(() => {
          this.loading = false;
        });
    },
    editUser(id) {
      this.$router.push(`/dashboard/update/${id}`);
    },
    deleteUser(id) {
      Swal.fire({
        title: 'Yakin ingin menghapus?',
        text: 'Data user akan dihapus permanen!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal',
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6'
      }).then((result) => {
        if (result.isConfirmed) {
          axios.delete(`http://localhost/horusreza/backend/api/delete_user.php?id=${id}`)
            .then(() => {
              Swal.fire('Dihapus!', 'User berhasil dihapus.', 'success');
              this.getUsers();
            })
            .catch(error => {
              console.error(error);
              Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus user.', 'error');
            });
        }
      });
    },
    goToRegister() {
    this.$router.push('/register');
  },
    handleResize() {
      this.isDesktop = window.innerWidth >= 768;
    }
  },
  mounted() {
    this.getUsers();
    this.handleResize();
    window.addEventListener('resize', this.handleResize);
  },
  beforeUnmount() {
    window.removeEventListener('resize', this.handleResize);
  }
};
</script>

<style scoped>
.dashboard-container {
  width: 95%;
  margin: 20px auto;
  padding-bottom: 40px;
}
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  flex-wrap: wrap;
  margin-bottom: 10px;
}
.add-user-btn {
  padding: 8px 14px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}
.add-user-btn:hover {
  background-color: #0056b3;
}
.search-input {
  width: 100%;
  padding: 10px;
  margin-bottom: 16px;
  border: 1px solid #ccc;
  border-radius: 6px;
}
.loading-text {
  text-align: center;
  font-style: italic;
  margin-bottom: 16px;
}

/* Desktop Table */
.user-table {
  width: 100%;
  border-collapse: collapse;
}
.user-table th,
.user-table td {
  border: 1px solid #ccc;
  padding: 10px;
  text-align: left;
}
.user-table button {
  margin-right: 5px;
  padding: 6px 10px;
  border: none;
  background-color: #f0f0f0;
  cursor: pointer;
}
.user-table button:hover {
  background-color: #ddd;
}

/* Mobile Cards */
.user-cards {
  display: flex;
  flex-direction: column;
  gap: 16px;
}
.user-card {
  border: 1px solid #ccc;
  border-radius: 8px;
  padding: 16px;
  background-color: #f9f9f9;
}
.card-actions {
  margin-top: 12px;
}
.card-actions button {
  margin-right: 8px;
  padding: 6px 10px;
  border: none;
  border-radius: 4px;
  background-color: #e2e6ea;
  cursor: pointer;
}
.card-actions button:hover {
  background-color: #ced4da;
}

@media (max-width: 767px) {
  .user-table {
    display: none;
  }
}
</style>
