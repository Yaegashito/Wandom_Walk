'use strict';

{
    // walk
    // let lat;
    // let lng;

    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else {
        alert('Geolocation is not supported by this browser.');
    }

    const generateRouteBtns = document.querySelectorAll('.generate-route');
    const decideRoute = document.querySelector('#decide-route');
    const startBtn = document.querySelector('#start-btn');
    const finishBtn = document.querySelector('#finish-btn');
    const stopBtn = document.querySelector('#stop-btn');
    const walkBelongings = document.querySelector('#walk-belongings')
    const walkBtns = document.querySelectorAll('.walk-btns > .walk-btn');
    const messages = document.querySelectorAll('#messages > p');

    function stopWalk() {
        navigator.geolocation.getCurrentPosition(showPosition);
        walkBtns.forEach(walkBtn => {
            walkBtn.style.display = 'none';
        });
        walkBelongings.style.display = 'none';
        stopBtn.classList.add('hide');
        generateRouteBtns[0].style.display = 'inline';
        messages.forEach(message => {
            message.style.display = 'none';
        });
    }

    generateRouteBtns[0].addEventListener('click', () => {
        if (document.querySelector('#distance').value === '') {
            alert('時間を選択してください');
            return;
        }
        generateRouteBtns[0].style.display = 'none';
        generateRouteBtns[1].style.display = 'inline';
        decideRoute.style.display = 'inline';
        messages[0].style.display = 'block';
        stopBtn.classList.remove('hide');
    });
    decideRoute.addEventListener('click', () => {
        generateRouteBtns[1].style.display = 'none';
        decideRoute.style.display = 'none';
        startBtn.style.display = 'inline';
        walkBelongings.style.display = 'block';
    });
    startBtn.addEventListener('click', () => {
        startBtn.style.display = 'none';
        walkBelongings.style.display = 'none';
        finishBtn.style.display = 'inline';
        messages[0].style.display = 'none';
        messages[1].style.display = 'block';
    });
    finishBtn.addEventListener('click', () => {
        if (!confirm('本当に家に着きましたか？')) {
            return;
        }
        stopWalk();
        finishBtn.style,display = 'none';
        // カレンダーのdoneをtrueにする処理
    });
    stopBtn.addEventListener('click', () => {
        if (finishBtn.style.display === 'inline') {
            if (!confirm('今日の散歩は記録されません。本当にやめますか？')) {
                return;
            }
        }
        stopWalk();
        generateRouteBtns[0].style.display = 'inline';
    });

    function showPosition(position) {
        let lat = position.coords.latitude;
        let lng = position.coords.longitude;
        initMap(lat, lng);

        document.querySelectorAll('.generate-route').forEach(generateRouteButton => {
            generateRouteButton.addEventListener('click', () => {
                // event.preventDefault();
                if (document.querySelector('#distance').value === '') {
                    return;
                }
                const targetDistance = parseFloat(document.getElementById('distance').value);
                // const startLocation = new google.maps.LatLng(35.6895, 139.6917);  // 東京を初期地点に設定
                const startLocation = new google.maps.LatLng(lat, lng);  // 現在地を初期地点に設定
                generateRoute(startLocation, targetDistance);  // 入力された距離を使って経路を生成
            });
        })
    }

    let map, directionsService, directionsRenderer;

    async function initMap(lat, lng) {
        const { Map } = await google.maps.importLibrary('maps');
        map = new Map(document.getElementById('map'), {
            // center: { lat: 35.6895, lng: 139.6917 },  // 東京を初期地点に設定
            center: new google.maps.LatLng(lat, lng),  // 現在地を初期地点に設定
            zoom: 16,
            mapId: 'DEMO_MAP_ID',
            streetViewControl: false,
            mapTypeControl: false,
            fullscreenControl: false,
        });

        const { AdvancedMarkerElement, PinView } = await google.maps.importLibrary("marker");

        new google.maps.marker.AdvancedMarkerElement({
            position: new google.maps.LatLng(lat, lng),
            map: map,
            content: (function () {
                const div = document.createElement('div');
                div.style.width = '12px';
                div.style.height = '12px';
                div.style.backgroundColor = '#115EC3';
                div.style.borderRadius = '50%';
                div.style.border = '2px solid white';
                return div;
            })(),
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
        let numberOfWaypoints, rangeOfWaypoint, rangeOfDistance;
        switch (targetDistance) {
            case 3: //開発用
                numberOfWaypoints = 2;
                rangeOfWaypoint = 0.005;
                rangeOfDistance = 100;
                break;
            case 1:
                numberOfWaypoints = 2;
                rangeOfWaypoint = 0.005; // 微調整が必要
                rangeOfDistance = 0.2;
                break;
            case 2:
                numberOfWaypoints = 3;
                rangeOfWaypoint = 0.0077; // 微調整が必要
                rangeOfDistance = 0.4;
                break;
            case 4:
                numberOfWaypoints = 4;
                rangeOfWaypoint = 0.015; // 微調整が必要
                rangeOfDistance = 0.8;
                break;
        }
        let waypoints = generateRandomWaypoints(startLocation, numberOfWaypoints, rangeOfWaypoint);  // ランダムなウェイポイントを生成
        waypoints.push(startLocation);  // スタート地点に戻る

        directionsService.route({
            origin: startLocation,
            destination: startLocation,
            waypoints: waypoints.map(location => ({ location: location, stopover: true })),
            travelMode: 'WALKING'
        }, function (response, status) {
            let totalDistance;
            if (status === 'OK') {
                directionsRenderer.setDirections(response);
                let route = response.routes[0];
                totalDistance = computeTotalDistance(route);
                if (Math.abs(totalDistance - targetDistance) > rangeOfDistance) {  // 距離が入力値に近くなるように調整
                    console.log('再度ウェイポイントを調整して経路を生成');
                    generateRoute(startLocation, targetDistance);
                }
            } else {
                console.error('Directions request failed due to ' + status);
            }

            // 距離を表示
            totalDistance = Math.round(totalDistance * 10) / 10; // 小数第2位を四捨五入
            document.querySelector('#distance-result').textContent = totalDistance;

            // 予想時間を表示
            let totalHours = totalDistance / 4.8;
            let hours = Math.floor(totalHours);
            let minutes = Math.round((totalHours - hours) * 60);
            hours = Math.floor(totalHours) !== 0 ? `${Math.floor(totalHours)}時間` : '';
            document.querySelector('#time-result').textContent = hours + minutes;
        });
    }

    function generateRandomWaypoints(startLocation, numberOfWaypoints, rangeOfWaypoint) {
        let waypoints = [];
        for (let i = 0; i < numberOfWaypoints; i++) {
            let randomLat = startLocation.lat() + (Math.random() - 0.5) * rangeOfWaypoint;
            let randomLng = startLocation.lng() + (Math.random() - 0.5) * rangeOfWaypoint;
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
        const tbody = document.querySelector('.tbody');

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
            document.querySelector('.tbody').appendChild(tr);
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
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // 削除の非同期処理
    const deletes = document.querySelectorAll('.delete');
    deletes.forEach(span => {
        const belonging = span.dataset.id;
        span.addEventListener('click', () => {
            if (!confirm('削除しますか？')) {
                return;
            }
            fetch(`belonging/${belonging}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
            });
            span.parentNode.remove();
        });
    });

    // config
    const dts = document.querySelectorAll('dt');
    dts.forEach(dt => {
        dt.addEventListener('click', () => {
            dt.parentNode.classList.toggle('appear');
            dts.forEach(el => {
                if (dt !==el) {
                    el.parentNode.classList.remove('appear');
                }
            });
        });
    });

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
