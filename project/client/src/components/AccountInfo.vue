<template>
  <div class="account-info">
    <div class="item" v-for="(item, keyValue) in data" :key="keyValue">
      <span v-if="keyValue != 'isNotified'"><strong>{{keyValue}}</strong>: {{data[keyValue]}}</span>
      <span v-else ><strong>{{keyValue}}</strong>:{{editToggle}}
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
</template>

<script>
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
  },
  beforeDestroy: function() {
    if(this.originalEdit != this.editToggle){
      const isNotified = this.editToggle;// ? '1' : '0';
      const data = {
        cid: this.client,
        isNotified,
        accountNumber: this.data.accountNumber
      };

      this.$http.put(`${process.env.VUE_APP_API_PATH}/accounts/`, data).then((result) => {        
        console.log(result.data);
        if(result.data) {
          console.log(result.data);
          this.updateAccountList(result.data);
        }
      })
    }
  }
};
</script>

<style scoped lang="scss">
.account-info {
    .view {
      border-color: transparent;
      background-color: initial;
      color: initial;
    }
    .item {
      padding: 5px 10px 5px 0px;
    }
}
</style>
