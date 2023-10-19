<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="../css/userRegistrationStyle.css"/>
        <link rel="stylesheet" href="../css/userRegistrationBootstrap.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <script src="https://code.jquery.com/jquery-3.4.1.js"></script>

        <!-- SMTP -->
        <script src="../js/smtp.js"></script>
        <!-- Sha256 -->
        <script src="../js/sha256.js"></script>

        <!-- Supabase Script -->
        <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js"></script>
        <script>
            const { createClient } = supabase
            supabase = createClient('https://iiyjcebvadflxqplsydx.supabase.co', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImlpeWpjZWJ2YWRmbHhxcGxzeWR4Iiwicm9sZSI6ImFub24iLCJpYXQiOjE2NTY0ODc5MDIsImV4cCI6MTk3MjA2MzkwMn0.7XmoOuqI8Jj0mtCoYlDFyoTeHTqyFWdlybLkBF8TdVU')
        </script>

        <title>Error 404</title>
    </head>
    <body>
        <header class="topnav">
            <nav>

                <label class="logo"><a href="admin_signin.php" class="logo-img"><img src="../assets/img/logo.png" alt="logo">DICT CertGen</a></label>

                <label id="icon">
                    <i class="fa fa-bars"></i>
                </label>
            </nav>
        </header>

        <section class="main text-center" id="valid">
            <div class="container py-5">
                <h1>Error 404</h1><br>
                <span>Link not found.</span>
            </div>
        </section>
    </body>
</html>
