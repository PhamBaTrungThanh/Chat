import {Controller} from "stimulus"

export default class extends Controller {

    load() {
        axios.get(this.data.get("url")).then(response => {
            let _self = this.element
            _self.outerHTML = response.data
            //this.element.parentElement.removeChild(this.element)
            //this.element.parentElement.insertAdjacentHTML("beforeend", response.data)

        })
    }
}