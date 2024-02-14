

 
    <aside id="sidebar">
      <!-- Sidebar content goes here -->
      <ul class="nav flex-column">
        
        <li class="nav-item"><a href="schedule.php" class="nav-link">Schedule</a></li>
        <li class="nav-item"><a href="view_stop.php" class="nav-link"> View stop </a></li>
        <li class="nav-item"><a href="stop.php" class="nav-link"> Add Stop </a></li>
        <li class="nav-item"><a href="seat_view.php" class="nav-link">Seat Details</a></li>
        <li class="nav-item"><a href="seat.php" class="nav-link">Add Seat </a></li>
        
        <li class="nav-item"><a href="flight.php" class="nav-link">View Flight</a></li>
         <li class="nav-item"><a href="flight_one.php" class="nav-link">Add Flight</a></li>
        
        <li class="nav-item"><a href="airbus.php" class="nav-link">AirBus</a></li>
       <li class="nav-item"><a href="airport.php" class="nav-link">Airport</a></li>
        <li class="nav-item"><a href="airline.php" class="nav-link">Airline</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Users</a></li>
        <!-- Add more items with designs below -->
        <li class="nav-item"><a href="#" class="nav-link">Reports</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Analytics</a></li>
        <li class="nav-item"><a href="#" class="nav-link">Settings</a></li>
       
      </ul>
    </aside>


    <script src="js/bootstrap.min.js"></script>

  <script>
    var sidebar = document.getElementById("sidebar");
    var menuBtn = document.getElementById("menuBtn");

    menuBtn.addEventListener("mouseenter", function () {
      sidebar.style.display = "block";
    });

    sidebar.addEventListener("mouseleave", function () {
      sidebar.style.display = "none";
    });
  </script>