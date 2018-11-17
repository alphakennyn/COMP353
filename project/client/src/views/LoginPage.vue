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
      this.$http.post(`${process.env.VUE_APP_API_PATH}/login/`, data).then(
        response => {
          if (response.data.login) {
            this.$router.push({path: `/user/${response.data.id}`});
          } else { 
            throw new Error('Invalid user/pass');
          }
      }).catch(err => {
        console.log(err);
        alert('Error', err.message);
      });
    }
  }
}
</script>
