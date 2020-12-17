<?php
//if session uname is not set, go to home
if (!isset($_SESSION['uname'])) {
    header('Location:' . BASE . 'index');
}
//include header
include 'header.tpl.php';

?>
<!-- main -->
<main>
    <div class="container">
        <!--Select Task-->
        <h1>Tasks List</h1>
        <hr>
        <br>

        <form action="<?= BASE ?>dashboard/selectTask" method="POST">
            Show tasks: <input type="submit" name="show" value="Show tasks">
        </form>
        <?php
        if (isset($_POST["show"])) {
            if (isset($data)) {
                if (count($data) > 0) {
        ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Task</th>
                                <th>Date</th>
                                <th>Delete</th>
                                <th>Modify</th>
                            </tr>

                        </thead>
                        <?php

                        foreach ($data as $valor) {
                            echo "<tr>";
                            foreach ($valor as $key => $value) {
                                if ($key == "id") {
                                    $idT = $value;
                                }
                                echo "<td>" . $value . "</td>";
                            }
                            echo "<td><form action='" . BASE . "dashboard/deleteTask' method='POST'><input type='submit' value='x'> <input type='hidden' name='idT' value='$idT'></form></td>";
                            echo "<td><form method='POST'><input type='submit' name='modify' value='m'><input type='hidden' name='idT' value='$idT'></form></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo"Your user don't have tasks";
                    }
                    ?>
                    </table>
                <?php
            }
        }
        if (isset($_POST['modify'])) {
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Date</th>
                            <th>Confirm</th>
                        </tr>
                    </thead>
                    <tr>
                        <form action="<?= BASE ?>dashboard/modifyTask" method="POST">
                            <?php
                            foreach ($data as $valor) {
                                echo "<tr>";
                                foreach ($valor as $key => $value) {
                                    if ($key == "id") {
                                        $idT = $value;
                                    }
                                    if ($_POST['idT'] == $idT) {
                                        echo "<input type='hidden' name='changedIdT' value=$idT>";
                                        if ($key == "due_date") {
                                            echo "<td><input type='date' name='changedDate' value=$value></td>";
                                            echo "<td><input type='submit' value='ready'></td>";
                                        } else if ($key == "description") {
                                            echo "<td><input type='text' name='changedDesc' value=$value></td>";
                                        }
                                    }
                                }
                                echo "</tr>";
                            }
                            ?>

                        </form>
                    </tr>
                </table>
            <?php
        }
        echo "<br><br><form method='POST'>Add new task: <input type='submit' name='insertT' value='Add'></form>";
        if (isset($_POST['insertT'])) {
            ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Task</th>
                            <th>Date</th>
                            <th>Confirm</th>
                        </tr>
                    </thead>
                    <tr>
                        <form action="<?= BASE ?>dashboard/insertTask" method="POST">
                            <td><input required type="text" name="desc"></td>
                            <td><input required type="date" name="date"></td>
                            <td><input type="submit" value="ready"></td>
                        </form>
                    </tr>
                </table>
            <?php
        }
            ?>
    </div>
</main>
<!-- end main -->
<?php
include 'footer.tpl.php';
?>