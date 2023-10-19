<html>
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link rel="stylesheet" href="../css/userRegistrationStyle.css"/>
        <link rel="stylesheet" href="../css/userRegistrationBootstrap.css"/>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <?php include 'header.php' ?>

        <title>Redirector</title>
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
                <span>You are being redirected to the webinar link.</span><br>
                <span>Please wait...</span>
                <center>
                    <div class="loader"></div>
                </center>
            </div>
        </section>
        <section class="main text-center" id="invalid" hidden>
            <div class="container py-5">
                <span>Your link may be broken.</span><br>
                <span>Please check the following.</span><br><br>
                <ol>
                    <li>1. Invalid link.</li>
                    <li>2. Webinar has ended.</li>
                </ol>
            </div>
        </section>

        <style>
            .loader {
              border: 16px solid #f3f3f3; /* Light grey */
              border-top: 16px solid #3498db; /* Blue */
              border-radius: 50%;
              width: 120px;
              height: 120px;
              animation: spin 2s linear infinite;
            }

            @keyframes spin {
              0% { transform: rotate(0deg); }
              100% { transform: rotate(360deg); }
            }
        </style>



    </body>
</html>
<script>
    var secret = window.location.href.split('WID')
    secret = secret[1]
    let like = '%' + secret
    var webinarID = null
    let timeout

    async function redirect(){
        console.log(secret)
        if(secret != ''){
            const {error, data} = await supabase.from('user_links').select('*').like('hashString', like)
            if (data[0] != null){
                webinarID = data[0]['webinarID']
            }
            else{
                document.getElementById('valid').style.display = 'none'
                document.getElementById('invalid').removeAttribute('hidden')
                // alert('user link not found')
            }

            timeout = setTimeout(getLink, 3000)

        }
        else{
            document.getElementById('valid').style.display = 'none'
            document.getElementById('invalid').removeAttribute('hidden')
        }


    }

    async function getLink(){
        if (webinarID != null){
            const {error, data} = await supabase.from('webinars').select('*').match({id: webinarID})
            // console.log(data[0])
            if (data[0] != null){
                console.log(data[0]['link'])
                window.location.href = (data[0]['link'])
            }
            else{
                alert('webinar link not found')
            }

        }
    }

    redirect();


</script>
