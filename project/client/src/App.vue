<template>
  <div id="app">
    <router-link id="logout" v-if="authenticated" to="/login" v-on:click.native="logout()" replace><div>Logout</div></router-link>
    <router-view @authenticated="setAuthenticated" />
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
      this.$session.destroy()
      this.authenticated = false;
    }
  }
}
</script>


<style lang="scss">
@import 'vendor/bootstrap-grid.min.css';
body {
  // background-color: #82C7EB;
  margin: 0;
  background-color: #f4f4f4;
}
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
#logout{
  width:100%;
  text-align: right;
  div{
    background-color: #004f8f;
    padding: 10px 50px 0 0;
    color: white;
  }
}
a {
  &:hover {
    cursor: pointer;
  }
}
</style>
