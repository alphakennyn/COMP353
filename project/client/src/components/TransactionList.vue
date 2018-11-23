<template>
  <table class="transaction-list">
    <h3>Transactions</h3>
    <tbody v-for='transaction in transactions' :key='transaction.accountNumber'>
      <Transaction :transaction='transaction'/>    
    </tbody>
  </table>
</template>

<script>
import Account from '@/components/Transaction.vue'

export default {
  name: 'TransactionList',
  components: {
    Account
  },
  props: {
    clientId: Number,
  },
  data() {
    return {
      transactions: []
    }
  },
  methods: {
    
  },
  mounted: function() {
    this.$http
      .get(`${process.env.VUE_APP_API_PATH}/accounts?user_id=${this.clientId}`)
      .then(response => {
        this.accounts = response.data.user_accounts;
      })
      .catch(err => {
        alert('uh oh.. no account found');
      });
  },
};
</script>
