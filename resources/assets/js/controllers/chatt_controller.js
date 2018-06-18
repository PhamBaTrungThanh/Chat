import {Controller} from "stimulus"
const Toastify = require("toastify-js")
export default class extends Controller {
    static targets = ["friendNotification", "friendsRequestArea", "conversation"]
    initialize() {
        this.syncNotificationTitle();
    }

    /* events and methods */
    syncNotificationTitle() {
        this.notificationsCount = this.friendNotificationsCount + this.newMessagesCount;
    }
    parseNotification(event) {
        const notification = event.detail
        console.log(notification)
        switch (notification.type) {
            case `App\\Notifications\\FriendRequested`:
                this.friendRequestedNotification(notification)
                break
            case `App\\Notifications\\FriendRequestCanceled`:
                this.friendRequestCanceled(notification)
                break     
            case `App\\Notifications\\FriendAccepted`:
                this.friendRequestAccepted(notification)
                break        
            case `App\\Notifications\\MessagePosted`:
                this.newMessage(notification)
                break
            default:
                break
        }
    }
    newToast(options) {
        const toastOptions = Object.assign({}, {
            duration: 700000,
            close: true,
            gravity: "bottom",
            positionLeft: true,
        }, options)
        if (document.visibilityState === "visible") {
            Toastify(toastOptions).showToast()
        } else {
            window.addEventListener("focus", () => {
                Toastify(toastOptions).showToast()
            }, {once: true})
        }
        
    }
    friendRequestAccepted(notification) {
        this.friendNotificationsCount--
        if (this.hasFriendsRequestAreaTarget) {
            this.friendsRequestAreaTarget.dispatchEvent(new Event("rebuild"))
        }        
        console.log("send notification -> friend request accepted")
        this.newToast({
            text: notification.message,
            avatar: notification.friend.avatar,
            classes: "link",
        })
    }
    friendRequestedNotification(notification) {
        this.friendNotificationsCount++
        // kick-off reloading friendRequestArea
        if (this.hasFriendsRequestAreaTarget) {
            this.friendsRequestAreaTarget.dispatchEvent(new Event("rebuild"))
        }
        console.log("send notification -> friend requested")
        this.newToast({
            text: notification.message,
            avatar: notification.friend.avatar,
        })
    }
    friendRequestCanceled(notification) {
        this.friendNotificationsCount--
        if (this.hasFriendsRequestAreaTarget) {
            this.friendsRequestAreaTarget.dispatchEvent(new Event("rebuild"))
        }
        console.log("send notification -> friend canceled")
    }
    newMessage(notification) {
        const event = new CustomEvent("newMessage", {detail: notification})
        console.log("new message notification -> conversation_id: " + notification.conversation_id)
        this.conversationTarget.dispatchEvent(event)
    }
    toggleSidebar() {
        this.element.classList.toggle("show-sidebar")
    }
    /* magic get/set */
    get friendNotificationsCount()
    {
        return parseInt(this.data.get("friendNotificationsCount"))
    }
    set friendNotificationsCount(value)
    {
        if (value > 0) {
            this.friendNotificationTarget.style.display = "block"
        } else if (0 <= value) {
            this.friendNotificationTarget.style.display = "none"
        }
        this.syncNotificationTitle();
        this.data.set("friendNotificationsCount", value)
        this.syncNotificationTitle()
        return value
    }
    get newMessagesCount() {
        return 0
    }
    set newMessagesCount(value) {
        this.data.set("newMessagesCount", value)
        this.syncNotificationTitle()
        return value
    }
    get notificationsCount() {
        return this.data.get("notificationsCount")
    }

    set notificationsCount(value) {
        if (value > 0) {
            window.document.title = `Chatt (${value})`
        } else {
            window.document.title = `Chatt`
        }
        this.data.set("notificationsCount", value)
    }
}