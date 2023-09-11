import locationPickr from './components/locationpickr'

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(locationPickr)
})
