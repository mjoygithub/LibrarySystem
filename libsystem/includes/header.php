<!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Font Awesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

<!-- DataTables -->
<link href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css" rel="stylesheet">

<!-- Custom Theme -->
<style>

body {
  background-color: #f8f9fa;
  font-family: 'Segoe UI', sans-serif;
}

#bg{
  background:#006400;
}

</style>

<!-- ================= HEADER ================= -->
<header id=bg class="border-bottom border-warning py-1">
  <div class="container">
    <div class="row align-items-center text-center text-lg-start">
      
      <!-- Left: Logos -->
      <div class="col-12 col-lg-3 mb-2 mb-lg-0 d-flex justify-content-center justify-content-lg-start align-items-center">
         <!--<img src="images/bagongphil.png" alt="Philippines Flag" class="me-2 img-fluid" style="height:80px;">-->
        <img src="images/bokod.png" alt="BSU Logo" class="img-fluid" style="height:80px;">
      </div>

      <!-- Center: University Info -->
      <div class="col-12 col-lg-6 text-center">
        <div class="fw-bold small text-warning">REPUBLIC OF THE PHILIPPINES</div>
        <div class="fw-bold text-warning fs-6">BENGUET STATE UNIVERSITY - BOKOD CAMPUS</div>
        <div class="small text-warning">AMBANGEG, DAKLAN, BOKOD, BENGUET, 2605 PHILIPPINES</div>
      </div>

      <!-- Right: Date/Time -->
      <div class="col-12 col-lg-3 text-lg-end text-center mt-2 mt-lg-0 small text-warning fw-bold">
        Philippine Standard Time:<br>
        <span id="currentDateTime"></span>
      </div>

    </div>
  </div>
</header>

<script>
function updateDateTime() {
  const now = new Date();
  document.getElementById("currentDateTime").innerText = now.toLocaleString("en-PH", {
      timeZone: "Asia/Manila",
      hour12: true,
      year: "numeric", month: "long", day: "numeric",
      hour: "2-digit", minute: "2-digit", second: "2-digit"
  });
}
setInterval(updateDateTime, 1000);
updateDateTime();
</script>