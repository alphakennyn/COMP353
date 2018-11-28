<template>
  <div class="client">
    <div class="client__header">
        <div>
          <h1>BANK OF ABCJK</h1>
        </div>
        <div>
          <h3 sv-if="clientData.fullName != ''"><span style="color:white;">Hi, {{clientData.fullName}}!</span><br>
            <span class="info"><a @click="showClient()">see client info</a></span>
            <modal name="showClientInfo" height='auto'>
              <ClientInfo :data="clientData" :clientId='parseInt(id)'/>
            </modal>
          </h3>
        </div>
    </div>
    <div class="container">
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
            <modal class="bank-modal" height='auto' width='700px' :scrollable="true" name="showAddAccount">
              <AddAccountForm :clientId='parseInt(id)' :dictionary='planDictionary' @clicked="onClickAdd" :close="(data) => hideAdd(data)"/>
            </modal>
          </div>
        </div>
        <div class="menu">
          <AccountMenu v-if="Object.keys(selectAccount).length !== 0" @clickedMenu='toggleMenuHandler'/>
        </div>
        <div v-if="dataLoaded">
          <AccountInfo 
            v-if="selectMenu == 'info'" 
            :client='parseInt(id)'
            :data='selectAccount' 
            :updateAccountList="(newAccount) => updateAccountList(newAccount)" 
          />
          <TransactionList v-if="selectMenu == 'transactions'" :client='id' :acc='selectAccount'/>
          <TransferMoney v-if="selectMenu == 'transfer'" :data='selectAccount' :accounts="accounts" :dictionary="planDictionary" @transferUpdated='transferHandler'/>
          <PayBills v-if="selectMenu == 'pay'" :data='selectAccount' :payees="payeeList" />
          <ETransfer v-if="selectMenu == 'etransfer'" :data='selectAccount' :dictionary="planDictionary" />
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
import TransactionList from "@/components/TransactionList.vue";
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
    TransactionList,
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
      accounts: [],
      planDictionary: {},
      payeeList: [],
      dataLoaded: false,
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
      this.$modal.show("showAddAccount", {title: 'Create new account'});
    },
    hideAdd: function(data) {
      this.accounts = data;
      this.selectAccount = this.accounts[0];
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
    },
    updateAccountList: function(newAccountList) {
      console.log('UPDATING WITH', newAccountList)
      this.accounts = newAccountList;
      this.selectAccount = this.accounts[0];
    },
    fetchPayeeList: function() {
      // Get dictionary
      this.$http
        .get(`${process.env.VUE_APP_API_PATH}/payee/`)
        .then( response => {
          this.payeeList = Object.freeze(response.data.reduce((acc, val) => {
            acc[val.id] = val.payeeName;
            return acc;
          }, {}));
        }).catch(error => {
          alert(error);
        });
    },
    transferHandler: function(value) {
      this.selectAccount = value; 
    }
  },
  created() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/clients?id=${this.id}`)
      .then(
        response => {
          console.log(response)
          this.clientData = response.data.clients[0];
          this.planDictionary = response.data.plans.reduce((acc,val) => {
            acc[val.accountType] = val;
            return acc;
          }, {});
          this.$http
            .get(`${process.env.VUE_APP_API_PATH}/accounts?user_id=${this.id}`)
            .then(response => {

              this.accounts = response.data.user_accounts;
              this.selectAccount = this.accounts[0];
              this.fetchPayeeList();
              this.dataLoaded = true;
            })
            .catch(err => {
              alert("uh oh.. no account found");
            });
      }).catch(error => {
          alert(error);
      });
    // this.$http
    //   .get(`${process.env.VUE_APP_API_PATH}/accounts?user_id=${this.id}`)
    //   .then(response => {

    //     this.accounts = response.data.user_accounts;
    //     this.selectAccount = this.accounts[0];
    //     this.dataLoaded = true;
    //     this.fetchPayeeList();
    //   })
    //   .catch(err => {
    //     alert("uh oh.. no account found");
    //   });
  },
  watch: {
    selectAccount: function() {
      console.log(`You changed accounts ${this.selectAccount.accountNumber}`);
    },
    selectMenu: function() {
      console.log(`clicked ${this.selectMenu}`);
    }
  },
  beforeCreate() {
    if (!this.$session.get('id')) {
      this.$router.push('/')
    } else {
      this.$emit("authenticated", true);
    }
  },
};
</script>

<style lang="scss" scoped>
.client {
  background-color: #f4f4f4;

  &__header {
    display: flex;
    justify-content: space-between;
    background-color: #004f8f;
    padding: 0 50px;
    margin-bottom: 20px;
    h1{
      color: white;
    }
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
  color: rgb(0, 214, 0);
}

</style>
