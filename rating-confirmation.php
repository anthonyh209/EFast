<!DOCTYPE html>
<html lang="en">
<head>
    <head>
        <meta charset="UTF-8">
        <title>Feedback</title>
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <!-- Custom CSS -->


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        -->

        <style class="cp-pen-styles">body {
                background-color: #f3f5f7;
                font-family: 'Helvetica Neue', Arial, sans-serif;
            }

            .card {
                background-color: #fff;
                box-shadow: 0 0 6px rgba(0, 0, 0, 0.1);
                position: absolute;
                top: 50%;
                left: 50%;
                transform: translate(-50%, -50%);
                max-width: 300px;
                height: 375px;
                border-radius: 10px;
                overflow: hidden;
            }

            .card .about {
                height: 225px;
                padding: 20px;
                box-sizing: border-box;
            }

            .card .about h3,
            .card .about .lead {
                font-weight: 300;
                margin: 0;
            }

            .card .about h3 {
                font-size: 24px;
            }

            .card .about .lead {
                color: #aaa;
            }

            .card .info {
                float: left;
                padding: 10px 30px 10px 0;
            }

            .card .info p {
                font-size: 11px;
                color: #aaa;
                font-weight: 300;
            }

        </style>
    </head>

    <!--List of auctions, items, users. Analytics.-->


<body>
<div class="card" style="height:auto; width:auto;">
    <div class="col-sm-12" style="height:auto; width:auto;">
        <!-- Custom information -->
        <div class="about" style="height:auto; width:auto;">
            <h3>Successfully submitted your rating</h3>
            <form action="seller-rating.php" role="form" method="post" enctype="multipart/form-data">
                <div class="spacer" style="height:20px"></div>

                <!--<select class="custom-select" id="inputGroupSelect01">-->

                <div class="spacer" style="height:10px"></div>
                <button type="button" class="btn btn-primary btn-block">Return to Profile</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>