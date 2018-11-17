<template>
  <div class="account-list">
    <h3>Your account</h3>
    <div v-for='account in accounts' :key='account.accountNumber'>
      <Account :account='account'/>
    </div>
  </div>
</template>

<script>
import Account from '@/components/Account.vue'

export default {
  name: 'AccountList',
  components: {
    Account
  },
  props: {
    clientId: Number,
  },
  data() {
    return {
      accounts: []
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
