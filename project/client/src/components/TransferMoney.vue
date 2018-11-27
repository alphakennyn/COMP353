<template>
  <div class="transfer-money">
    Transfer Money to your other accounts
    <div class="item">Current balance {{data.balance}}</div>
    <div class="item">Transactions left: {{data.transactionsLeft}} / {{data.transactionsPerMonth}}</div>
    <div class="item warning">{{warning}}</div>
    <br>
    <div class="item">
      <label>Enter recipient's account number</label><br>
      <select v-model="recipientAccountNumber" class="select">
          <option v-for='(account, index) in accounts'
            v-if="account.accountType !== data.accountType"
            :value='account.accountNumber'
            :key='index'>
            {{account.accountType}} #{{account.accountNumber}}
          </option>
        </select><br>
      <label v-if="recipientAccountNumber != null">Enter amount to send</label><br>
      <input v-if="recipientAccountNumber != null" min="0" placeholder="Enter amount to send" type="number" v-model="transferAmount" />
    </div>
    <div class="item" v-if="recipientAccountNumber != null">
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
export default {
  name: "transfer-money",
  props: {
    data: Object,
    accounts: Array,
    dictionary: Object,
  },
  data() {
    return {
      recipientAccountNumber: null,
      transferAmount: 0,
      canSend: false,
      warning: null,
      willBeCharged: false,
    }
  },
  watch: {
    data: function () {
      this.clearForm()
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
    sendMoula: function() {
      const data = {
        senderAccountNumber: this.data.accountNumber,
        recipientAccountNumber: this.recipientAccountNumber,
        amount: this.transferAmount,
        charged: this.willBeCharged ? String(this.dictionary[this.data.accountType].charge) : '0',
        transferType: 'Transfer',
      }

      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        if('error' in result.data) {
          throw result.data.error;
        }

        alert(`Transfered ${this.transferAmount} to #${this.recipientAccountNumber}`);
        this.data.balance = result.data.balance;
        this.data = result.data;
        this.clearForm();
      }).catch(err =>{
          alert(err);
      })
    },
    clearForm: function() {
      this.recipientAccountNumber = null;
      this.transferAmount = 0;
      this.canSend = false;
      this.warning = null;
      this.willBeCharged = false;
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
.transfer-money {
  .item.warning {
    color: red;
  }
}
</style>
