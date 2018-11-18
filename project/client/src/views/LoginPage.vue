<template>
  <div class="container login">
    <span class="title">Welcome to ABCJK banking online solution!</span>
    <h2>Login</h2>
    <h3>Enter your client number</h3><input type='string' v-model.trim="clientId"><br> 
    <h3>Enter your password</h3><input type='password' v-model.trim="password"> <br>
    <button type='submit' @click="login()">Login</button>
  </div>
</template>

<script>
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
            this.$emit("authenticated", true);
            this.$router.replace({path: `/user/${response.data.id}`});
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

<style lang="scss" scoped>
.login {
  background-color: #DFE3E8;
  padding: 100px;
  margin-top: 10%;
  .title {
    font-size: 2rem;
    font-weight: bold;
  }
  input {
    width: 300px;
    height: 30px;
    font-size: 16px;
  }
  button {
    margin-top: 15px;
    height: 35px;
    width: 100px;
  }
}
</style>
