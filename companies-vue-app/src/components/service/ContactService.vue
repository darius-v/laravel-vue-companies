<script>
import axios from 'axios'

axios.defaults.headers.common['Accept'] = 'application/json'; // for all requests

// todo get base url from config
const baseUrl = 'http://localhost:8000';

export default class ContactService {

    search(query) {
        return axios.get(baseUrl + '/index.php/api/contacts/' + query).then(
            res => res.data
        );
    }
}

</script>
