<template>
  <NewCompany/>
</template>

<script>
import NewCompany from './components/NewCompany.vue'

export default {
  name: 'App',
  components: {
    NewCompany
  }
}
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}
</style>
