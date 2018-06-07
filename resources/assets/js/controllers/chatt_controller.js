import {Controller} from "stimulus"

export default class extends Controller {
    static targets = ["friendNotification", "friendsRequestArea"]
    initialize() {
        console.log("chatt intialized")
    }


    /* events and methods */
    parseNotification(event) {
        const notification = event.detail
        console.log(notification)
        switch (notification.type) {
            case `App\\Notifications\\FriendRequested`:
                this.friendRequestedNotification()
                break
                case `App\\Notifications\\FriendRequestCanceled`:
                this.friendRequestCanceled()
                break        
            default:
                break
        }
    }
    friendRequestedNotification() {
        this.friendRequested++
        // kick-off reloading friendRequestArea
        if (this.hasFriendsRequestAreaTarget) {
            this.friendsRequestAreaTarget.dispatchEvent(new Event("rebuild"))
        }
        console.log("send notification -> friend requested")
    }
    friendRequestCanceled() {
        this.friendRequested--
        if (this.hasFriendsRequestAreaTarget) {
            this.friendsRequestAreaTarget.dispatchEvent(new Event("rebuild"))
        }
        console.log("send notification -> friend canceled")
    }
    /* magic get/set */
    get friendRequested() {
        return parseInt(this.friendNotificationTarget.innerHTML)
    }
    set friendRequested(value) {
        if (value > 0) {
            this.friendNotificationTarget.style.display = "block"
        } else if (0 <= value) {
            this.friendNotificationTarget.style.display = "none"
        }
        this.friendNotificationTarget.innerHTML = value
    }    
}