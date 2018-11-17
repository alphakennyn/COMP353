<template>
  <div class="User-Page">
    <AccountList v-bind:clientId='parseInt(id)' v-if='id > 0'/>
  </div>
</template>

<script>
// @ is an alias to /src
import AccountList from '@/components/AccountList.vue'

export default {
  name: 'UserPage',
  components: {
    AccountList
  },
  props: {
    id: String,
  },
  data() {
    return {
      clientData: {}
    }
  },
  mounted: function() {
    this.$http.get(`${process.env.VUE_APP_API_PATH}/clients?id=${this.id}`).then(
        response => {
          this.clientData = response.data;
        },
        error => {
          alert('Something went wrong');
        }
      );
  }
}
</script>
