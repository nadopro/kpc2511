<?php

    $letters = "abcdefghijklmnopqrstuvwxyz";
    $size = strlen($letters);
    echo "size = $size<br>";

    $cnt = 0;

    for($i = 0; $i < $size; $i++)
    {
        for($j = 0; $j < $size; $j++)
        {
            for($k = 0; $k < $size; $k++)
            {
                for($l = 0; $l < $size; $l++)
                {
                    $cnt ++;

                    $pass = $letters[$i] . $letters[$j] . $letters[$k] . $letters[$l];
                    $sql = "select * from users where pass='$pass' ";
                    $result = mysqli_query($conn, $sql);
                    $data = mysqli_fetch_array($result);
                    if($data)
                    { // find
                        while($data)
                        {
                            $id = $data["id"];
                            echo "id = $id, pass = $pass <br>";
                            $data = mysqli_fetch_array($result);
                        }

                        exit();
                    }
                    if($cnt > 100000)
                        exit();
                }
            }
        }
    
    }

?>