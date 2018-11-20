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
            <modal name="showClientInfo" height='auto'>
              <ClientInfo :data="clientData" :clientId='parseInt(id)'/>
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
          <AccountMenu v-if="Object.keys(selectAccount).length !== 0" @clickedMenu='toggleMenuHandler'/>
        </div>
        <div>
          <AccountInfo v-if="selectMenu == 'info'" :data='selectAccount'/>
          <TransactionHistory v-if="selectMenu == 'transactions'"/>
          <TransferMoney v-if="selectMenu == 'transfer'"/>
          <PayBills v-if="selectMenu == 'pay'"/>
          <ETransfer v-if="selectMenu == 'etransfer'" :data='selectAccount'/>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import AddAccountForm from "@/components/AddAccountForm.vue";
import AccountMenu from "@/components/AccountMenu.vue";
import ClientInfo from "@/components/ClientInfo.vue";
import AccountInfo from "@/components/AccountInfo.vue";
import TransactionHistory from "@/components/TransactionHistory.vue";
import TransferMoney from "@/components/TransferMoney.vue";
import PayBills from "@/components/PayBills.vue";
import ETransfer from "@/components/ETransfer.vue";

export default {
  name: "UserPage",
  components: {
    AddAccountForm,
    AccountMenu,
    ClientInfo,
    AccountInfo,
    TransactionHistory,
    TransferMoney,
    PayBills,
    ETransfer
  },
  props: {
    id: String
  },
  data() {
    return {
      selectMenu: "info",
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
    onClickMenu: function(value) {
      this.selectMenu = value;
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
        this.selectAccount = this.accounts[0];
        console.log(this.accounts);
      })
      .catch(err => {
        alert("uh oh.. no account found");
      });
  },
  watch: {
    selectAccount: function() {
      console.log(`You changed accounts ${this.selectAccount.accountNumber}`);
    },
    selectMenu: function() {
      console.log(`clicked ${this.selectMenu}`);
    }
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
