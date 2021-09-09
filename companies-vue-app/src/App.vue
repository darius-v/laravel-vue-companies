<template>
<!--    todo split to more components -->
    <NewCompany @created="filter" />

    <DataTable :value="companies" :paginator="true" :rows="10" :lazy="true" ref="dt"
               :totalRecords="totalRecords" :loading="loading" @page="onPage($event)"
               paginatorTemplate="FirstPageLink PrevPageLink PageLinks NextPageLink LastPageLink CurrentPageReport"
               currentPageReportTemplate="Showing {first} to {last} of {totalRecords} entries"
               v-model:filters="filters" filterDisplay="row"
               :globalFilterFields="['name']"
    >
        <template #header>
            <div id="search">
                <span class="p-input-icon-left">
                    <i class="pi pi-search" />
                    <InputText v-model="filters['name'].value" placeholder="Search..." @keydown.enter="filter()" />
                </span>
            </div>
        </template>
        <Column field="logo" header="Logo">
            <template #body="slotProps">
                <img v-if="slotProps.data.logo !== null" v-bind:src="apiBaseUrl + `${slotProps.data.logo}`" width="50" alt="Logo">
            </template>
        </Column>

        <Column field="name" header="Company Name" filterMatchMode="startsWith" ref="name">
        </Column>
        <Column field="email" header="Email"></Column>
        <Column>
            <template #body="slotProps">
                <!--  slotProps.data is company data -->
                <Button type="button" @click="edit(slotProps.data)" icon="pi pi-pencil" class="p-button-success p-button-rounded"></Button>
                <Button type="button" @click="deleteCompany(slotProps.data.id)" icon="pi pi-trash" class="p-button-warning p-button-rounded"></Button>
            </template>
        </Column>
        <Column field="contact_count" header="Contact count"></Column>

    </DataTable>

    <CompanyForm v-model:displayForm="displayForm" />

    <Dialog  header="Company edit" v-model:visible="displayEditForm" v-bind:modal="true">

        <Message v-for="msg of editCompanyMessages" :severity="msg.severity" :key="msg.content">{{msg.content}}</Message>

        <h5>Name</h5>
        <InputText type="text" v-model="companyBeingEdited.name" />

        <h5>Email</h5>
        <InputText type="email" v-model="companyBeingEdited.email" />

        <h5>Phone</h5>
        <InputText type="text" v-model="companyBeingEdited.phone" />

        <div>
            <Button @click="updateCompany(companyBeingEdited)" label="Submit" class="mt-5" />
        </div>

        <h5>Logo</h5>
        <FileUpload
            name="logo"
            :auto="true"
            v-bind:url="apiBaseUrl + `/api/companies/${companyBeingEdited.id}/logo`"
            accept="image/*"
            :maxFileSize="2097152"
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
            apiBaseUrl: process.env.VUE_APP_API_BASE_URL,
            displayEditForm: false,
            companyBeingEdited: null,
            editCompanyMessages: [],

            selectedContacts: [],
            filteredContactsMultiple: [],

            // companies table
            loading: false,
            totalRecords: 0,
            companies: null,
            // filters: null,
            filters: {
                'name': {value: '', matchMode: 'contains'},
            },
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
        this.lazyParams = {
            first: 0,
            rows: this.$refs.dt.rows,
            filters: this.filters
        };

        this.loadCompanies();
    },

    methods: {
        loadCompanies() {
            this.loading = true;
            this.companyService.getCompanies(
                { lazyEvent: JSON.stringify( this.lazyParams ) }
            ).then(data => {
                this.companies = data.companies;
                this.totalRecords = data.totalRecords;
                this.loading = false;
            });
        },
        filter() {
            this.lazyParams.filters = this.filters;
            this.loadCompanies();
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
        deleteCompany(id) { // delete function name does not work
            this.companyService.delete(id)
                .then(() => {
                    this.loadCompanies();
                })
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

#search {
    text-align: right;
}

.p-button.mt-5 {
    margin-top: 5px;
}
</style>
