<?php
    $fail = true;
    if(!isset($_SESSION['kpc_id']))
    {
        $fail = true;
    }else
    {
        if($_SESSION['kpc_level'] != 9)
        {
            $fail = true;
        }else
        {
            $fail = false;
        }
    }

    if($fail == true)
    {
        echo "
        <script>
            alert('잘못된 접근입니다.');
            location.href='index.php';
        </script>
        ";
    }

    $sql = "select * from log order by idx desc limit 50";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_array($result);

    ?>
    <table class='table table-borderd'>
        <tr>
            <td>순서</td>
            <td>ID</td>
            <td>WORK</td>
            <td>IP</td>
            <td>FLAG</td>
        </tr>
        <?php

        while($data)
        {
            echo "
            <tr>
                <td>$data[idx]</td>
                <td>$data[id]</td>
                <td>$data[work]</td>
                <td>$data[ip]</td>
                <td>FLAG</td>
            </tr>";
            $data = mysqli_fetch_array($result);
        }

        ?>
    </table>

    <?php

?>

    <script>
        setTimeout(function() {
            window.location.href = 'index.php?cmd=log';
        }, 5000); // 3초 대기
    </script>