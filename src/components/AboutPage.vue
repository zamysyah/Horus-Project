<template>
    <div class="about-container">
      <h2>Tentang Aplikasi</h2>
      <p>Aplikasi ini dibuat untuk mengelola data pengguna menggunakan Vue.js sebagai frontend dan PHP/MySQL sebagai backend.</p>
      <p>Dikembangkan oleh: <strong>AHMAD SYAHREZA</strong></p>
    </div>
  </template>
  
  <script>
  export default {
    name: "AboutPage"
  };
  </script>
  
  <style scoped>
  .about-container {
    max-width: 600px;
    margin: 50px auto;
    padding: 24px;
    background-color: #f9f9f9;
    border-radius: 10px;
    border: 1px solid #ccc;
  }
  h2 {
    margin-bottom: 16px;
  }
  p {
    font-size: 16px;
    line-height: 1.6;
  }
  </style>
  