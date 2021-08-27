<template>
    <div>
<!--        <button @click="sendData">Send Data</button>-->
    </div>
</template>

<script>

// import Button from "primevue/button";
// import CompanyForm from "./CompanyForm";

export default {
    methods: {
        sendData() {
            console.log('aaa');
            this.$emit('sending-start');

            this.$emit('sending-complete');
        }
    }

}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
