<template>
  <div class="User-Page">
    <input type='string' v-model.trim="clientId">
    <input type='string' v-model.trim="password">
    <button type='submit' @click="login()">Login</button>
  </div>
</template>

<script>
// @ is an alias to /src


export default {
  name: 'LoginPage',
  data() {
    return {
      clientId: '',
      password: ''
    }
  },
  methods: {
    login: function() {
      const data = {
        cardNumber: this.clientId,
        password: this.password
      }

      console.log({data});

      this.$http.post(`${process.env.VUE_APP_API_PATH}/login/`, data).then(
        response => {
          //console.log('response is',response);
          if (response.data.login ) {
            router.go('/user');

          } else {
            throw;
          }
      }).catch(err => {
        alert('wrong user/pass');
      });
    }
  }
}
</script>
