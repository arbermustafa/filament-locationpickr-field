import locationPickrField from './forms/components/locationpickr'

document.addEventListener('alpine:init', () => {
    window.Alpine.plugin(locationPickrField)
})
