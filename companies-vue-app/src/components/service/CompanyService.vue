<script>
import axios from 'axios'

axios.defaults.headers.common['Accept'] = 'application/json'; // for all requests

// todo get base url from config
const baseUrl = 'http://localhost:8000';

export default class CompanyService {


    getCompanies() {
        return axios.get(baseUrl + '/index.php/api/companies').then(
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
        axios.put(baseUrl + '/api/companies/' + company.id, {
                name: company.name,
                email: company.email,
                phone: company.phone
            }
        )
    }
}

</script>
