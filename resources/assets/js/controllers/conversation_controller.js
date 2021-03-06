import {Controller} from "stimulus"
const uuidv1 = require("uuid/v1")

export default class extends Controller {
    static targets = ["chatbox", "content"]
    get conversationId() {
        return this.data.get("id")
    }
    get conversationName() {
        return this.data.get("name")
    }
    initialize() {
        this.self = {
            //name: document.querySelector("meta[name='user-name']").content,
            name: "Bạn",
            avatar: document.querySelector("meta[name='user-avatar']").content,
        }
        this.latestMessage = Object.assign({}, {message: {body: ''}}, {conversation_id: this.conversationId, conversation_name: this.conversationName}, {creator: this.self})
    }
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
    newMessage(event) {
        this.updateSidebar(event.detail)
        this.updateConversation(event.detail)
    }
    
    sendMessage(event) {
        const uuid = uuidv1(),
            html = this.sanitize(this.chatboxTarget.innerHTML)
        this.contentTarget.insertAdjacentHTML("beforeend", `<div class="message self" id="${uuid}">${html}</div>`)
        axios.post(this.data.get("postUrl"), {
            message: html,
            uuid: uuid,
        }).then(result => {
            if (result.status === 200) {
                this.latestMessage.message.body = html
                this.updateSidebar(this.latestMessage)
            }
        }).catch((result) => {
            let element = document.getElementById(uuid)
            element.classList.add("is-error" ,"hint--top", "hint--error")
            element.setAttribute("aria-label", `Lỗi server!`)
        });
    }
    updateConversation(data) {
        this.contentTarget.insertAdjacentHTML("beforeend", `<div class="message">${data.message.body}</div>`)
    }
    updateSidebar(data) {
        let element = document.getElementById(`conversation_sidebar__${data.conversation_id}`)
        if (element) {
            element.classList.add("unread")
            element.innerHTML = `
                <div class="conversation-avatar">
                    <img src="${data.creator.avatar}" />
                </div>
                <div class="inside">
                    <p class="conversation-title">${data.conversation_name}</p>
                    <p class="content">${data.creator.name}: ${data.message.body}</p>
                </div>
            `;
        } else {
            let sidebar = document.querySelector("#sidebar__display.conversation-list")
            axios.get(sidebar.dataset.updateUrl).then(response => {
                sidebar.outerHTML = response.data
            });
        }
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
                    this.contentTarget.scrollTop = this.contentTarget.scrollHeight
                    this.chatboxTarget.innerHTML = ""
                    return false
                }

            }
        }
        return true
    }
}