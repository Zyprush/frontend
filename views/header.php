<!-- Boxicons -->
<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
<link rel="icon" type="image/png" href="../assets/img/logo.png">
<!-- FontAwesome -->
<script src="https://kit.fontawesome.com/7bfd4a06a1.js" crossorigin="anonymous"></script>

<!-- Jquery/Ajax -->
<script rel="stylesheet" src="https://code.jquery.com/jquery-3.5.1.js"></script>

<!-- sha256 -->
<script src="../js/sha256.js"></script>
<!-- SMTP -->
<script src="../js/smtp.js"></script>
<!-- CertGen Scripts -->
<script src="https://unpkg.com/pdf-lib/dist/pdf-lib.min.js"></script>
<script src="https://unpkg.com/@pdf-lib/fontkit@0.0.4"></script>
<script src="../js/filesaver.js"></script>

<!-- Supabase Scripts -->
<script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
<script>
  const { createClient } = supabase
  const apiUrl = 'https://myqpghwffopnncwzydya.supabase.co'
  const apiKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6Im15cXBnaHdmZm9wbm5jd3p5ZHlhIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTY1OTAwMTg3MSwiZXhwIjoxOTc0NTc3ODcxfQ.wdyHWBioN65xxRQ1JJlGZm0g6Il8ql_4-mlnYKDvfq8'
  supabase = createClient(apiUrl, apiKey)
</script>

<!-- Data Table Plugin -->
<link rel="stylesheet" type="text/css" href="../assets/plugins/datatables/datatables.css"/>
<script type="text/javascript" src="../assets/plugins/datatables/datatables.js"></script>
