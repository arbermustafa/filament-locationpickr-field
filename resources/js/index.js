import locationPickr from './field/locationpickr'

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(locationPickr)
})
