<!DOCTYPE html>
<html>
    <head>
      <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
      <style>
          span,a
            {
              color: #636b6f;
              font-size: 18px;
              font-weight: 600;
              font-family: 'Nunito', sans-serif;
            }
            p{
              color: #636b6f;
              font-size: 13px;
              font-weight: 600;
              font-family: 'Nunito', sans-serif;
            }
            h2{
              color: #636b6f;
              font-weight: 600;
              font-family: 'Nunito', sans-serif;
            }
            .blue{
              background: #2196F3 !important;
              padding: 8px;
              color: #fff!important;
              text-decoration: none;
            }
      </style>
    </head>
    <body class="w3-container" style="background:#f1f1f1">
      <div style="width:70vw;margin:0 auto;background:#f1f1f1;">
        <div style="text-align:center;margin:16px;padding-top:20px;">
          <h2
			style="margin-top:30px"
          >Reset your account password</h2>
        </div>
        <div style="margin:16px;">
          <span>
              Seems like you forgot your Sailor Captain App account password. If that's true, click below to reset your password.
          </span>
        </div>
        <div style="text-align:center;margin:16px;">
          <a href= "{{ @Request::url() }}/<?php echo base64_encode($user_id).'/'.base64_encode($user_reg_num); ?>" class="blue">Reset Password</a>
        </div>
        <div style="margin:16px;">
          <span>
              If you did not forgot your password you can safely ignore this mail.
          </span>
        </div>
      </div>
      <div style="text-align:center">
        <p>
            Sailor Softwares, 121 Street, Al Farwaniya, Kuwait.
        </p>
      </div>
      <div style="text-align:center;padding-bottom:20px;">
        <p>
            Powered by Sailor Softwares | 2020
        </p>
      </div>
    </body>
</html>
