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

<style>
    .custom-bg {
        background-color: #f0f2f2;
        padding: 20px;
    }
</style>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0">Edit Event</h2>
        <a href="events.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to Event List</a>
    </div>
    <div class="card shadow-sm custom-bg">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" name="title" id="title" value="<?php echo htmlentities($record['title']); ?>" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea name="content" id="content" rows="5" class="form-control" required><?php echo htmlentities($record['content']); ?></textarea>
                </div>
                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select name="type" id="type" class="form-select">
                        <?php
                        $values = array('Conference', 'Webinar', 'Concert', 'Meetup', 'Network');
                        foreach ($values as $value) {
                            echo '<option value="' . $value . '"';
                            if ($value == $record['type']) echo ' selected="selected"';
                            echo '>' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dateStart" class="form-label">Start Date:</label>
                        <input type="date" name="dateStart" id="dateStart" value="<?php echo htmlentities($record['dateStart']); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dateEnd" class="form-label">End Date:</label>
                        <input type="date" name="dateEnd" id="dateEnd" value="<?php echo htmlentities($record['dateEnd']); ?>" class="form-control">
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="timeStart" class="form-label">Start Time:</label>
                        <input type="time" name="timeStart" id="timeStart" value="<?php echo htmlentities($record['timeStart']); ?>" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="timeEnd" class="form-label">End Time:</label>
                        <input type="time" name="timeEnd" id="timeEnd" value="<?php echo htmlentities($record['timeEnd']); ?>" class="form-control">
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="locationID" class="form-label">Location:</label>
                    <select name="locationID" id="locationID" class="form-select">
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
                </div>
                <div class="mb-3">
                    <label for="eventLink" class="form-label">Event Link:</label>
                    <input type="url" name="eventLink" id="eventLink" value="<?php echo htmlentities($record['eventLink']); ?>" class="form-control">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Update Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>