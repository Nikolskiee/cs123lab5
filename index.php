<html>
    <head>
        <title>Lab 5</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    </head>
    <body>

    
    
    <!-- HEADER -->
    <nav class="navbar navbar-dark bg-dark mb-3">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Lab 5: PHP</a>
        </div>
    </nav>

    <?php
        $subjectErr = $roomErr = $emailErr = null;
        $subject = $room = $email = $btn = null;
        if($_SERVER["REQUEST_METHOD"] == "POST") {
            if(isset($_POST["remove"])) {
                $btn = $_POST["remove"];
            }
            else if(isset($_POST["email"])) {
                $email = test_input($_POST["email"]);
            }
            else {
                if(empty($_POST["subject"])) {
                    $subjectErr = "Subject is required. ";
                }
                else {
                    $subject = test_input($_POST["subject"]);
                    $subjectErr = "";
                }
                if(empty($_POST["room"])) {
                    $roomErr = "Room is required. ";
                }
                else {
                    $room = test_input($_POST["room"]);
                    $roomErr = "";
                }
            }
        }

        function test_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
    ?>

    <!-- FORM -->
    <form method="post" class="row g-3 align-items-center" style="padding-left:1%">
        <div class="col-auto">
            <label for="subject" class="col-form-label">Subject: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="subject" id="subject" class="form-control">
        </div>
        <div class="col-auto">
            <label for="room" class="col-form-label">Room: </label>
        </div>
        <div class="col-auto">
            <input type="text" name="room" id="room" class="form-control">
        </div>
        <div class="col-auto">
            <button type="submit" id="add" class="btn btn-primary">Add</button>
        </div>
        <div class ="col-auto" style="color:red;">
            <?php echo $subjectErr; ?>
            <?php echo $roomErr; ?>
        </div>
    </form>

    <!-- TABLE -->
    <table class="table" style="vertical-align:middle">
        <thead>
            <th>Subject</th>
            <th>Room</th>
            <th>Action</th>
        </thead>
        <tbody>

        <?php
            $xml = simplexml_load_file("class.xml") or die("Error: Cannot create object");
            $counter = count($xml->course);
            if(isset($subject) && isset($room)) {
                $course = $xml->addChild("course"); 
                $course->addChild("subject", $subject);
                $course->addChild("room", $room);
                $course->addChild("id", $counter);
                $xml -> asXML("class.xml");
            }

            if(isset($btn)) {
                $xml = simplexml_load_file("class.xml") or die("Error: Cannot create object");
                $target = null;
                $i = 0;

                foreach($xml->course as $course) {
                    if($course->id == $btn) {
                        $target = $i;
                    }
                    $i++;
                }

                if(isset($target)) {
                    unset($xml->course[$target]);
                }

                $i = 0;


                $xml-> asXML("class.xml");
            }

            $xml = simplexml_load_file("class.xml") or die("Error: Cannot create object");
            $i = 0;
            foreach($xml->course as $course) {
                $course->id = $i; 
                $i++;
            }
            $xml-> asXML("class.xml");


            $xml = simplexml_load_file("class.xml") or die("Error: Cannot create object");
            foreach($xml->course as $course) {
                echo "<tr>";
                echo "<td>".$course->subject."</td>";
                echo "<td>".$course->room."</td>";
                echo '<td><form method="post" style="margin: 0px 0px 0px 0px; padding: 0px 0px 0px 0px"><button type="submit" name="remove" value="'.$course->id.'" class="btn btn-primary">Remove</button></form></td>';
                echo "</tr>";
            }
        ?>
        </tbody>
    </table>
    <hr>
    <!-- EXPORT -->
    <form method="post" action="pdf.php" class="row g-3 align-items-center" style="padding-left:1%">
        <div class="col-auto">
            <button type="submit" id="pdf" class="btn btn-primary">Export as PDF</button>
        </div>
    </form>


    </body>
</html>