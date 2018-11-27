<template>
  <div class="transfer-money">
    Transfer Money to your other accounts
    <div class="item">Current balance {{newData.balance}}</div>
    <div class="item">Transactions left: {{newData.transactionsLeft}} / {{newData.transactionsPerMonth}}</div>
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
      <p v-if="willBeCharged">Charge fee: {{dictionary[newData.accountType].charge}} $</p>
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
      newData: JSON.parse(JSON.stringify(this.data)),
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
        const balance = parseInt(this.newData.balance);

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
        if(!!this.newData.minBalance) {
            if ((balance - transferAmount) < parseInt(this.newData.minBalance)) {
              this.warning =  `You can't send money that reduces your balance to less than your min balance of ${this.newData.minBalance}`;
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
        senderAccountNumber: this.newData.accountNumber,
        recipientAccountNumber: this.recipientAccountNumber,
        amount: this.transferAmount,
        charged: this.willBeCharged ? String(this.dictionary[this.newData.accountType].charge) : '0',
        transferType: 'Transfer',
      }

      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        if('error' in result.data) {
          throw result.data.error;
        }

        alert(`Transfered ${this.transferAmount} to #${this.recipientAccountNumber}`);
        // this.data.balance = result.data.balance;
        this.newData = result.data;
        if (parseInt(this.newData.transactionsLeft) <= 0) {
          this.willBeCharged = true;
          this.warning = `You've passed you're transactions limit and will be charged and additional ${this.dictionary[this.newData.accountType].charge}$ CAD`
        } else {
          this.clearForm();
        }
       // this.$emit('transferUpdated', result.data)
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
    if (parseInt(this.newData.transactionsLeft) <= 0) {
      this.willBeCharged = true;
      this.warning = `You've passed you're transactions limit and will be charged and additional ${this.dictionary[this.newData.accountType].charge}$ CAD`
    }
  },
  computed: {
    totalToSend: function() {
      let total = parseFloat(this.transferAmount) ;
      if(this.willBeCharged) {
        total += parseFloat(this.dictionary[this.newData.accountType].charge);
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
