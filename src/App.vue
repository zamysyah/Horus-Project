<template>
  <NavBar v-if="showNavbar" />
  <router-view />
</template>

<script>
import NavBar from './components/NavBar.vue';

export default {
  name: 'App',
  components: { NavBar },
  computed: {
    showNavbar() {
      // Sembunyikan navbar di route login dan register
      return !['/login', '/register'].includes(this.$route.path);
    }
  }
};
</script>
