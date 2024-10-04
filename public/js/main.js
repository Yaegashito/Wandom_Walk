"use strict";

{
  /* global google */

  // ブラウザバック等に警告
  let isWalking = false;
  window.addEventListener("beforeunload", (e) => {
    if (isWalking) {
      e.preventDefault();
      return "";
    }
  });

  // walk
  const csrfToken = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
  } else {
    alert("Geolocation is not supported by this browser.");
  }

  const distance = document.querySelector("#distance");
  const [generateRouteBtn, regenerateRouteBtn] =
    document.querySelectorAll(".generate-route");
  const decideRoute = document.querySelector("#decide-route");
  const startBtn = document.querySelector("#start-btn");
  const finishBtn = document.querySelector("#finish-btn");
  const stopBtn = document.querySelector("#stop-btn");
  const walkBelongings = document.querySelector("#walk-belongings");
  const walkBtns = document.querySelectorAll(".walk-btns > .btn");
  const messages = document.querySelectorAll("#messages > p");
  const DISTANCE_RESULT = 0;
  const TIME_RESULT = 1;

  function stopWalk() {
    navigator.geolocation.getCurrentPosition(showPosition);
    walkBtns.forEach((walkBtn) => {
      walkBtn.style.display = "none";
    });
    walkBelongings.style.display = "none";
    stopBtn.classList.add("hide");
    generateRouteBtn.style.display = "inline";
    distance.style.display = "inline";
    isWalking = false;
    messages.forEach((message) => {
      message.style.display = "none";
    });
  }

  generateRouteBtn.addEventListener("click", () => {
    if (distance.value === "") {
      alert("時間を選択してください");
      return;
    }
    generateRouteBtn.style.display = "none";
    regenerateRouteBtn.style.display = "inline";
    decideRoute.style.display = "inline";
    messages[DISTANCE_RESULT].style.display = "block";
    distance.style.display = "none";
    stopBtn.classList.remove("hide");
  });
  decideRoute.addEventListener("click", () => {
    regenerateRouteBtn.style.display = "none";
    decideRoute.style.display = "none";
    startBtn.style.display = "inline";
    walkBelongings.style.display = "block";
  });
  startBtn.addEventListener("click", () => {
    startBtn.style.display = "none";
    walkBelongings.style.display = "none";
    finishBtn.style.display = "inline";
    messages[DISTANCE_RESULT].style.display = "none";
    messages[TIME_RESULT].style.display = "block";
    isWalking = true;
  });
  finishBtn.addEventListener("click", async (event) => {
    event.preventDefault();
    if (!confirm("本当に家に着きましたか？")) {
      return;
    }
    let isStored = false;
    while (!isStored) {
      try {
        const response = await fetch("storeCalendar", {
          method: "POST",
          headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": csrfToken,
          },
          body: JSON.stringify({}),
        });
        const data = await response.json();
        if (data.success) {
          alert(`今日の散歩が記録されました`);
        }

        stopWalk();
        finishBtn.style.display = "none";
        // カレンダーの今日の日付に着色する処理
        document
          .querySelector("#calendar .tbody td.today")
          .classList.add("done");
        isStored = true;
      } catch (error) {
        alert("今日の散歩を記録できませんでした。もう一度記録を試みます");
        console.log(error.message);
      }
    }
  });

  stopBtn.addEventListener("click", () => {
    if (finishBtn.style.display === "inline") {
      if (!confirm("今日の散歩は記録されません。本当にやめますか？")) {
        return;
      }
    }
    if (stopBtn.classList.contains("hide") === false) {
      stopWalk();
      generateRouteBtn.style.display = "inline";
    }
  });

  function showPosition(position) {
    let lat = position.coords.latitude;
    let lng = position.coords.longitude;
    initMap(lat, lng);

    document
      .querySelectorAll(".generate-route")
      .forEach((generateRouteButton) => {
        generateRouteButton.addEventListener("click", () => {
          if (document.querySelector("#distance").value === "") {
            return;
          }
          const targetDistance = parseFloat(
            document.getElementById("distance").value,
          );
          // const startLocation = new google.maps.LatLng(35.6895, 139.6917);  // 東京を初期地点に設定
          const startLocation = new google.maps.LatLng(lat, lng); // 現在地を初期地点に設定
          generateRoute(startLocation, targetDistance); // 入力された距離を使って経路を生成
        });
      });
  }

  let map, directionsService, directionsRenderer;

  async function initMap(lat, lng) {
    const { Map } = await google.maps.importLibrary("maps");
    map = new Map(document.getElementById("map"), {
      // center: { lat: 35.6895, lng: 139.6917 },  // 東京を初期地点に設定
      center: new google.maps.LatLng(lat, lng), // 現在地を初期地点に設定
      zoom: 16,
      mapId: "DEMO_MAP_ID",
      streetViewControl: false,
      mapTypeControl: false,
      fullscreenControl: false,
    });

    await google.maps.importLibrary("marker");

    new google.maps.marker.AdvancedMarkerElement({
      position: new google.maps.LatLng(lat, lng),
      map: map,
      content: (function () {
        const div = document.createElement("div");
        div.style.width = "12px";
        div.style.height = "12px";
        div.style.backgroundColor = "#115EC3";
        div.style.borderRadius = "50%";
        div.style.border = "2px solid white";
        return div;
      })(),
    });

    directionsService = new google.maps.DirectionsService();
    directionsRenderer = new google.maps.DirectionsRenderer({
      // suppressMarkers: true, //経由地のピンを非表示
      polylineOptions: {
        strokeColor: "blue", // ポリラインの色を青に設定
        strokeWeight: 2, // ポリラインの太さを設定
        icons: [
          {
            icon: {
              path: google.maps.SymbolPath.FORWARD_OPEN_ARROW,
              scale: 3,
              strokeColor: "red",
            },
            offset: "100%",
            repeat: "100px",
          },
        ],
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
    let waypoints = generateRandomWaypoints(
      startLocation,
      numberOfWaypoints,
      rangeOfWaypoint,
    ); // ランダムなウェイポイントを生成
    waypoints.push(startLocation); // スタート地点に戻る

    directionsService.route(
      {
        origin: startLocation,
        destination: startLocation,
        waypoints: waypoints.map((location) => ({
          location: location,
          stopover: true,
        })),
        travelMode: "WALKING",
      },
      function (response, status) {
        let totalDistance;
        if (status === "OK") {
          directionsRenderer.setDirections(response);
          let route = response.routes[0];
          totalDistance = computeTotalDistance(route);
          if (Math.abs(totalDistance - targetDistance) > rangeOfDistance) {
            // 距離が入力値に近くなるように調整
            console.log("再度ウェイポイントを調整して経路を生成");
            generateRoute(startLocation, targetDistance);
          }
        } else {
          console.error("Directions request failed due to " + status);
        }

        // 距離を表示
        totalDistance = Math.round(totalDistance * 10) / 10; // 小数第2位を四捨五入
        document.querySelector("#distance-result").textContent = totalDistance;

        // 予想時間を表示
        const AVERAGE_WALKING_SPEED = 4.8;
        let totalHours = totalDistance / AVERAGE_WALKING_SPEED;
        let hours = Math.floor(totalHours);
        let minutes = Math.round((totalHours - hours) * 60);
        hours =
          Math.floor(totalHours) !== 0 ? `${Math.floor(totalHours)}時間` : "";
        document.querySelector("#time-result").textContent = hours + minutes;
      },
    );
  }

  function generateRandomWaypoints(
    startLocation,
    numberOfWaypoints,
    rangeOfWaypoint,
  ) {
    let waypoints = [];
    for (let i = 0; i < numberOfWaypoints; i++) {
      let randomLat =
        startLocation.lat() + (Math.random() - 0.5) * rangeOfWaypoint;
      let randomLng =
        startLocation.lng() + (Math.random() - 0.5) * rangeOfWaypoint;
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
    return total / 1000; // メートルをキロメートルに変換
  }

  // calendar
  const today = new Date();
  let year = today.getFullYear();
  let month = today.getMonth();

  function getCalendarHead() {
    const dates = [];
    const d = new Date(year, month, 0).getDate();
    const n = new Date(year, month, 1).getDay();

    for (let i = 0; i < n; i++) {
      dates.unshift({
        date: d - i,
        isToday: false,
        isDisabled: true,
        // uniqueDate: `${year}-${String(month).padStart(2, '0')}-${String(d - i).padStart(2, '0')}`,
        uniqueDate: new Date(year, month - 1, d - i)
          .toLocaleDateString("ja-JP", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
          })
          .replaceAll("/", "-"),
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
        // uniqueDate: `${year}-${String(month + 1).padStart(2, '0')}-${String(i).padStart(2, '0')}`,
        uniqueDate: new Date(year, month, i)
          .toLocaleDateString("ja-JP", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
          })
          .replaceAll("/", "-"),
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
        // uniqueDate: `${year}-${String(month + 2).padStart(2, '0')}-${String(i).padStart(2, '0')}`
        uniqueDate: new Date(year, month + 1, i)
          .toLocaleDateString("ja-JP", {
            year: "numeric",
            month: "2-digit",
            day: "2-digit",
          })
          .replaceAll("/", "-"),
      });
    }
    return dates;
  }

  function clearCalendar() {
    const tbody = document.querySelector(".tbody");

    while (tbody.firstChild) {
      tbody.removeChild(tbody.firstChild);
    }
  }

  function renderTitle() {
    const title = `${year}年${String(month + 1)}月`;
    document.querySelector("#title").textContent = title;
  }

  async function renderWeeks() {
    const dates = [
      ...getCalendarHead(),
      ...getCalendarBody(),
      ...getCalendarTail(),
    ];
    const weeks = [];
    const weeksCount = dates.length / 7;

    for (let i = 0; i < weeksCount; i++) {
      weeks.push(dates.splice(0, 7));
    }

    const response = await fetch("changeCalendar", {
      method: "POST",
      headers: {
        "X-CSRF-TOKEN": csrfToken,
      },
      body: new URLSearchParams({
        year: year,
        month: month + 1,
        date: new Date().getDate(),
      }),
    });
    const records = await response.json();
    const dateOfRecords = [];
    records["records"].forEach((record) => {
      dateOfRecords.push(record["date"]);
    });

    weeks.forEach((week) => {
      const tr = document.createElement("tr");
      week.forEach((date) => {
        const td = document.createElement("td");
        td.textContent = date.date;
        if (date.isToday) {
          td.classList.add("today");
        }
        if (date.isDisabled) {
          td.classList.add("disabled");
        }
        if (dateOfRecords.includes(date.uniqueDate)) {
          td.classList.add("done");
        }
        tr.appendChild(td);
      });
      document.querySelector(".tbody").appendChild(tr);
    });
  }

  function createCalendar() {
    clearCalendar();
    renderTitle();
    renderWeeks();
  }

  document.querySelector("#prev").addEventListener("click", () => {
    month--;
    if (month < 0) {
      year--;
      month = 11;
    }
    createCalendar();
  });

  document.querySelector("#next").addEventListener("click", () => {
    month++;
    if (month > 11) {
      year++;
      month = 0;
    }
    createCalendar();
  });

  document.querySelector("#today").addEventListener("click", () => {
    year = today.getFullYear();
    month = today.getMonth();
    createCalendar();
  });

  createCalendar();

  // belongings

  // 追加の非同期処理
  const input = document.querySelector('[name="belonging"]');
  const ul = document.querySelector("#belongings ul");

  // イベントの伝播により、作成直後のliを削除可能に
  ul.addEventListener("click", (e) => {
    const belonging = e.target.dataset.id;
    if (e.target.classList.contains("delete")) {
      if (!confirm("削除しますか？")) {
        return;
      }
      fetch(`belonging/${belonging}`, {
        method: "DELETE",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
        },
      });
      // 持ち物リストから削除
      e.target.parentNode.remove();
      // 持ち物確認画面から削除
      const text = e.target.parentNode.firstChild.textContent.trim();
      document.querySelectorAll("#walk #walk-belongings li").forEach((li) => {
        if (li.textContent.trim() === text) {
          li.remove();
        }
      });
    }
  });

  function addBelonging(id, title) {
    // 持ち物リストに追加
    const li = document.createElement("li");
    const span = document.createElement("span");
    span.classList.add("delete");
    span.dataset.id = id;
    span.textContent = "削除";
    li.textContent = title;
    li.appendChild(span);
    ul.appendChild(li);
    // 持ち物確認画面に追加
    const topLi = document.createElement("li");
    topLi.textContent = title;
    document.querySelector("#walk #walk-belongings ul").appendChild(topLi);
  }

  document
    .querySelector("#belongings > form")
    .addEventListener("submit", async (event) => {
      event.preventDefault();
      const title = input.value.trim();
      if (title) {
        const response = await fetch("belonging", {
          method: "POST",
          headers: {
            "X-CSRF-TOKEN": csrfToken,
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: new URLSearchParams({
            belonging: title,
          }),
        });
        const json = await response.json();
        addBelonging(json.id, title);

        input.value = "";
        input.focus();
      }
    });

  // config
  const dts = document.querySelectorAll("dt");
  dts.forEach((dt) => {
    dt.addEventListener("click", () => {
      dt.parentNode.classList.toggle("appear");
      dts.forEach((el) => {
        if (dt !== el) {
          el.parentNode.classList.remove("appear");
        }
      });
    });
  });

  // ご意見送信フォーム
  const textarea = document.querySelector("#opinion");
  const opinionBtn = document.querySelector("#opinion-btn");
  const thanks = document.querySelector("#thanks");
  const opinionSubmit = document.querySelector("#opinion-submit");
  opinionBtn.addEventListener("click", () => {
    const opinion = textarea.value.trim();
    if (opinion) {
      fetch("submitOpinion", {
        method: "POST",
        headers: {
          "X-CSRF-TOKEN": csrfToken,
          "Content-Type": "application/x-www-form-urlencoded",
        },
        body: new URLSearchParams({
          opinion: opinion,
        }),
      });
      opinionSubmit.style.display = "none";
      thanks.style.display = "block";
    }
  });

  // footer
  const mains = document.querySelectorAll("main > div");
  const menus = document.querySelectorAll("footer ul li");

  menus.forEach((menu, i) => {
    menu.addEventListener("click", () => {
      mains.forEach((main, j) => {
        main.style.display = "none";
        if (i === j) {
          main.style.display = "block";
        }
      });
      menus.forEach((menu) => {
        menu.style.background = "#fff";
        menu.style.color = "#000";
      });
      menu.style.background = "#111";
      menu.style.color = "#fff";
    });
  });
}
