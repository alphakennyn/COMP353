<template>
<div class="client">
  <div class="client__info">
    <span class="header">Information</span>
    <div class="item" v-for="(item, keyValue) in user" :key="keyValue">
      <strong>{{labels[keyValue]}}</strong>:
      <input type="text" v-model="user[keyValue]" :disabled="!isEditing || !allowToEdit.includes(keyValue)"
             :class="{view: !isEditing || !allowToEdit.includes(keyValue)}" />
    </div>
    <button @click="isEditing = !isEditing" v-if="!isEditing">Edit</button>
    <button @click="save" v-else-if="isEditing">Save</button>
    <button v-if="isEditing" @click="cancel">Cancel</button>
    <button @click="deleteClient()" >Delete</button>
  </div>
  <div class="client__pass">
    <span class="header">Change password</span>
    <div class="item">
      <strong>Old password: </strong> <input type="password" v-model="password.oldPass"/>
    </div>
    <div class="item">
      <strong>New password: </strong> <input type="password" v-model="password.newPass"/>
    </div>
    <button v-if="showPasswordBtn" @click="submitPassword">Submit</button>
  </div>
</div>
</template>

<script>
import swal from "sweetalert2";

export default {
  name: "client-info",
  props: {
    clientId: Number,
    data: Object
  },
  data() {
    return {
      user: this.data,
      isEditing: false,
      allowToEdit: ["phone", "email", "address"],
      labels: {},
      password: {
        id: this.clientId,
        oldPass: "",
        newPass: ""
      }
    };
  },
  methods: {
    save: function() {
      let emailValid = this.user["email"].match(
        /^([\w.%+-]+)@([\w-]+\.)+([\w]{2,})$/i
      );
      let phoneValid = this.user["phone"].match(
        /^\s*(?:\+?(\d{1,3}))?[-. (]*(\d{3})[-. )]*(\d{3})[-. ]*(\d{4})(?: *x(\d+))?\s*$/i
      );
      if (!emailValid) {
        alert("Invalid email");
        return;
      }
      if (!phoneValid) {
        alert("Invalid phone number");
        return;
      }
      this.user["id"] = this.clientId;
      this.$http
        .post(`${process.env.VUE_APP_API_PATH}/clients/`, this.user)
        .then(response => {
          delete this.user.id;
          if (response.data.hasOwnProperty("error")) {
            alert(response.data.error);
            this.cancel();
          } else {
            this.cachedUser = Object.assign({}, this.user);
            this.isEditing = false;
          }
        });
    },
    cancel: function() {
      this.user = Object.assign({}, this.cachedUser);
      this.isEditing = false;
    },
    submitPassword: function() {
      if (this.password.oldPass == this.password.newPass) {
        alert('Please choose a different password!');
        return;
      }
      this.$http
        .post(`${process.env.VUE_APP_API_PATH}/clients/`, this.password)
        .then(response => {
          if (response.data.hasOwnProperty("error")) {
            alert("Invalid password!");
          } else {
            this.password = {
              id: this.clientId,
              oldPass: "",
              newPass: ""
            };
          }
        });
    },
    deleteClient: function() {
      swal({
        title: "Are you sure?",
        text: "You won't be able to revert this!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, delete it!"
      }).then(result => {
        if (result.value) {
          const data = {id: this.clientId};
          this.$http
            .post(`${process.env.VUE_APP_API_PATH}/delclient/`, data)
            .then(response => {
              if (response.data.result) {
                this.$router.replace({ path: `/` });
              } else {
                throw new Error(response.data.message)
              }
            })
            .catch(error => {
              swal({
                type: 'warning',
                text: error,
              });
            });
        }
      });
    }
  },
  mounted() {
    this.labels = {
      fullName: "Full name",
      category: "Category",
      phone: "Phone Number",
      email: "Email",
      address: "Address",
      joinDate: "Join date",
      DOB: "Date of Birth",
      cardNumber: "Card Number"
    };
    this.cachedUser = Object.assign({}, this.data);
  },
  computed: {
    showPasswordBtn: function() {
      return this.password.newPass !== "" && this.password.oldPass !== "";
    }
  }
};
</script>

<style scoped lang="scss">
.client {
  font-size: 16px;
  margin: 30px;
  &__info {
    .view {
      border-color: transparent;
      background-color: initial;
      color: initial;
    }
    .item {
      padding: 5px 10px 5px 0px;
    }
    input {
      width: 300px;
      height: 30px;
      font-size: 16px;
    }
  }
  &__pass {
    margin-top: 15px;
  }
}
.header {
  font-size: 20px;
  color: green;
}
button {
  padding: 5px 25px;
  margin-top: 15px;
  margin-right: 15px;
  font-size: 14px;
}
</style>
