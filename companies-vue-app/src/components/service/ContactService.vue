<script>
import axios from 'axios'

axios.defaults.headers.common['Accept'] = 'application/json'; // for all requests

const baseUrl = process.env.VUE_APP_API_BASE_URL

export default class ContactService {

    search(query) {
        return axios.get(baseUrl + '/index.php/api/contacts/' + query).then(
            res => res.data
        );
    }
}

</script>
