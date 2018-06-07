    
import Echo from "laravel-echo"
import { Application } from "stimulus"
import { definitionsFromContext } from "stimulus/webpack-helpers"

export default function () {
    window.axios = require('axios')
    window.Pusher = require("pusher-js")
    window.Turbolinks = require("turbolinks")
    
    window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
    
    let token = document.head.querySelector('meta[name="csrf-token"]');
    
    if (token) {
        window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    } else {
        console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
    }
    
    window.Echo = new Echo({
        broadcaster: 'pusher',
        key: process.env.MIX_PUSHER_APP_KEY,
        cluster: process.env.MIX_PUSHER_APP_CLUSTER,
        encrypted: false,
        disableStats: true,
    });
    
    const application = Application.start()
    const context = require.context("./controllers", true, /\.js$/)
    application.load(definitionsFromContext(context))        

}
