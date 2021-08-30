<script>
import axios from 'axios'

export default class CompanyService {

    getCompanies() {
        // todo get base url from config
        return axios.get('http://localhost:8000/index.php/api/companies').then(
            res => res.data
        );
    }
}

</script>
