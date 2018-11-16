<template>
  <div class="about">
    <h1>This is an about page</h1>
    <UserPage />
  </div>
</template>

<script>
import UserPage from '@/views/UserPage.vue'

export default {
    name: 'about',
  components: {
    UserPage
  }
}
</script>

