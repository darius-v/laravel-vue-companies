<script>
import axios from 'axios'

axios.defaults.headers.common['Accept'] = 'application/json'; // for all requests

const baseUrl = process.env.VUE_APP_API_BASE_URL;

export default class CompanyService {

    getCompanies(params) {
        return axios.get(baseUrl + '/index.php/api/companies', { params }).then(
            res => res.data
        );
    }

    create(name, email, phone) {
        return axios.post(baseUrl + '/api/companies', {
                name: name,
                email: email,
                phone: phone
            }
        );
    }

    update(company) {
        return axios.put(baseUrl + '/api/companies/' + company.id, {
                name: company.name,
                email: company.email,
                phone: company.phone
            }
        )
    }

    addContact(companyId, contactId) {
        return axios.patch(baseUrl + '/api/companies/' + companyId + '/contact', {
                contactId: contactId
            }
        )
    }
}

</script>
