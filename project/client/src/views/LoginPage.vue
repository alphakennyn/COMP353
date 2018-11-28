<template>
  <div class="container login">
    <span class="title">Welcome to ABCJK banking online solution!</span>
    <h2>Login</h2>
    <div v-if="!isEmployee">
      <h3>Enter your client number</h3>
      <input class="login__inputs" type='string' v-model.trim="clientId">
    </div>
    <div v-else>
      <h3>Enter your employee id</h3>
      <input class="login__inputs" type='string' v-model.trim="employeeId">
    </div>
    <h3>Enter your password</h3><input class="login__inputs" type='password' v-model.trim="password"> <br>
    <button type='submit' @click="login()">Login</button> <br><br>
    <input type="checkbox" v-model="isEmployee"> Employee?
  </div>
</template>

<script>
export default {
  name: "LoginPage",
  data() {
    return {
      isEmployee: false,
      clientId: "",
      password: "",
      employeeId: ""
    };
  },
  methods: {
    login: function() {
      const typeToCheck = this.isEmployee ? this.employeeId : this.clientId;
      if (this.password == ''|| this.typeToCheck == '') {
        alert('Please enter the correct fields.')
        return;
      }
      if (this.isEmployee) {
        const data = {
          employeeId: this.employeeId,
          password: this.password,
          type: "employee"
        };
        this.$http
          .post(`${process.env.VUE_APP_API_PATH}/login/`, data)
          .then(response => {
            if (response.data.login) {
              this.$emit("authenticated", true);
              this.$session.start();
              this.$session.set('id', data.employeeId);
              this.$router.replace({ path: `/employee/${data.employeeId}` });
            } else {
              throw new Error("Invalid user/pass");
            }
          })
          .catch(err => {
            alert(`Error: ${err.message}`);
          });
      } else {
        const data = {
          cardNumber: this.clientId,
          password: this.password,
          type: "client"
        };
        this.$http
          .post(`${process.env.VUE_APP_API_PATH}/login/`, data)
          .then(response => {
            if (response.data.login) {
              this.$emit("authenticated", true);
              this.$session.start();
              this.$session.set('id', response.data.id);
              this.$router.push({ path: `/user/${response.data.id}` });
            } else {
              throw new Error("Invalid user/pass");
            }
          })
          .catch(err => {
            alert(`Error: ${err.message}`);
          });
      }
    }
  }
};
</script>

<style lang="scss" scoped>
.login {
  background-color: #dfe3e8;
  padding: 100px;
  margin-top: 10%;
  .title {
    font-size: 2rem;
    font-weight: bold;
  }
  &__inputs {
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
