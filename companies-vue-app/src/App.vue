<template>
    <NewCompany/>

    <DataTable :value="companies">
        <!--        todo -->
        <!--        <Column field="logo" header="Logo"></Column>-->
        <Column field="name" header="Company Name"></Column>
        <Column field="email" header="Email"></Column>
<!--        <Column field="contact_count" header="Contact count"></Column>-->

    </DataTable>

</template>

<script>
import NewCompany from './components/NewCompany'
import CompanyService from './components/service/CompanyService'

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
// import axios from 'axios'

export default {
    name: 'App',
    components: {
        NewCompany,
        // CompanyService,
        DataTable,
        Column
    },
    data() {
        return {
            companies: null
        }
    },
    companyService: null,
    created() {
        this.companyService = new CompanyService();
    },
    mounted() {
        this.companyService.getCompanies().then(data => {this.companies = data ; console.log(data)});
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
