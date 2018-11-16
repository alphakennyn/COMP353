<template>
  <div class="hello">
    <h1>{{ name }}</h1>
    <p>
      For guide and recipes on how to configure / customize this project,<br>
      check out the
      <a href="https://cli.vuejs.org" target="_blank" rel="noopener">vue-cli documentation</a>.
    </p>
    <button @click="clickButton()"> </button> <br>
    <button @click="apiCall()">api call</button>
     <!-- {{todos}} -->
     <div v-for="t in todos" :key="t.id">
       <p>{{t.name}}</p>
      </div>
      {{todos}}
  
      <input v-model.trim="test">
      {{test}}
      <button type="email" @click="submit()">SUBMITTTT</button>
  </div>
</template>

<script>
export default {
  name: "HelloWorld",
  data() {
    return {
      name: "chris",
      names: ["chris", "kenny", "chris", "ben", "admin"],
      todos: [],
      test: ""
    };
  },
  props: {
    msg: String
  },
  methods: {
    clickButton: function() {
      this.name = "johnny";
    },
    apiCall: function() {
      this.$http.get(`${process.env.VUE_APP_API_PATH}/clients`).then(
        response => {
          console.log(response.data);
        },
        error => {
          console.error(error);
        }
      );
    },
    submit: function() {
      if (this.test == "") {
        alert("inpurt submit");
      }
    }
  }
};
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped lang="scss">
h3 {
  margin: 40px 0 0;
}
ul {
  list-style-type: none;
  padding: 0;
}
li {
  display: inline-block;
  margin: 0 10px;
}
a {
  color: #42b983;
}
</style>