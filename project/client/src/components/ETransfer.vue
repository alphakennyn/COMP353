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
            :value='account'
            :key='index'>
            {{account.accountType}} #{{account.accountNumber}}
          </option>
        </select><br>
        <label v-if="selectedRecipientAccount != null">Enter amount to send</label><br>
        <input v-if="selectedRecipientAccount != null" min="0" placeholder="Enter amount to send" type="number" v-model="transferAmount" />
      </div>
      <Loader v-if="fetchingUser"/>
    </div>
    <div class="item" v-if="selectedRecipientAccount != null">
      <hr />
      <label><b>Summary transfer</b></label> 
      <p>Amount: {{transferAmount}} $</p>
      <p v-if="willBeCharged">Charge fee: {{dictionary[data.accountType].charge}} $</p>
      <b>Total: {{totalToSend}}</b>
      <hr />
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
    data: Object,
    dictionary: Object,
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
      willBeCharged: false,
    }
  },
  watch: {
    data: function () {
      this.clearForm();
    },
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
    clearForm: function() {
      this.canSend = false;
      this.selectedRecipientAccount = null;
      this.transferAmount = 0;
      this.warning = null;
      this.willBeCharged = false;
    },
    sendMoula: function() {
      const data = {
        senderAccountNumber: this.data.accountNumber,
        recipientAccountNumber: this.selectedRecipientAccount.accountNumber,
        amount: this.selectedRecipientAccount.accountType === 'Credit Card'? -1*this.transferAmount : this.transferAmount,
        charged: this.willBeCharged ? this.dictionary[this.data.accountType].charge : 0,
        transferType: 'e-transfer',
      }
      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        console.log(result)
        if('error' in result.data) {
          throw result.data.error;
        }
        alert(`Transfered ${this.transferAmount}$ to #${this.selectedRecipientAccount.accountNumber}`);

        this.data.balance = result.data.balance;


        this.recipientAccounts = [];
        this.selectedRecipientAccount = null;
        this.recipientEmail = '';


        this.clearForm();
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
        if (result.data.user_accounts.length <= 0) {
          throw new Error('Invalid email. Please try again');
        }
        
        this.recipientAccounts = result.data.user_accounts;
        this.fetchingUser = false;
      }).catch(err =>{
          alert(err);
      })
    }
  },
  mounted: function() {
    if (parseInt(this.data.transactionsLeft) <= 0) {
      this.willBeCharged = true;
      this.warning = `You've passed you're transactions limit and will be charged and additional ${this.dictionary[this.data.accountType].charge}$ CAD`
    }
  },
  computed: {
    totalToSend: function() {
      let total = parseInt(this.transferAmount) ;
      if(this.willBeCharged) {
        total += parseInt(this.dictionary[this.data.accountType].charge);
      }

      return total;
    }
  }
};
</script>

<style scoped lang="scss">
.e-transfer {
  .item.warning {
    color: red;
  }
}
</style>
