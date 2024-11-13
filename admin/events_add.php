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

<h2>Add Event</h2>

<form method="post">

    <label for="title">Title:</label>
    <input type="text" name="title" id="title" maxlength="100" required>
    <br>
    
    <label for="content">Content:</label>
    <textarea name="content" id="content" rows="10" required></textarea>
    
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .then(editor => {
                console.log(editor);
            })
            .catch(error => {
                console.error(error);
            });
    </script>
    
    <br>

    <label for="type">Type:</label>
    <?php
        $values = array('Conference', 'Webinar', 'Concert', 'Meetup', 'Network');
        
        echo '<select name="type" id="type">';
        foreach ($values as $value) {
            echo '<option value="' . $value . '">' . $value . '</option>';
        }
        echo '</select>';
    ?>

    <br>
    
    <label for="dateStart">Start Date:</label>
    <input type="date" name="dateStart" id="dateStart" required>
    
    <br>

    <label for="dateEnd">End Date:</label>
    <input type="date" name="dateEnd" id="dateEnd">
    
    <br>

    <label for="timeStart">Start Time:</label>
    <input type="time" name="timeStart" id="timeStart">
    
    <br>

    <label for="timeEnd">End Time:</label>
    <input type="time" name="timeEnd" id="timeEnd">
    
    <br>

    <label for="locationID">Location:</label>
    <select name="locationID" id="locationID">
        <?php
        // Query to fetch locations from the database
        $location_query = 'SELECT id, locationName FROM location';
        $location_result = mysqli_query($connect, $location_query);

        while ($location = mysqli_fetch_assoc($location_result)) {
            echo '<option value="' . $location['id'] . '">' . $location['locationName'] . '</option>';
        }
        ?>
    </select>

    <br>

    <label for="eventLink">Event Link:</label>
    <input type="url" name="eventLink" id="eventLink" maxlength="255">

    <br>
    <input type="submit" value="Add Event">

</form>

<p><a href="events.php"><i class="fas fa-arrow-circle-left"></i> Return to Event List</a></p>

<?php include('includes/footer.php'); ?>