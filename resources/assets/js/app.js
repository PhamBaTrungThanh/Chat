import bootstrap from './bootstrap'
import animation from './animation'


(function() {
    document.addEventListener("DOMContentLoaded", () => {
        bootstrap()
        animation()
        Turbolinks.start()
        let userId = document.head.querySelector('meta[name="user-id"]').content
        
        Echo.private(`App.User.${userId}`)
            .notification((notification) => {
                let event = new CustomEvent("notification", {detail: notification})
                document.body.dispatchEvent(event)
            });
    });
})(window)
