<?php
    if(isset($_POST["ip"]))
    {
        $ip = $_POST["ip"];
    }else
    {
        $ip = "175.114.70.15";
    }
?>
<form method="post" action="index.php?cmd=gps">
    <div class="row">
        <div class="col-2 text-end">IP</div>
        <div class="col">
            <input type="text" name="ip"  class="form-control" value="<?php echo $ip?>" placeholder="IP 주소 입력">
        </div>
        <div class="col-2 text-end">
            <button type="submit" class='btn btn-primary'>검색</button>
        </div>
    </div>
</form>

<?php
    if(isset($_POST["ip"]))
    {
        $ip = $_POST["ip"];

        $URL = "http://ip-api.com/json/$ip";
        //$URL = "https://search.naver.com/search.naver?ssc=tab.news.all&where=news&sm=tab_jum&query=%EC%82%BC%EC%84%B1%EC%A0%84%EC%9E%90";

        $curl = curl_init(); 
        curl_setopt($curl, CURLOPT_URL, $URL);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // 요청결과를 문자열로 반환
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 원격서버의 인증서 유효성 검사
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/110.0.0.0 Safari/537.36"
        ]);
        $response = curl_exec($curl);
    }

    $pretty = json_encode(json_decode($response, true), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
?>

    <div class="row">
        <div class="col colLine">
            <textarea class="form-control" rows="10"><?php echo htmlspecialchars($pretty) ?></textarea>
        </div>
    </div>

<?php
    $data = json_decode($response, true);

    if($data['status'] == "success")
    {
        $lat = $data['lat'];
        $lon = $data['lon'];
        $country = $data['country'];
        $countryCode = $data['countryCode']; // KR, JP, UK
        $region = $data['regionName'];
        $isp = $data['isp'];

        $key = "$lat , $lon";
        
        ?>
        <div class="row">
            <div class="col-2 colLine text-end">국가</div>
            <div class="col colLine "><?php echo $country?> (<?php echo $countryCode?>) </div>
        </div>
        <div class="row">
            <div class="col-2 colLine  text-end">도시</div>
            <div class="col colLine "><?php echo $region?></div>
        </div>
        <div class="row">
            <div class="col-2 colLine  text-end">경도(Lon)</div>
            <div class="col colLine "><?php echo $lon?></div>
        </div>
        <div class="row">
            <div class="col-2 colLine  text-end">위도(Lat)</div>
            <div class="col colLine "><?php echo $lat?></div>
        </div>
        <div class="row">
            <div class="col-2 colLine  text-end">ISP</div>
            <div class="col colLine "><?php echo $isp?></div>
        </div>
        <div class="row">
            <div class="col-2 colLine  text-end">검색</div>
            <div class="col colLine "><?php echo $key?>
        
            <button type="button" class="btn btn-sm btn-primary" onClick="window.open('https://www.google.com/maps?q=<?php echo $key?>', 'MYGPS', 'resizable=yes scrollbars=yes width=1200 height=1000')"><span class="material-icons">search</span>
            </button>
        </div>
        </div>
        <?php

        // google.com/maps 여기에 검색어로 검색
        // https://www.google.com/maps?q=37.5665,126.9780
    }
?>