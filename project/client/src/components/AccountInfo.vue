<template>
  <div class="account-info">
    <div class="account-data">
      <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
        <span v-if="keyValue != 'isNotified'"><strong>{{keyValue}}</strong>: {{data[keyValue]}}</span>
        <span v-else ><strong>{{keyValue}}</strong>:
          <toggle-button 
            color="#82C7EB"
            :value="editToggle"
            :sync="true"
            v-model="editToggle"
            :labels="{checked: 'Yes', unchecked: 'No'}"
          />
        </span>
      </div>
    </div>
    <div class="vl"></div>
    <div class="account-buttons">
      <button class="account-modify-button" @click="updateAccount()">Update</button>
      <button class="account-delete-button" @click="deleteAccount()">Delete</button>
    </div>
  </div>
</template>

<script>
import swal from "sweetalert2";

export default {
  name: "account-info",
  data() {
    return {
      originalEdit: false,
      editToggle: false
    }
  },
  props: {
    data: Object,
    isEditing: Boolean,
    updateAccountList: Function,
    client:  Number
  },
  created: function(){
    this.setBooleanData();
  },
  watch: {
    data: function() {
      this.originalEdit = false;
      this.editToggle = false;
      this.setBooleanData();
    }
  },
  methods: {
    setBooleanData: function() {
      const dataClone = {...this.data};

      this.originalEdit = this.bitToBoolean(dataClone.isNotified);
      this.editToggle = this.bitToBoolean(dataClone.isNotified);
    },
    booleanToBit: function(booleanVal){
      return booleanVal ? "1" : "0";
    },
    bitToBoolean: function(bitVal){
      return bitVal === "1" ? true : false;
    },
    updateAccount: function() {
      if(this.originalEdit != this.editToggle){
        const isNotified = this.editToggle;// ? '1' : '0';
        const data = {
          cid: this.client,
          isNotified,
          accountNumber: this.data.accountNumber
        };

        this.$http.post(`${process.env.VUE_APP_API_PATH}/accounts/`, data).then((result) => {        
          if(result.data) {
            swal('Update complete!');
            this.updateAccountList(result.data);
          }
        }).catch(err => {
          swal('Update account failed!');
        })
      }
    },
    deleteAccount: function() {
      const data = {
        accountNumber: this.data.accountNumber,
        cid: this.client
      };

      this.$http.post(`${process.env.VUE_APP_API_PATH}/delaccount/`, data).then((result) => {
        if(result.data.length <= 0 ) {
          throw new Error("You deleted your last account... Why would you do that?");
        }
        this.updateAccountList(result.data)
        swal('Delete account complete');
      }).catch(err => {
        swal(err);
      })
    }
  },
  beforeDestroy: function() {
    this.updateAccount();
  }
};
</script>

<style scoped lang="scss">
.account-info {
    display: flex;

    .view {
      border-color: transparent;
      background-color: initial;
      color: initial;
    }

    .account-data {
      width: 50%;

      .item {
        padding: 5px 10px 5px 0px;
      }
    }
    .account-buttons {
      // display: flex;

      .account-delete-button {
        background-color: red;
        color: white;
        padding:10px;
      }
      .account-modify-button {
        background-color: rgb(85, 147, 189);
        color: white;
        padding:10px;
      }

    }
    .vl {
      width: 5%;
      border-left: 1px solid #004f8f;
      height: inherit;
      position: relative;
    }
}
</style>
