<template>
  <div class="e-transfer">
    E-transfer (send money)
    <div class="item">Current balance {{data.balance}}</div>
    <div class="item warning">{{warning}}</div>
    <br>
    <div class="item">
      <label>Enter recipient's email</label><br>
      <input placeholder="Must be a valid email" v-model="recipientEmail"/><button @click="getAccountByEmail()">Search</button><br>
      <div v-if="!fetchingUser">
        <br>
        <label v-if="recipientAccounts.length > 0">Selected recipient account</label><br>
        <select v-if="recipientAccounts.length > 0" v-model="selectedRecipientAccount" class="select">
          <option v-for='(account, index) in recipientAccounts'
            :value='account.accountNumber'
            :key='index'>
            {{account.accountType}} #{{account.accountNumber}}
          </option>
        </select><br>
        <label v-if="selectedRecipientAccount != null">Enter amount to send</label><br>
        <input v-if="selectedRecipientAccount != null" placeholder="Enter amount to send" type="number" v-model="transferAmount" />
      </div>
      <Loader v-if="fetchingUser"/>
    </div>
    <button v-if="canSend" class="item" @click="sendMoula()">Send</button>
  </div>
</template>

<script>
import Loader from '@/components/Loader.vue';

export default {
  name: "e-transfer",
  components: {
    Loader,
  },
  props: {
    data: Object
  },
  data() {
    return {
      recipientEmail: '',
      canSend: false,
      recipientAccounts: [],
      selectedRecipientAccount: null,
      transferAmount: 0,
      warning: null,
      fetchingUser: false,
    }
  },
  watch: {
    transferAmount: function() {
        const transferAmount = parseInt(this.transferAmount);
        const balance = parseInt(this.data.balance);
        if(transferAmount > 0) {
          this.canSend = true;
        } else {
          this.warning = "Amount must be greater than 1";
          this.canSend = false;
        }

        if(transferAmount > balance) {
          this.warning =  'Cannot send more money than you have..';
          this.canSend = false;
          return
        }
        if(!!this.data.minBalance) {
            if ((balance - transferAmount) < parseInt(this.data.minBalance)) {
              this.warning =  `You can't send money that reduces your balance to less than your min balance of ${this.data.minBalance}`;
              this.canSend = false;
              return
            }
        }
        this.warning = null;
    }
  },
  methods: {
    sendMoula: function() {
      const data = {
        senderAccountNumber: this.data.accountNumber,
        recipientEmail: this.selectedRecipientAccount,
        amount: this.transferAmount,
      }
      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        if('error' in result.data) {
          throw result.data.error;
        }
        this.data.balance = result.data.balance;
        this.recipientEmail = '';
        this.transferAmount = 0;
      }).catch(err =>{
          alert(err);
      })
    },
    getAccountByEmail: function() {
      this.fetchingUser = true;
      this.$http.post(`${process.env.VUE_APP_API_PATH}/accounts?user_email="${this.recipientEmail}"`).then(result => {
        if('error' in result.data) {
          throw result.data.error;
        }
        console.log(result);
        this.recipientAccounts = result.data.user_accounts;
        this.fetchingUser = false;
        // this.data.balance = result.data.balance;
        // this.recipientEmail = '';
        // this.transferAmount = 0;
      }).catch(err =>{
          alert(err);
      })
    }
  },
};
</script>

<style scoped lang="scss">
.e-transfer {

}
</style>
