
<template>
  <div class="account-form">
    <div class='grid-left'>
      <h3>Create Account</h3>
      <label>Select Account type: </label>
      <select v-model="newAccount.accountType">
        <option v-for='(account, keyValue) in accounts' :value='keyValue' :key='keyValue' >{{keyValue}}</option>
      </select>
      <div v-if='accounts[newAccount.accountType]'>
        <label>Keep me notified: </label>
        <toggle-button 
          :value="false"
          color="#82C7EB"
          :sync="true"
          v-model="newAccount.isNotified"
          :labels="{checked: 'Yes', unchecked: 'No'}"
          />
      </div>
      <div v-if='accounts[newAccount.accountType]'>
        <!-- <label>Interest rate: </label> -->
        <p>Interest percentage Charge: {{dictionary[newAccount.accountType].percentCharge }}</p>
        <p>Service type: {{dictionary[newAccount.accountType].serviceType }}</p>
      </div>

      <div v-if='accounts[newAccount.accountType]'>
        <!-- <label>Charge plan: </label> -->
        <p>Charge per transaction: {{dictionary[newAccount.accountType].charge }}</p>
        <p>Plan limit: {{dictionary[newAccount.accountType].planLimit }}</p>
      </div>
      
    </div>
    <div v-if='accounts[newAccount.accountType]' class="vl"></div>

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
      //accountType: 'Debit',
      newAccount: {
        cid: this.clientId,
        accountType: '',
        cpid: 1,
        irid: 1,
        balance: 0,
        transactionsPerMonth: 0,
        transactionsLeft: 5,
        currency: 'CAD',
        isNotified: false,
        maxPerDay: 0,
        minBalance: null,
        businessNumber: null,
        taxId: null,
        creditLimit: null,
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
        "Foreign Currency": {
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
        'Line Of Credit': {
          minBalance: false,
          businessNumber: false,
          taxId: false,
          creditLimit: true,
          currency: false,

        },
        Savings: {
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
    close: Function,
  },
  methods: {
    submit: function() {
      //this.newAccount.minBalance && this.newAccount.businessNumber && this.newAccount.taxId && this.newAccount.creditLimit
      var errors = "";
      if((this.newAccount.accountType=="Business" || this.newAccount.accountType=="Foreign Currency" || this.newAccount.accountType=="Investment" || this.newAccount.accountType=="Savings") && !this.newAccount.minBalance){
        errors += "You need to input a mininum balance!\n";
      }
      if(this.newAccount.accountType=="Business"){
        if(!this.newAccount.businessNumber){
          errors += "You need to input a buisness number!\n";
        }
        if(!this.newAccount.taxId){
          errors += "You need to input a tax ID!\n";
        }
      }
      if((this.newAccount.accountType=="Credit Card" || this.newAccount.accountType=="Line Of Credit") && !this.newAccount.creditLimit){
        errors += "You need to input a credit limit!\n";
      }
      if(errors==""){
        //Set transaction limit per month
        this.newAccount.transactionsPerMonth = this.dictionary[this.newAccount.accountType].planLimit;
        //this.newAccount.isNotified = this.newAccount.isNotified ? 1 : 0;
        this.$http.post(`${process.env.VUE_APP_API_PATH}/accounts/`, this.newAccount).then(result => {
          console.log(result.data)
          if(result.data.error) {
            throw new Error('Error from server', result.data.error)
          }
        this.close(result.data.user_accounts);
        
        alert('New account added!')
        }).catch(err => {
          console.error(err);
        })
      } else {
        alert(errors);
      }
    },
  },
  watch: {
    dictionary: function() {
      console.log('Disctoinary', this.newAccount.accountType)
      console.log('Disctoinary', this.dictionary[this.newAccount.accountType])
    }
  },
  mounted: function() {
    console.log('from addform:', this.dictionary['Line Of Credit']);
  }
};
</script>

<style scoped lang='scss'>
.account-form {
  display: flex;
  padding: 5% 20px;
  text-align: justify;
  h3 {
    margin: 0px;
  }
  .grid-left {
    width: 50%;
  }
  .vl {
    border-left: 1px solid #82C7EB;
    height: inherit;
    position: relative;
  }
  .grid-right {
    padding-left: 20px;
    width: 55%;
    div {
      margin: 5% 0;
    }

    button {
      border-radius: 15px;
      border-color: #82C7EB;
      padding: 5%;
      transition: 300ms;
    }
  }
}

</style>
