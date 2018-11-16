<template>
  <div class="User-Page">
    <input type='number' v-model.trim="clientId">
    <AccountList v-bind:clientId='parseInt(clientId)' v-if='clientId > 0'/>
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
  data() {
    return {
      clientId: 0
    }
  },
}
</script>
