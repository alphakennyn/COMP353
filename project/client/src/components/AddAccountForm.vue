
<template>
  <div class="account-form">
    <div class='grid-left'>
      <h3>Create Account</h3>
      <label>Select Account type: </label>
      <select v-model="newAccount.accountType">
        <option v-for='(account, keyValue) in accounts' :value='keyValue' :key='keyValue' >{{keyValue}}</option>
      </select>

      <div v-if='accounts[newAccount.accountType]'>
        <!-- <label>Interest rate: </label> -->
        <p>Interest percentage Charge: {{dictionary[newAccount.accountType].percentCharge }}</p>
        <p>Service type: {{dictionary[newAccount.accountType].serviceType }}</p>
      </div>

      <div v-if='accounts[newAccount.accountType]'>
        <!-- <label>Charge plan: </label> -->
        <p>Charge per transaction: {{dictionary[newAccount.accountType].charge }}</p>
        <p>Plan limit: {{dictionary[newAccount.accountType].planlimit }}</p>
      </div>
    </div>
    <div class='grid-right'>
      <div v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].minBalance'>
        <label>Enter minimum balance: </label>
        <input  placeholder="min balance" v-model.trim="newAccount.minBalance"/>
      </div>

      <div v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].businessNumber'>
        <label>Enter business number: </label>
        <input  placeholder="Business Number" v-model.trim="newAccount.businessNumber"/>
      </div>

      <div v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].taxId'>
        <label>Enter Tax id: </label>
        <input placeholder="Tax Id ?" v-model.trim="newAccount.taxId"/>
      </div>

      <div v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].creditLimit' >
        <label>Enter credit limit: </label>
        <input placeholder="Credit Limit" v-model.trim="newAccount.creditLimit"/>
      </div>

      <div v-if='accounts[newAccount.accountType] && accounts[newAccount.accountType].currency'>
        <label>Select currency: </label>
        <select v-model="newAccount.currency">
          <option v-for='(currency, keyValue) in availableCurrency' :value='currency' :key='keyValue' >{{currency}}</option>
        </select>
      </div>

      <div v-if='accounts[newAccount.accountType]'>
        <button  @click='submit()'>Create Account</button>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'AccAccountForm',
  data() {
    return {
      chargeplanList: [], //http get
      investmentRateList: [], //http get
      accountType: 'Debit',
      newAccount: {
        cid: this.clientId,
        accountType: '',
        cpid: 1,
        irid: 1,
        balance: 0,
        transactionPerMonth: 0,
        maxPerDay: 0,
        minBalance: null,
        businessNumber: null,
        taxId: null,
        creditLimit: null,
        currency: 'CAD'
      },
      accounts: {
        Business: {
          minBalance: true,
          businessNumber: true,
          taxId: true,
          creditLimit: false,
          currency: false,
        },
        Checking: {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
          currency: false,
        },
        "Credit Card": {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: true,
          currency: false,
        },
        "Foreign Corrency": {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
          currency: true,
        },
        Insurance: {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
          currency: false,

        },
        Investment: {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
          currency: false,

        },
        'Line of Credit': {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: true,
          currency: false,

        },
        'Savings': {
          minBalance: true,
          businessNumber: false,
          taxId: false,
          creditLimit: false,
          currency: false,
        }
      },
      availableCurrency: [
        'AUD',
        'CAD',
        'EUR',
        'GBP',
        'USD',
      ]
    }
  },
  props: {
    toggleAccountForm: Boolean,
    clientId: Number,
    dictionary: Object,
  },
  methods: {
    submit: function() {
      this.$http.post(`${process.env.VUE_APP_API_PATH}/accounts/`, this.newAccount).then(result => {
        this.$emit('clicked', result.data)
      })
    },
  },
  mounted: function() {
    console.log('from addform:', this.dictionary);
  }
};
</script>

<style scoped lang='scss'>
.account-form {
   display: flex;
  // width: 50%;
  text-align: center;
  // .grid-left {
    
  // }
  .grid-right {
    margin-top: 20px;
    margin-left: 20%;
  }
}

</style>
