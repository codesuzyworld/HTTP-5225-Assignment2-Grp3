<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('includes/database.php');
include('includes/config.php');
include('includes/functions.php');

secure();

if (isset($_POST['title'])) {

    if ($_POST['title'] && $_POST['content']) {

        $query = 'INSERT INTO events (
            title,
            content,
            type,
            dateStart,
            dateEnd,
            timeStart,
            timeEnd,
            locationID,
            eventLink
        ) VALUES (
            "' . mysqli_real_escape_string($connect, $_POST['title']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['content']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['type']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['dateStart']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['dateEnd']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['timeStart']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['timeEnd']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['locationID']) . '",
            "' . mysqli_real_escape_string($connect, $_POST['eventLink']) . '"
        )';
        
        mysqli_query($connect, $query);

        set_message('Event has been added');
    } else {
        echo "Error: " . mysqli_error($connect); // This line displays any SQL errors
    }

    header('Location: events.php');
    die();
}

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
        <h2 class="mb-0">Add Event</h2>
        <a href="events.php" class="btn btn-secondary"><i class="fas fa-arrow-circle-left"></i> Return to Event List</a>
    </div>

    <!-- Event Adding Form -->
    <div class="card shadow-sm custom-bg">
        <div class="card-body">
            <form method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title:</label>
                    <input type="text" name="title" id="title" class="form-control" maxlength="100" required>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content:</label>
                    <textarea name="content" id="content" rows="5" class="form-control" required></textarea>
                </div>

                <div class="mb-3">
                    <label for="type" class="form-label">Type:</label>
                    <select name="type" id="type" class="form-select">
                        <?php
                        $values = array('Conference', 'Webinar', 'Concert', 'Meetup', 'Network');
                        foreach ($values as $value) {
                            echo '<option value="' . $value . '">' . $value . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="dateStart" class="form-label">Start Date:</label>
                        <input type="date" name="dateStart" id="dateStart" class="form-control" required>
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="dateEnd" class="form-label">End Date:</label>
                        <input type="date" name="dateEnd" id="dateEnd" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="timeStart" class="form-label">Start Time:</label>
                        <input type="time" name="timeStart" id="timeStart" class="form-control">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label for="timeEnd" class="form-label">End Time:</label>
                        <input type="time" name="timeEnd" id="timeEnd" class="form-control">
                    </div>
                </div>

                <div class="mb-3">
                    <label for="locationID" class="form-label">Location:</label>
                    <select name="locationID" id="locationID" class="form-select">
                        <?php
                        // Query to fetch locations from the database
                        $location_query = 'SELECT id, locationName FROM location';
                        $location_result = mysqli_query($connect, $location_query);

                        while ($location = mysqli_fetch_assoc($location_result)) {
                            echo '<option value="' . $location['id'] . '">' . $location['locationName'] . '</option>';
                        }
                        ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="eventLink" class="form-label">Event Link:</label>
                    <input type="url" name="eventLink" id="eventLink" class="form-control" maxlength="255">
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Add Event</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>