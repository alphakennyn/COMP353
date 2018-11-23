<template>
  <div class="transfer-money">
    Transfer Money to your other accounts
    <div class="item">Current balance {{data.balance}}</div>
    <div class="item warning">{{warning}}</div>
    <br>
    <div class="item">
      <label>Enter recipient's account number</label><br>
      <input placeholder="Enter account number for e-transfer" v-model="recipientAccountNumber"/><br>
      <label v-if="recipientAccountNumber != ''">Enter amount to send</label><br>
      <input v-if="recipientAccountNumber != ''" placeholder="Enter amount to send" type="number" v-model="transferAmount" />
    </div>
    <button v-if="canSend" class="item" @click="sendMoula()">Send</button>
  </div>
</template>

<script>
export default {
  name: "transfer-money",
  props: {
    data: Object
  },
  data() {
    return {
      recipientAccountNumber: '',
      transferAmount: 0,
      canSend: false,
      warning: null,
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
        recipientAccountNumber: this.recipientAccountNumber,
        amount: this.transferAmount,
        transferType: 'Transfer',
      }

      console.log(data);
      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        if('error' in result.data) {
          throw result.data.error;
        }
        this.data.balance = result.data.balance;
        this.recipientAccountNumber = '';
        this.transferAmount = 0;
      }).catch(err =>{
          alert(err);
      })
    }
  },
};
</script>

<style scoped lang="scss">
.transfer-money {

}
</style>
