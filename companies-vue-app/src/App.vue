<template>
    <NewCompany/>

    <DataTable :value="companies" :paginator="true" :rows="10" :lazy="true" ref="dt"
               :totalRecords="totalRecords" :loading="loading" @page="onPage($event)">
        <!--        todo -->
        <!--        <Column field="logo" header="Logo"></Column>-->
        <Column field="name" header="Company Name"></Column>
        <Column field="email" header="Email"></Column>
        <Column>
            <template #body="slotProps">
                <!--  slotProps.data is company data -->
                <Button type="button" @click="edit(slotProps.data)" icon="pi pi-pencil" class="p-button-warning"></Button>
            </template>
        </Column>
<!--        <Column field="contact_count" header="Contact count"></Column>-->

    </DataTable>

<!--    Probably could use only one Company form tag, and open same on creating new company -->
    <CompanyForm  v-model:displayForm="displayForm" />

    <Dialog  header="Company edit" :visible="displayEditForm" @update:visible="$emit('update:display-edit-form', $event)">

        <Message v-for="msg of editCompanyMessages" :severity="msg.severity" :key="msg.content">{{msg.content}}</Message>

        <h5>Name</h5>
        <InputText type="text" v-model="companyBeingEdited.name" />

        <h5>Email</h5>
        <InputText type="email" v-model="companyBeingEdited.email" />

        <h5>Phone</h5>
        <InputText type="text" v-model="companyBeingEdited.phone" />

        <div>
            <Button @click="updateCompany(companyBeingEdited)" label="Submit" />
        </div>

        <h5>Logo</h5>
<!--        todo base url use-->
        <FileUpload
            name="logo"
            v-bind:url="`http://localhost:8000/index.php/api/companies/${companyBeingEdited.id}/logo`"
            accept="image/*"
            :maxFileSize="2097152"
            :fileLimit="1"
            @before-send="beforeUpload"
            @error="onUploadError"
            @upload="onUploadComplete"
        />

        <h5>Contacts - type to search</h5>

        <!-- field attribute tells which column to display from the search results  -->
        <AutoComplete
            :multiple="true"
            v-model="selectedContacts"
            :suggestions="filteredContactsMultiple"
            @complete="searchContactMultiple($event)"
            @item-select="onContactSelect"
            @item-unselect="onContactUnSelect"
            field="name"
        />


    </Dialog>
</template>

<script>
import NewCompany from './components/NewCompany'
import CompanyService from './components/service/CompanyService'
import ContactService from './components/service/ContactService'
import DataTable from 'primevue/datatable';
import Column from 'primevue/column';
import Button from "primevue/button";
import CompanyForm from "./components/CompanyForm";
import Dialog from "primevue/dialog";
import InputText from "primevue/inputtext";
import FileUpload from 'primevue/fileupload';
import Message from 'primevue/message';
import AutoComplete from 'primevue/autocomplete';

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
        FileUpload,
        Message,
        AutoComplete
    },
    data() {
        return {

            displayEditForm: false,
            companyBeingEdited: null,
            editCompanyMessages: [],

            selectedContacts: [],
            filteredContactsMultiple: [],

            // companies table
            loading: false,
            totalRecords: 0,
            companies: null,
            // filters: {
            //     'name': {value: '', matchMode: 'contains'},
            //     'country.name': {value: '', matchMode: 'contains'},
            //     'company': {value: '', matchMode: 'contains'},
            //     'representative.name': {value: '', matchMode: 'contains'},
            // },
            lazyParams: {},
            // end companies table
        }
    },
    companyService: null,
    created() {
        this.companyService = new CompanyService();
        this.contactService = new ContactService();
    },
    mounted() {
        // this.loading = true;

        this.lazyParams = {
            first: 0,
            rows: this.$refs.dt.rows,
            // sortField: null,
            // sortOrder: null,
            // filters: this.filters
        };

        this.loadCompanies();
    },
    methods: {
        loadCompanies() {
            this.loading = true
            this.companyService.getCompanies(
                { lazyEvent: JSON.stringify( this.lazyParams ) }
            ).then(data => {
                            this.companies = data.companies;
                            this.totalRecords = data.totalRecords;
                            this.loading = false;
            });
        },
        onPage(event) {
            this.lazyParams = event;
            this.loadCompanies();
        },
        edit(company) {
            this.displayEditForm = true;
            this.companyBeingEdited = company;
            this.editCompanyMessages = []; // clearing messages from previous edit
            this.selectedContacts = []; // todo
        },
        searchContactMultiple(event) {

            const query = event.query.trim();

            if (!query.length) {
                this.filteredContactsMultiple = [];
            } else {
                this.contactService.search(query).then(data => {
                    this.filteredContactsMultiple = data;
                });
            }
        },
        onContactSelect(event) {
            const contact = event.value;

            this.companyService.addContact(this.companyBeingEdited.id, contact.id)
                .then(() => {
                    this.setEditSuccessMessage('Contact added');
                });
        },
        onContactUnSelect() {

        },
        setEditSuccessMessage(content) {
            this.editCompanyMessages = [{severity: 'success', content: content}];
        },
        updateCompany(company) {
            this.companyService.update(company)
                .then(() => {
                    this.displayEditForm = false;
                })
                .catch((error) => {
                    if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx

                        let object = error.response.data.errors;
                        for (const property in object) {
                            this.editCompanyMessages.push({severity: 'error', content: `${object[property]}`});
                        }
                    }
                });
        },
        beforeUpload(request) {
            // so that laravel would return json response on validation error
            request.xhr.setRequestHeader('Accept', 'application/json');

            return request;
        },
        onUploadError(request) {
            let object = JSON.parse(request.xhr.responseText).errors;

            for (const property in object) {
                const message = `${object[property]}`;

                this.editCompanyMessages.push({severity: 'error', content: message});
            }
        },
        onUploadComplete() {
            this.editCompanyMessages = [];
            this.editCompanyMessages.push({severity: 'success', content: 'File uploaded'});
        }
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
