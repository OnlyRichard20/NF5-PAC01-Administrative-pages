<?php
$db = mysqli_connect('localhost', 'root') or 
    die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($db, 'moviesite') or die(mysqli_error($db));

if ($_GET['action'] == 'edit') {
    //retrieve the record's information 
    $query = 'SELECT
            people_fullname, people_isactor, people_isdirector
        FROM
            people
        WHERE
            people_id = ' . $_GET['id'];
    $result = mysqli_query($db, $query) or die(mysqli_error($db));
    extract(mysqli_fetch_assoc($result));
} else {
    //set values to blank
    $people_fullname = '';
    $people_isactor = 0;
    $people_isdirector = 0;
}
?>

<html>
 <head>
  <title><?php echo ucfirst($_GET['action']); ?> People</title>
 </head>
 <body>
  <form action="commit.php?action=<?php echo $_GET['action']; ?>&type=people"method="post">
   <table>
    <tr>
     <td>People Name</td>
     <td><input type="text" name="people_fullname"
      value="<?php echo $people_fullname; ?>"/></td>
    </tr><tr>
        <td>Actor</td>
        <td><select name="people_isactor">

<?php
// select the movie type information
$query = 'SELECT DISTINCT
        people_isactor
    FROM
        people
    LIMIT 
        2';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $value) {
        if ($row['people_isactor'] == $people_isactor) {
            echo '<option value="' . $row['people_isactor'] .
                '" selected="selected">';
        } else {
            echo '<option value="' . $row['people_isactor'] . '">';
        }
        echo $row['people_isactor'] . '</option>';
    }
}
?>
        </select></td>
    </tr><tr>
        <td>Director</td>
        <td><select name="people_isdirector">

<?php
// select the movie type information
$query = 'SELECT DISTINCT
        people_isdirector
    FROM
        people
    LIMIT 
        2';
$result = mysqli_query($db, $query) or die(mysqli_error($db));

// populate the select options with the results
while ($row = mysqli_fetch_assoc($result)) {
    foreach ($row as $value) {
        if ($row['people_isdirector'] == $people_isdirector) {
            echo '<option value="' . $row['people_isdirector'] .
                '" selected="selected">';
        } else {
            echo '<option value="' . $row['people_isdirector'] . '">';
        }
        echo $row['people_isdirector'] . '</option>';
    }
}
?>

        </select></td>
    </tr><tr>
     <td colspan="2" style="text-align: center;">
<?php
if ($_GET['action'] == 'edit') {
    echo '<input type="hidden" value="' . $_GET['id'] . '" name="people_id" />';
}
?>
      <input type="submit" name="submit"
       value="<?php echo ucfirst($_GET['action']); ?>" />
     </td>
    </tr>
   </table>
  </form>
 </body>
</html>

