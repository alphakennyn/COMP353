<template>
  <div class="e-transfer">
    E-transfer (send money)
    <div class="item">Current balance {{data.balance}}</div>
    <div class="item warning">{{warning}}</div>
    <br>
    <div class="item">
      <label>Enter recipient's email</label><br>
      <input placeholder="Enter account number for e-transfer" v-model="recipientAccountNumber"/><br>
      <label>Enter amount to send</label><br>
      <input placeholder="Enter amount to send" type="number" v-model="transferAmount" />
    </div>
    <button v-if="canSend" class="item" @click="sendMoula()">Send</button>
  </div>
</template>

<script>
export default {
  name: "e-transfer",
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
        console.log(this.canSend);
        if(transferAmount > 0) {
          this.canSend = true;
        } else {
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
      }

      console.log(data);
      this.$http.post(`${process.env.VUE_APP_API_PATH}/transfer/`, data).then(result => {
        console.log(JSON.stringify(result, null ,2));
      }).catch(err =>{
        console.log(JSON.stringify(err, null ,2));
      })
    }
  },
};
</script>

<style scoped lang="scss">
.e-transfer {
  // .item {
  //   position: relative;
  //   height: 10px;
  //   margin-bottom: 10px;

  //   input {
  //     width: 40%
  //   }

  //   &.warning {
  //     color: red;
  //   }
  // }
}
</style>
