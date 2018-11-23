<template>
  <div id="app">
<<<<<<< HEAD
    <div id="nav">
      <router-link to="/">User</router-link> |
      <router-link to="/admin">Admin</router-link>
    </div>
    <router-view/>
=======
    <router-link v-if="authenticated" to="/login" v-on:click.native="logout()" replace>Logout</router-link>
    <router-view @authenticated="setAuthenticated" />
>>>>>>> 718a2aa8682ac3889526c2181430764c8118f102
  </div>
</template>

<script>

export default {
  name: 'app',
  data() {
    return {
      authenticated: false
    }
  },
  mounted() {
    if (!this.authenticated) {
      this.$router.replace({ name: 'login' })
    }
  },
  methods: {
    setAuthenticated(status) {
      this.authenticated = status
    },
    logout() {
      this.authenticated = false;
    }
  }
}
</script>


<style lang="scss">
@import 'vendor/bootstrap-grid.min.css';
#app {
  font-family: 'Avenir', Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}
#nav {
  padding: 30px;
  a {
    font-weight: bold;
    color: #2c3e50;
    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
a {
  &:hover {
    cursor: pointer;
  }
}
</style>
