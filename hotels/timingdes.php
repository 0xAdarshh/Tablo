    <?php
    
    require('../config/config.php');
    require('../config/db.php');

    session_start();
    $hid = $_GET["hid"];

    // Query to display current timing data
    $query = "select * from hoteltime where hid=$hid ORDER BY day";

    //Fire the Query
    $result = mysqli_query($conn, $query);

    //Get data into deatails object array (Associative Array)
    $details = mysqli_fetch_all($result,MYSQLI_ASSOC);

    //Free result
    mysqli_free_result($result);

    echo "<table>
         <tr>
            <th>ID</th>
            <th>Day</th>
            <th>STATUS</th>
            <th>OPENS</th>
            <th>CLOSES</th>
         </tr>";
     foreach($details as $detail) : 
     echo "<div>";
     echo "<tr>";
     echo "<td>" . $detail['hid'] . "</td>";
     echo "<td>";
        if($detail['day'] == '1'){ echo 'Sunday'; }
        elseif($detail['day'] == '2'){ echo 'Monday'; }
        elseif($detail['day'] == '3'){ echo 'Tuesday'; }
        elseif($detail['day'] == '4'){ echo 'Wednesday'; }
        elseif($detail['day'] == '5'){ echo 'Thursday'; }
        elseif($detail['day'] == '6'){ echo 'Friday'; }
        elseif($detail['day'] == '7'){ echo 'Saturday'; }
        echo "</td>";
        echo "<td>"; if($detail['status'] == '0'){echo 'CLOSED';}else{echo 'OPEN';} echo"</td>";
        echo "<td>"; if($detail['status'] == '1'){echo $detail['stime'];} echo "</td>";
        echo "<td>"; if($detail['status'] == '1'){echo $detail['etime'];} echo " </td>";
        echo "</tr> ";
        echo "</div><br>";
     endforeach;
    echo "</table>";

    ?>
