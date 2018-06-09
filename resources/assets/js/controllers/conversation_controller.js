import {Controller} from "stimulus"

export default class extends Controller {
    static targets = ["chatbox", "content"]
    sendMessage(event) {
        this.contentTarget.insertAdjacentHTML("beforeend", this.chatboxTarget.innerHTML)
    }
    
    keypress(event) {
        if (event.key === "Enter") {
            if (event.shiftKey === true) {
                return true
            } else if (this.element.textContent === "") {
                return true
            }
            else {
                event.stopPropagation()
                event.preventDefault()
                this.sendMessage()
                this.chatboxTarget.innerHTML = ""
                return false
            }
        }
        return true
    }
}