<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (!isset($_GET['id'])) {
    header('Location: events.php');
    die();
}

if (isset($_POST['title'])) {
    if ($_POST['title'] && $_POST['content']) {
        $query = 'UPDATE events SET
            title = "' . mysqli_real_escape_string($connect, $_POST['title']) . '",
            content = "' . mysqli_real_escape_string($connect, $_POST['content']) . '",
            type = "' . mysqli_real_escape_string($connect, $_POST['type']) . '",
            dateStart = "' . mysqli_real_escape_string($connect, $_POST['dateStart']) . '",
            dateEnd = "' . mysqli_real_escape_string($connect, $_POST['dateEnd']) . '",
            timeStart = "' . mysqli_real_escape_string($connect, $_POST['timeStart']) . '",
            timeEnd = "' . mysqli_real_escape_string($connect, $_POST['timeEnd']) . '",
            locationID = "' . mysqli_real_escape_string($connect, $_POST['locationID']) . '",
            eventLink = "' . mysqli_real_escape_string($connect, $_POST['eventLink']) . '"
            WHERE id = ' . $_GET['id'] . '
            LIMIT 1';
        
        mysqli_query($connect, $query);

        set_message('Event has been updated');
        header('Location: events.php');
        die();
    }
}

$query = 'SELECT * FROM events WHERE id = ' . $_GET['id'] . ' LIMIT 1';
$result = mysqli_query($connect, $query);

if (!mysqli_num_rows($result)) {
    header('Location: events.php');
    die();
}

$record = mysqli_fetch_assoc($result);

include('includes/header.php');
?>

<h2>Edit Event</h2>

<form method="post">

    <label for="title">Title:</label>
    <input type="text" name="title" id="title" value="<?php echo htmlentities($record['title']); ?>" required>
    <br>

    <label for="content">Content:</label>
    <textarea name="content" id="content" rows="10" required><?php echo htmlentities($record['content']); ?></textarea>
    <br>

    <label for="type">Type:</label>
    <?php
    $values = array('Conference', 'Webinar', 'Concert', 'Meetup', 'Network');
    echo '<select name="type" id="type">';
    foreach ($values as $value) {
        echo '<option value="' . $value . '"';
        if ($value == $record['type']) echo ' selected="selected"';
        echo '>' . $value . '</option>';
    }
    echo '</select>';
    ?>
    <br>

    <label for="dateStart">Start Date:</label>
    <input type="date" name="dateStart" id="dateStart" value="<?php echo htmlentities($record['dateStart']); ?>" required>
    <br>

    <label for="dateEnd">End Date:</label>
    <input type="date" name="dateEnd" id="dateEnd" value="<?php echo htmlentities($record['dateEnd']); ?>">
    <br>

    <label for="timeStart">Start Time:</label>
    <input type="time" name="timeStart" id="timeStart" value="<?php echo htmlentities($record['timeStart']); ?>">
    <br>

    <label for="timeEnd">End Time:</label>
    <input type="time" name="timeEnd" id="timeEnd" value="<?php echo htmlentities($record['timeEnd']); ?>">
    <br>

    <label for="locationID">Location:</label>
    <select name="locationID" id="locationID">
        <?php
        $location_query = 'SELECT id, locationName FROM location';
        $location_result = mysqli_query($connect, $location_query);
        while ($location = mysqli_fetch_assoc($location_result)) {
            echo '<option value="' . $location['id'] . '"';
            if ($location['id'] == $record['locationID']) echo ' selected="selected"';
            echo '>' . $location['locationName'] . '</option>';
        }
        ?>
    </select>
    <br>

    <label for="eventLink">Event Link:</label>
    <input type="url" name="eventLink" id="eventLink" value="<?php echo htmlentities($record['eventLink']); ?>">
    <br>

    <input type="submit" value="Update Event">
</form>

<p><a href="events.php"><i class="fas fa-arrow-circle-left"></i> Return to Event List</a></p>

<?php include('includes/footer.php'); ?>