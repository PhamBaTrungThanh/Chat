import {Controller} from "stimulus"

export default class extends Controller {
    load() {
        axios.get(this.data.get("url")).then(response => {
            this.element.innerHTML = response.data
        })
    }
}