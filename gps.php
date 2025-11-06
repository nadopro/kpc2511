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
?>

    <div class="row">
        <div class="col colLine">
            <textarea class="form-control" rows="10"><?php echo $response?></textarea>
        </div>
    </div>