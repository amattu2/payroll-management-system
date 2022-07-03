<!DOCTYPE html>
<html>

<head>
  <title>{{ config('app.name') }}</title>
  <style>
    html,
    body {
      margin: 0;
      padding: 0;
      font-family: sans-serif;
      overflow-x: hidden;
    }

    .container {
      margin: 0 auto;
      padding: 0;
      width: 98%;
      max-width: 725px;
      min-width: 300px;
      background: #f2f2f2;
    }

    .header {
      text-align: center;
      padding: 22px 0;
      border-top: 4px solid #262626;
      background: transparent;
    }

    .header .company {
      margin: 0 auto;
      font-size: 25px;
      color: #3b3b3b;
    }

    .middle {
      padding: 15px 25px;
      background: #fff;
    }

    .middle .content {
      text-align: left;
      font-size: 17px;
      color: #262626;
    }

    .middle .notice {
      text-align: center;
      font-size: 14px;
      color: #3b3b3b;
      font-variant: all-petite-caps;
    }

    .footer .content {
      text-align: center;
      padding: 45px 0;
    }

    .footer .content .footer-1 {
      text-transform: uppercase;
      font-weight: bold;
      margin-top: 0;
      font-size: 15px;
    }

    .footer .content .footer-2 {
      font-size: 40px;
      font-weight: 300;
      margin: 0;
      margin-top: 35px;
    }

    .disclosure {
      padding: 15px 25px;
      background: #3b3b3b;
      color: #fff;
    }

    .container table {
      width: 100%;
      border-collapse: collapse;
    }

    .container thead {
      background: #3b3b3b;
      color: #fff;
    }

    .container tbody {
      font-size: 14px;
    }

    .container tbody tr:nth-child(2n) {
      background: rgba(0, 0, 0, 0.05);
    }

    .container tr td {
      padding: 6px;
    }

    .container td:first-child {
      text-align: center;
    }
  </style>
</head>

<body style="margin: 0; padding: 0; font-family: sans-serif; overflow-x: hidden;">
  <div class='container' style="margin: 0 auto; padding: 0; width: 98%; max-width: 725px; min-width: 300px; background: #f2f2f2;">
    <div class='header' style="text-align: center; padding: 22px 0; border-top: 4px solid #262626; background: transparent;">
      <div class='company' style="margin: 0 auto; font-size: 25px; color: #3b3b3b;">{{ config('app.name') }}</div>
    </div>
    <div class='middle' style="padding: 15px 25px; background: #fff;">
      <p class='content' style="text-align: left; font-size: 17px; color: #262626;">
        {{ $emailBody }}
      </p>
      <div class='notice' style="text-align: center; font-size: 14px; color: #3b3b3b; font-variant: all-petite-caps;">
        An internal request has prompted this email
      </div>
    </div>
  </div>
</body>

</html>
