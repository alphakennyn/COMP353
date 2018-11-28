<template>
  <div class="pay-bills">
    Your bills
    <p>Current balance: {{data.balance}}$</p>
    <p>Transactions available: {{data.transactionsLeft}} / {{data.transactionsPerMonth}}</p>
    <p class="warning">{{warning}}</p>
    <p>Amount to pay:  {{amountSum}}$</p>
    <button v-if="canPay" @click="payBills()">Pay</button>
    <table class="bills-list">
      <thead>
        <tr>
          <th>Bill ID</th>
          <th>Amount to pay</th>
          <th>Remaining amount</th>
          <th>Payee</th>
          <th>Due Date</th>
          <th>Is paid</th>
          <th>Automatic Payments</th>
          <th>Select to Pay</th>
        </tr>
      </thead>
      <tbody v-for='bills in accountBills' :key='bills.id'>
        <Bill :billData='bills' :clickHandle="() => handleClick()"/>    
      </tbody>
    </table>
  </div>
</template>

<script>
import Bill from '@/components/Bill.vue'
import swal from "sweetalert2";

export default {
  name: "pay-bills",
  components: {
    Bill,
  },
  props: {
    data: Object,
    payees: Object,
  },
  data() {
    return {
      accountBills: [],
      canPay: false,
      amountSum: 0.0,
      warning: '',
    }
  },
  mounted: function() {
    this.getBills(this.data.accountNumber);
  },
  methods: {
    getBills: function(accountNumber) {
      this.$http.get(`${process.env.VUE_APP_API_PATH}/bills?accountNumber=${accountNumber}`).then(result => {
        console.table(result.data)
        if(result.data.length > 0) {  
          this.accountBills = result.data.map((value) => {
            return {
              id: value.billsId,
              amountToPay: value.MyPayeeAmount,
              totalAmount: value.billsAmount,
              payee: this.getPayeeName(value.payeeId),
              dueDate: value.dueDate,
              isPaid: this.bitToBool(value.isPaid),
              wantToPay: false,
              autoPay: value.autoPay
            }
          });
        } else {
          throw new Error("This account does not have any Bills associated to it.");
        }
      }).catch(err => {
        swal(err.message);
      })
    },
    getPayeeName: function(id) {
      return this.payees[id];
    },
    bitToBool: function(bitValue) {
      return bitValue === "1" ? true : false;
    },
    handleClick: function() {

      const copyArray = [...this.accountBills];
      const balance = parseFloat(this.data.balance);
      this.warning = '';
      this.amountSum = 0.0;

      copyArray.forEach(value => {
        if(value.wantToPay) {
          if(!this.canPay) {
            this.canPay = true;
          }
          this.amountSum += parseFloat(value.amountToPay);
        }
      });

      if(balance <= this.amountSum) {
        this.warning = "Can not exceed your current balance.";
        this.canPay = false;
      }

      if(!!this.data.minBalance) {
        console.log(this.data.minBalance)
        if ((balance - this.amountSum) < parseFloat(this.data.minBalance)) {
          this.warning =  `You can't send money that reduces your balance to less than your min balance of ${this.data.minBalance}`;
          this.canPay = false;
          return
        }
      }  
    },
    payBills: function() {
      const data = this.accountBills.reduce((acc, value) => {
        if(value.wantToPay) {
          acc.push({
            id: value.id,
            amount: value.amountToPay,
            accountNumber: this.data.accountNumber,
          });
        }
        return acc;
      }, [])

      this.$http.post(`${process.env.VUE_APP_API_PATH}/paybills/`, data).then(result => {
        if(result.data.result) {
          console.log(result.data);
          this.getBills(this.data.accountNumber);
          this.data = result.data.data;
        } else {
          throw new Error('Failed to pay bill')
        }
      }).catch(err => {
        swal(err)
      });
      console.table(data);

    },
    clearData: function() {
      this.accountBills = [];
      this.canPay = false;
      this.amountSum = 0.0;
      this.warning = '';
    }
  },
  watch: {
    data: function() {
      this.clearData();
      this.getBills(this.data.accountNumber);
    }
  }
};
</script>

<style scoped lang="scss">
.pay-bills {
  .warning {
    color: red;
  }
}
</style>
