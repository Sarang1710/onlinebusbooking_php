
<form action="" method="post">
<div class="table-responsive-lg">
    <table class="table table-success">
        <thead>
            <tr>
                <th scope="col">Source</th>
                <th scope="col">Destination</th>
                <th scope="col">Cost</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (isset($_GET['bus_id'])) {
                $bus_id = $_GET['bus_id'];
                $query = "SELECT post_category_id,post_source,post_destination,post_via  FROM  posts WHERE post_id = {$bus_id}";
                $select_posts = mysqli_query($connection,$query);
                $row = mysqli_fetch_assoc($select_posts);
                $bus_stations = explode(" ",$row['post_via']);
                $n = 0;
                for ($i=0; $i <count($bus_stations) ; $i++) { 
                    for ($j=0; $j <$i ; $j++) { 
                        
                        echo "<tr><td scope='row'>
                        <input type='text' name = 'source$n' value = '$bus_stations[$j]' readonly style='border: none;'></td>
                        <td><input type='text' name = 'dest$n' value='$bus_stations[$i]' readonly style='border: none;'></td>
                        <td><input type='text' name = 'cost$n' required></td></tr>";
                        $n++;
                    }
                }
                echo "<input type = 'hidden' name = 'n' value = $n>";
            }
            ?>
            
        </tbody>
    </table>
</div>
<div class="text-center"><button type="submit" class="btn btn-primary">Submit</button></div>
</form>
<?php
if (isset($_GET['bus_id'])) {
    $bus_id = $_GET['bus_id'];
    $cat = $_GET['cat'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $src_arr = [];
        $des_arr = [];
        $cost_arr = [];
        for ($i=0; $i <$_POST['n'] ; $i++) { 
            $query = "INSERT INTO cost( start, stopage , category , cost) VALUES ( '{$_POST['source'.$i]}','{$_POST['dest'.$i]}',{$cat},{$_POST['cost'.$i]} )";
            $cost_entry = mysqli_query($connection,$query);

                if (!$cost_entry) {
                    die("Query Failed");
                }
            }
            
        echo "<small>Added Sucessfully ....!!!</small>";
    }
}
?>