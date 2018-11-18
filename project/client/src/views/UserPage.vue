<template>
  <div class="client">
    <div class="container">
      <div class="client__header">
        <div>
          <h1>BANK OF ABCJK</h1>
        </div>
        <div>
          <h3 v-if="clientData.fullName != ''">Hi, {{clientData.fullName}}!<br>
            <span class="info"><a @click="showClient()">see client info</a></span>
            <modal name="showClientInfo">
              <ClientInfo :data="clientData"/>
            </modal>
          </h3>
        </div>
      </div>
      <div class="client__content">

        <div class="client__accounts">
          <div>
            Select your account <br>
            <select v-model="selectAccount" class="select">
              <option v-for='(account, index) in accounts'
                      :value='account'
                      :key='index'>
                      {{account.accountType}} #{{account.accountNumber}}
              </option>
            </select> <br>
            <button @click="showAdd()">add a new account?</button>
            <modal name="showAddAccount">
              <AddAccountForm :clientId='parseInt(id)' @clicked="onClickAdd"/>
            </modal>
          </div>
        </div>

        <div class="menu">
          <AccountMenu v-if="Object.keys(selectAccount).length !== 0"
                       :toggleMenu='toggleMenuHandler'/>
        </div>

        <div>
          {{selectMenu}}
        </div>


      </div>
    </div>

  </div>
</template>

<script>
import AddAccountForm from "@/components/AddAccountForm.vue";
import AccountMenu from "@/components/AccountMenu.vue";
import ClientInfo from "@/components/ClientInfo.vue";

export default {
  name: "UserPage",
  components: { AddAccountForm, AccountMenu, ClientInfo },
  props: {
    id: String
  },
  data() {
    return {
      selectMenu: "",
      selectAccount: {},
      clientData: {},
      accounts: []
    };
  },
  methods: {
    showClient: function() {
      this.$modal.show("showClientInfo");
    },
    hideClient: function() {
      this.$modal.hide("showClientInfo");
    },
    showAdd: function() {
      this.$modal.show("showAddAccount");
    },
    hideAdd: function() {
      this.$modal.hide("showAddAccount");
    },
    onClickAdd: function(value) {
      console.log(value);
      
      // TODO add the value to the accounts
      this.hideAdd();
    },
    toggleMenuHandler: function(item) {
      this.selectMenu = item;
    }
  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/clients?id=${this.id}`)
      .then(
        response => {
          this.clientData = response.data.clients[0];
          console.log(this.clientData);
        },
        error => {
          alert("Something went wrong");
        }
      );
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/accounts?user_id=${this.id}`)
      .then(response => {
        this.accounts = response.data.user_accounts;
        console.log(this.accounts);
      })
      .catch(err => {
        alert("uh oh.. no account found");
      });
  }
};
</script>

<style lang="scss" scoped>
.client {
  &__header {
    display: flex;
    justify-content: space-between;
  }
  &__accounts {
    display: flex;
    .select {
      font-size: 1em;
    }
  }
}
.info {
  float: right;
  color: green;
}
</style>
