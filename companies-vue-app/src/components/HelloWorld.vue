<template>
    <div class="hello">
        <DataSender @sending-start="started" />
    </div>
</template>

<script>

import DataSender from "./DataSender";

export default {
    components: { DataSender},
    methods: {
        started() {
            console.log('started in hello');
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>


</style>
