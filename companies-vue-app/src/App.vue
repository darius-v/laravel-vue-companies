<template>
    <NewCompany/>

    <DataTable :value="companies">
        <!--        todo -->
        <!--        <Column field="logo" header="Logo"></Column>-->
        <Column field="name" header="Company Name"></Column>
        <Column field="email" header="Email"></Column>
        <Column>
            <template #body="slotProps">
                <Button type="button" @click="edit(slotProps.data)" icon="pi pi-pencil" class="p-button-warning"></Button>
            </template>
        </Column>
<!--        <Column field="contact_count" header="Contact count"></Column>-->

    </DataTable>

<!--    Probably could use only one Company form tag, and open same on creating new company -->
    <CompanyForm  v-model:displayForm="displayForm" />

    <Dialog  header="Company edit" :visible="displayEditForm" @update:visible="$emit('update:display-edit-form', $event)">
        <h5>Name</h5>
        <InputText type="text" v-model="companyBeingEdited.name" />

        <h5>Email</h5>
        <InputText type="email" v-model="companyBeingEdited.email" />

        <h5>Phone</h5>
        <InputText type="text" v-model="companyBeingEdited.phone" />

        <!--        todo - after company is created so could assign-->
        <div>
            <Button @click="updateCompany(companyBeingEdited)" label="Submit" />
        </div>

        <h5>Logo</h5>
<!--        todo base url use-->
        <FileUpload name="logo" v-bind:url="`http://localhost:8000/index.php/api/companies/${companyBeingEdited.id}/logo`" />
        <div
            class="static"
            v-bind:class="{ active: isActive, 'text-danger': hasError }"
        ></div>
    </Dialog>

<!--    <Dialog :visible="displayUploadForm">-->
<!--        <FileUpload name="logo[]" url="./upload" />-->
<!--    </Dialog>-->
</template>

<script>
import NewCompany from './components/NewCompany'
import CompanyService from './components/service/CompanyService'

import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from "primevue/button";
import CompanyForm from "./components/CompanyForm";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import FileUpload from 'primevue/fileupload';

export default {
    name: 'App',
    components: {
        NewCompany,
        DataTable,
        Column,
        Button,
        CompanyForm,
        Dialog,
        InputText,
        FileUpload
    },
    data() {
        return {
            companies: null,
            displayEditForm: false,
            companyBeingEdited: null
        }
    },
    companyService: null,
    created() {
        this.companyService = new CompanyService();
    },
    mounted() {
        this.companyService.getCompanies().then(data => {this.companies = data ; });
    },
    methods: {
        edit(company) {
            this.displayEditForm = true;
            this.companyBeingEdited = company;
        },
        updateCompany(company) {
            this.companyService.update(company);
            this.displayEditForm = false;
        },
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
