<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MapController extends Controller
{
    public function map(Request $request)
    {
        // $GRAPH_HOPPER_API_KEY = config('services.graphhopper.api_key');

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // 入力の処理
            $lat = $request->input('lat');
            $lon = $request->input('lon');
            $per = $request->input('per');

            // 入力オプション
            $start_pos = "$lat," . "%20" . "$lon";  // ルート生成開始位置(緯度,軽度)
            $perimeter = $per * 1000;   // 走行想定距離

            mt_srand();
            // $seed = rand(0, 2 * 63 - 1);
            $seed = rand(0, 1000000);

            $url = "https://graphhopper.com/api/1/route?point=$start_pos&profile=foot&ch.disable=true&pass_through=true&algorithm=round_trip&round_trip.distance=$perimeter&round_trip.seed=$seed&key=$GRAPH_HOPPER_API_KEY&type=gpx";


            $res = file_get_contents($url);
            $gpx = simplexml_load_string($res);

            // GPXファイルを変換
            $routeNodes = $gpx->rte->rtept;

            $points = [];
            foreach ($routeNodes as $node) {
                $points[] = [
                    'lat' => (string) $node['lat'],
                    'lon' => (string) $node['lon']
                ];
            }

            // 経由地の数
            $waypoint = 9;

            $pickup_idx = [];
            // 均等に配置
            for ($i = 0; $i < $waypoint; $i++) {
                $pickup_idx[] = intval($i / ($waypoint - 1) * (count($points) - 1));
            }

            return response()->json(['points' => $points, 'waypoints' => $waypoint, 'pickupIdx' => $pickup_idx]);
        }
    }
}
