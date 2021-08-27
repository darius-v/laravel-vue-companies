<template>
  <NewCompany/>
    <HelloWorld />
</template>

<script>
import NewCompany from './components/NewCompany.vue'
import HelloWorld from "./components/HelloWorld.vue";

export default {
  name: 'App',
  components: {
    NewCompany,
      HelloWorld,
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
