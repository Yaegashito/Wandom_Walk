'use strict';

{
    // walk
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert('失敗');
    }

    function showPosition(position) {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
        document.querySelector('#lat').value = lat;
        document.querySelector('#lon').value = lng;
        initMap(lat, lng);
    }

    let map;

    function initMap(lat, lng) {

        // 地図の初期設定
        map = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 35.6895, lng: 139.6917 }, // 東京の中心
            center: new google.maps.LatLng(lat, lng),
            zoom: 18,
        });

        let marker = new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            title: '現在地',
        });
    }

    let directionsService;
    let directionsRenderer;

    function renderRoute(points, waypoints, pickupIdx) {
        map = new google.maps.Map(document.getElementById('map'), {
            // center: { lat: 35.6895, lng: 139.6917 },
            zoom: 8,
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            // suppressMarkers: true, //経由地のピンを非表示
            polylineOptions: {
                strokeColor: 'blue', // ポリラインの色を青に設定
                strokeWeight: 2,      // ポリラインの太さを設定
                icons: [{
                    icon: {
                        path: google.maps.SymbolPath.FORWARD_CLOSED_ARROW,
                        scale: 3,
                        strokeColor: 'red'
                    },
                    offset: '100%',
                    repeat: '100px'
                }]
            }
        });
        directionsRenderer.setMap(map);

        // 他のAPIから取得した経由地の情報をここに設定
        const waypointsT = [];

        for (let i = 0; i < waypoints; i++) {
            waypointsT.push({
                location: { lat: parseFloat(points[pickupIdx[i]].lat), lng: parseFloat(points[pickupIdx[i]].lon) }
                // `${points[pickupIdx[i]].lat},${points[pickupIdx[i]].lon}/`
            });
        }

        const origin = waypointsT.shift().location;
        const destination = waypointsT.pop().location;

        directionsService.route(
            {
                origin: origin,
                destination: destination,
                waypoints: waypointsT,
                optimizeWaypoints: true,
                travelMode: 'DRIVING',
            },
            (response, status) => {
                if (status === 'OK') {
                    directionsRenderer.setDirections(response);

                    const steps = response.routes[0].legs[0].steps;
                    steps.forEach((step, index) => {
                        const marker = new google.maps.Marker({
                            position: step.start_location,
                            map: map,
                            label: `${index + 1}`
                        });

                        const infowindow = new google.maps.InfoWindow({
                            content: step.instructions
                        });

                        marker.addListener('click', () => {
                            infowindow.open(map, marker);
                        });
                    });

                    let totalDistance = 0;
                    const legs = response.routes[0].legs;
                    for (let i = 0; i < legs.length; i++) {
                        totalDistance += legs[i].distance.value; // 距離をメートルで取得
                    }
                    totalDistance = totalDistance / 1000; // キロメートルに変換

                    console.log('Total Distance: ' + totalDistance + ' km');
                } else {
                    window.alert('Directions request failed due to ' + status);
                }
            }
        );
    }

    document.querySelector('#start').addEventListener('click', () => {
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch('/map', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'X-CSRF-TOKEN': csrfToken
            },
            body: new URLSearchParams({
                lat: document.querySelector('#lat').value,
                lon: document.querySelector('#lon').value,
                per: document.querySelector('#per').value,
            }),
        })
        .then(res => {
            return res.json();
        })
        .then(json => {
            const points = json.points;
            const waypoints = json.waypoints;
            const pickupIdx = json.pickupIdx;

            renderRoute(points, waypoints, pickupIdx);

            const googleMapsURL = 'https://www.google.com/maps/dir/';
            let finalURL = googleMapsURL;
            for (let i = 0; i < waypoints; i++) {
                finalURL += `${points[pickupIdx[i]].lat},${points[pickupIdx[i]].lon}/`;
            }

            document.getElementById('result').textContent = finalURL;
        });
    });

    // calendar
    const today = new Date();
    let year = today.getFullYear();
    let month = today.getMonth();

    function getCalendaHead() {
        const dates = [];
        const d = new Date(year, month, 0).getDate();
        const n = new Date(year, month, 1).getDay();

        for (let i = 0; i < n; i++) {
            dates.unshift({
                date: d - i,
                isToday: today,
                isDisabled: true,
            });
        }

        return dates;
    }

    function getCalendarBody() {
        const dates = [];
        const lastDate = new Date(year, month + 1, 0).getDate();

        for (let i = 1; i <= lastDate; i++) {
            dates.push({
                date: i,
                isToday: false,
                isDisabled: false,
            });
        }

        if (year === today.getFullYear() && month === today.getMonth()) {
            dates[today.getDate() - 1].isToday = true;
        }

        return dates;
    }

    function getCalendarTail() {
        const dates = [];
        const lastDay = new Date(year, month + 1, 0).getDay();

        for (let i = 1; i < 7 - lastDay; i++) {
            dates.push({
                date: i,
                isToday: false,
                isDisabled: true,
            });
        }

        return dates;
    }

    function clearCalendar() {
        const tbody = document.querySelector('tbody');

        while (tbody.firstChild) {
            tbody.removeChild(tbody.firstChild);
        }
    }

    function renderTitle() {
        const title = `${year}年${String(month + 1)}月`;
        document.querySelector('#title').textContent = title;
    }

    function renderWeeks() {
        const dates = [
            ...getCalendaHead(),
            ...getCalendarBody(),
            ...getCalendarTail(),
        ];
        const weeks = [];
        const weeksCount = dates.length / 7;

        for (let i = 0; i < weeksCount; i++) {
            weeks.push(dates.splice(0, 7));
        }

        weeks.forEach(week => {
            const tr = document.createElement('tr');
            week.forEach(date => {
                const td = document.createElement('td');
                td.textContent = date.date;
                if (date.isToday) {
                    td.classList.add('today');
                }
                if (date.isDisabled) {
                    td.classList.add('disabled');
                }
                tr.appendChild(td);
                // const p = document.createElement('p');
                // p.textContent = '23m';
                // td.appendChild(p);
            });
            document.querySelector('tbody').appendChild(tr);
        });
    }

    function createCalendar() {
        clearCalendar();
        renderTitle();
        renderWeeks();
    }

    document.querySelector('#prev').addEventListener('click', () => {
        month--;
        if (month < 0) {
            year--;
            month = 11;
        }
        createCalendar();
    });

    document.querySelector('#next').addEventListener('click', () => {
        month++;
        if (month > 11) {
            year++;
            month = 0;
        }
        createCalendar();
    });

    document.querySelector('#today').addEventListener('click', () => {
        year = today.getFullYear();
        month = today.getMonth();
        createCalendar();
    });

    createCalendar();

    // belongings

    // config

    // footer
    const mains = document.querySelectorAll('main > div');
    const menus = document.querySelectorAll('footer ul li');

    menus.forEach((menu, i) => {
        menu.addEventListener('click', () => {
            mains.forEach((main, j) => {
                main.style.display = 'none';
                if (i === j) {
                    main.style.display = 'block';
                }
            })
            menus.forEach(menu => {
                menu.style.background = 'lightgreen';
            });
            menu.style.background = 'red';
        })
    });
}
