import {Controller} from "stimulus"
const uuidv1 = require("uuid/v1")

export default class extends Controller {
    static targets = ["chatbox", "content"]

    connect() {
        this.contentTarget.scrollTop = this.contentTarget.scrollHeight
    }
    sanitize(string) {
        // trim the string
        string = string.trim()
        // remove new line at begining
        string = string.replace(/^(?:<br ?\/?>)*/gm, "")
        // remove new line at the end
        string = string.replace(/(?:<br ?\/?>)*$/gm, "")
        // remove all tags, leave only br 
        string = string.replace(/<\/?(\w+) ?\/?>/gm, (match, p1) => {
            if (p1.toLowerCase() === "br") {
                return "<br />"
            } else {
                return ""
            }
        })
        return string
    }
    sendMessage(event) {
        const uuid = uuidv1(),
            html = this.sanitize(this.chatboxTarget.innerHTML)
        this.contentTarget.insertAdjacentHTML("beforeend", `<div class="message self" id="${uuid}">${html}</div>`)
        axios.post(this.data.get("postUrl"), {
            message: html,
            uuid: uuid,
        }).catch(result => { 
            let element = document.getElementById(uuid)
            element.classList.add("is-error" ,"hint--top", "hint--error")
            element.setAttribute("aria-label", `Lỗi server!`)
        });
    }

    keypress(event) {
        if (this.chatboxTarget.textContent !== "") {
            this.element.classList.add("ready-to-send")
        } else if (this.chatboxTarget.textContent === "") {
            this.element.classList.remove("ready-to-send")
        }
        if (event.key === "Enter") {
            if (event.shiftKey === true) {
                return true
            } else {
                event.stopPropagation()
                event.preventDefault()
                if (this.chatboxTarget.textContent === "") {
                    return false
                }
                else {
                    this.sendMessage()
                    this.element.classList.remove("ready-to-send")
                    this.chatboxTarget.innerHTML = ""
                    return false
                }

            }
        }
        return true
    }
}