import { Loader } from '@googlemaps/js-api-loader'

export default (Alpine) => {
    Alpine.data('locationPickr', ({ mapEl, config }) => ({
        loader: null,
        map: null,
        marker: null,
        markerLocation: null,
        mapEl: null,
        infoWindow: null,
        config: {
            draggable: true,
            clickable: false,
            defaultLocation: {
                lat: 0,
                lng: 0,
            },
            statePath: '',
            controls: {
                mapTypeControl: true,
                scaleControl: true,
                streetViewControl: true,
                rotateControl: true,
                fullscreenControl: true,
                zoomControl: false,
            },
            defaultZoom: 8,
            myLocationLabel: '',
            apiKey: '',
        },

        init: function () {
            this.mapEl = mapEl
            this.config = { ...this.config, ...config }
            this.loadGmaps()
        },

        loadGmaps: function () {
            this.loader = new Loader({
                apiKey: this.config.apiKey,
                version: 'weekly',
            })

            this.loader
                .load()
                .then(async () => {
                    this.map = new google.maps.Map(this.mapEl, {
                        center: this.getCoordinates(),
                        zoom: this.config.defaultZoom,
                        ...this.config.controls,
                    })

                    this.infoWindow = new google.maps.InfoWindow()

                    this.marker = new google.maps.Marker({
                        draggable: this.config.draggable,
                        map: this.map,
                    })

                    this.marker.setPosition(this.getCoordinates())

                    if (this.config.clickable) {
                        this.map.addListener('click', (event) => {
                            this.markerLocation = event.latLng.toJSON()
                            this.setCoordinates(this.markerLocation)
                            this.map.panTo(this.markerLocation)
                        })
                    }

                    if (this.config.draggable) {
                        google.maps.event.addListener(
                            this.marker,
                            'dragend',
                            (event) => {
                                this.markerLocation = event.latLng.toJSON()
                                this.setCoordinates(this.markerLocation)
                                this.map.panTo(this.markerLocation)
                            },
                        )
                    }

                    const locationButtonDiv = document.createElement('div')
                    locationButtonDiv.classList.add('location-div')
                    locationButtonDiv.appendChild(this.createLocationButton())

                    this.map.controls[
                        google.maps.ControlPosition.TOP_LEFT
                    ].push(locationButtonDiv)
                })
                .catch((error) => {
                    console.error('Error loading Google Maps API:', error)
                })
        },

        createLocationButton: function () {
            const locationButton = document.createElement('button')
            locationButton.type = 'button'
            locationButton.textContent = this.config.myLocationLabel
            locationButton.classList.add('location-button')

            locationButton.addEventListener('click', (event) => {
                event.preventDefault()

                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(
                        (position) => {
                            this.markerLocation = {
                                lat: position.coords.latitude,
                                lng: position.coords.longitude,
                            }
                            this.setCoordinates(this.markerLocation)
                            this.map.panTo(this.markerLocation)
                        },
                        () => {
                            this.myLocationError(
                                true,
                                this.infoWindow,
                                this.map.getCenter(),
                            )
                        },
                    )
                } else {
                    this.myLocationError(
                        false,
                        this.infoWindow,
                        this.map.getCenter(),
                    )
                }
            })

            return locationButton
        },

        updateMapFromAlpine: function () {
            const location = this.getCoordinates()
            const markerLocation = this.marker.getPosition()

            if (
                !(
                    location.lat === markerLocation.lat() &&
                    location.lng === markerLocation.lng()
                )
            ) {
                this.updateMap(location)
            }
        },

        updateMap: function (position) {
            this.marker.setPosition(position)
            this.map.panTo(position)
        },

        setCoordinates: function (position) {
            $wire.set(this.config.statePath, position)
        },

        getCoordinates: function () {
            let location = $wire.get(this.config.statePath)

            if (location === null || !location.hasOwnProperty('lat')) {
                location = {
                    lat: this.config.defaultLocation.lat,
                    lng: this.config.defaultLocation.lng,
                }
            }

            return location
        },

        myLocationError: function (browserHasGeolocation, infoWindow, pos) {
            infoWindow.setPosition(pos)

            infoWindow.setContent(
                browserHasGeolocation
                    ? 'Error: The Geolocation service failed.'
                    : "Error: Your browser doesn't support geolocation.",
            )

            infoWindow.open(this.map)
        },
    }))
}
