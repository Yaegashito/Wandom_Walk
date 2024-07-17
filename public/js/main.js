'use strict';

{
    // walk
    let lat;
    let lng;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert('Geolocation is not supported by this browser.');
    }

    function showPosition(position) {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
        // document.querySelector('#lat').value = lat;
        // document.querySelector('#lon').value = lng;
        initMap(lat, lng);

        document.getElementById('route-form').addEventListener('submit', (event) => {
            event.preventDefault();
            const targetDistance = parseFloat(document.getElementById('distance').value);
            // const startLocation = new google.maps.LatLng(35.6895, 139.6917);  // 東京を初期地点に設定
            const startLocation = new google.maps.LatLng(lat, lng);  // 現在地を初期地点に設定
            generateRoute(startLocation, targetDistance);  // 入力された距離を使って経路を生成
        });

    }

    let map, directionsService, directionsRenderer;

    async function initMap(lat, lng) {
        const { Map } = await google.maps.importLibrary('maps');
        map = new Map(document.getElementById('map'), {
            // center: { lat: 35.6895, lng: 139.6917 },  // 東京を初期地点に設定
            center: new google.maps.LatLng(lat, lng),  // 現在地を初期地点に設定
            zoom: 16,
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: false,
        });

        // let marker = new google.maps.Marker({
        new google.maps.Marker({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            icon: {
                path: google.maps.SymbolPath.CIRCLE,
                fillColor: '#115EC3',
                fillOpacity: 1,
                strokeColor: 'white',
                strokeWeight: 2,
                scale: 7
            },
        });

        directionsService = new google.maps.DirectionsService();
        directionsRenderer = new google.maps.DirectionsRenderer({
            // suppressMarkers: true, //経由地のピンを非表示
            polylineOptions: {
                strokeColor: 'blue', // ポリラインの色を青に設定
                strokeWeight: 2,      // ポリラインの太さを設定
                icons: [{
                    icon: {
                        path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
                        scale: 3,
                        strokeColor: 'red'
                    },
                    offset: '100%',
                    repeat: '100px'
                }]
            },
        });
        directionsRenderer.setMap(map);
    }

    function generateRoute(startLocation, targetDistance) {
        let waypoints = generateRandomWaypoints(startLocation, 3);  // ランダムなウェイポイントを生成
        waypoints.push(startLocation);  // スタート地点に戻る

        directionsService.route({
            origin: startLocation,
            destination: startLocation,
            waypoints: waypoints.map(location => ({ location: location, stopover: true })),
            travelMode: 'WALKING'
        }, function (response, status) {
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
                let route = response.routes[0];
                let totalDistance = computeTotalDistance(route);
                // if (Math.abs(totalDistance - targetDistance) > 0.5) {  // 距離が入力値に近くなるように調整
                //     console.log('再度ウェイポイントを調整して経路を生成');
                //     generateRoute(startLocation, targetDistance);
                // }
            } else {
                console.error('Directions request failed due to ' + status);
            }
            let totalDistance = 0;
            const legs = response.routes[0].legs;
            for (let i = 0; i < legs.length; i++) {
                totalDistance += legs[i].distance.value; // 距離をメートルで取得
            }
            totalDistance = totalDistance / 1000; // キロメートルに変換

            console.log('Total Distance: ' + totalDistance + ' km');
        });
    }

    function generateRandomWaypoints(startLocation, numberOfWaypoints) {
        let waypoints = [];
        for (let i = 0; i < numberOfWaypoints; i++) {
            let randomLat = startLocation.lat() + (Math.random() - 0.5) * 0.02;
            let randomLng = startLocation.lng() + (Math.random() - 0.5) * 0.02;
            waypoints.push(new google.maps.LatLng(randomLat, randomLng));
        }
        return waypoints;
    }

    function computeTotalDistance(route) {
        let total = 0;
        let legs = route.legs;
        for (let i = 0; i < legs.length; i++) {
            total += legs[i].distance.value;
        }
        return total / 1000;  // メートルをキロメートルに変換
    }


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
