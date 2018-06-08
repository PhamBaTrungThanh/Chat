import { Controller } from "stimulus"

export default class extends Controller {
    fire() {
        if (this.updateUrl) {
            axios.get(this.updateUrl).then(result => {
                if (result.status === 200) {
                    this.remove()
                }
            })
        } else {
            this.remove()
        }
    }
    remove() {
        this.element.parentElement.removeChild(this.element)
    }
    get updateUrl() {
        if (this.data.has('updateUrl')) {
            return this.data.get('updateUrl')
        }
        return false
    }
}