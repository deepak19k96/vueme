<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:v="urn:schemas-microsoft-com:vml"
  xmlns:o="urn:schemas-microsoft-com:office:office">

<head>
  <meta charset="utf-8"> <!-- utf-8 works for most cases -->
  <meta name="viewport" content="width=device-width"> <!-- Forcing initial-scale shouldn't be necessary -->
  <meta http-equiv="X-UA-Compatible" content="IE=edge"> <!-- Use the latest (edge) version of IE rendering engine -->
  <meta name="x-apple-disable-message-reformatting"> <!-- Disable auto-scale in iOS 10 Mail entirely -->
  <meta name="format-detection" content="telephone=no,address=no,email=no,date=no,url=no">
  <!-- Tell iOS not to automatically link certain text strings. -->
  <meta name="color-scheme" content="light">
  <meta name="supported-color-schemes" content="light">
  <link href="https://fonts.googleapis.com/css2?family=Montserrat&display=swap" rel="stylesheet">
  <title></title> <!-- The title tag shows in email notifications, like Android 4.4. -->

  <!-- What it does: Makes background images in 72ppi Outlook render at correct size. -->
  <!--[if gte mso 9]>
    <xml>
        <o:OfficeDocumentSettings>
            <o:AllowPNG/>
            <o:PixelsPerInch>96</o:PixelsPerInch>
        </o:OfficeDocumentSettings>
    </xml>
    <![endif]-->

  <!-- Web Font / @font-face : BEGIN -->
  <!-- NOTE: If web fonts are not required, lines 23 - 41 can be safely removed. -->

  <!-- Desktop Outlook chokes on web font references and defaults to Times New Roman, so we force a safe fallback font. -->
  <!--[if mso]>
        <style>
            * {
                font-family: sans-serif !important;
            }
        </style>
    <![endif]-->

  <!-- All other clients get the webfont reference; some will render the font and others will silently fail to the fallbacks. More on that here: http://stylecampaign.com/blog/2015/02/webfont-support-in-email/ -->
  <!--[if !mso]><!-->

  <!-- insert web font reference, eg: <link href='https://fonts.googleapis.com/css?family=Roboto:400,700' rel='stylesheet' type='text/css'> -->
  <!--<![endif]-->

  <!-- Web Font / @font-face : END -->

  <!-- CSS Reset : BEGIN -->
  <style>
    * {
      font-family: 'Montserrat', sans-serif;
    }

    /* What it does: Tells the email client that only light styles are provided but the client can transform them to dark. A duplicate of meta color-scheme meta tag above. */
    :root {
      color-scheme: light;
      supported-color-schemes: light;
    }

    /* What it does: Remove spaces around the email design added by some email clients. */
    /* Beware: It can remove the padding / margin and add a background color to the compose a reply window. */
    html,
    body {
      margin: 0 auto !important;
      padding: 0 !important;
      height: 100% !important;
      width: 100% !important;
    }

    /* What it does: Stops email clients resizing small text. */
    * {
      -ms-text-size-adjust: 100%;
      -webkit-text-size-adjust: 100%;
    }

    /* What it does: Centers email on Android 4.4 */
    div[style*="margin: 16px 0"] {
      margin: 0 !important;
    }

    /* What it does: forces Samsung Android mail clients to use the entire viewport */
    #MessageViewBody,
    #MessageWebViewDiv {
      width: 100% !important;
    }

    /* What it does: Stops Outlook from adding extra spacing to tables. */
    table,
    td {
      mso-table-lspace: 0pt !important;
      mso-table-rspace: 0pt !important;
    }

    /* What it does: Replaces default bold style. */
    th {
      font-weight: normal;
    }

    /* What it does: Fixes webkit padding issue. */
    table {
      border-spacing: 0 !important;
      border-collapse: collapse !important;
      table-layout: fixed !important;
      margin: 0 auto !important;
    }

    /* What it does: Prevents Windows 10 Mail from underlining links despite inline CSS. Styles for underlined links should be inline. */
    a {
      text-decoration: none;
    }

    /* What it does: Uses a better rendering method when resizing images in IE. */
    img {
      -ms-interpolation-mode: bicubic;
    }

    /* What it does: A work-around for email clients meddling in triggered links. */
    a[x-apple-data-detectors],
    /* iOS */
    .unstyle-auto-detected-links a,
    .aBn {
      border-bottom: 0 !important;
      cursor: default !important;
      color: inherit !important;
      text-decoration: none !important;
      font-size: inherit !important;
      font-family: inherit !important;
      font-weight: inherit !important;
      line-height: inherit !important;
    }

    /* What it does: Prevents Gmail from changing the text color in conversation threads. */
    .im {
      color: inherit !important;
    }

    /* What it does: Prevents Gmail from displaying a download button on large, non-linked images. */
    .a6S {
      display: none !important;
      opacity: 0.01 !important;
    }

    /* If the above doesn't work, add a .g-img class to any image in question. */
    img.g-img+div {
      display: none !important;
    }

    /* What it does: Removes right gutter in Gmail iOS app: https://github.com/TedGoas/Cerberus/issues/89  */
    /* Create one of these media queries for each additional viewport size you'd like to fix */

    /* iPhone 4, 4S, 5, 5S, 5C, and 5SE */
    @media only screen and (min-device-width: 320px) and (max-device-width: 374px) {
      u~div .email-container {
        min-width: 320px !important;
      }
    }

    /* iPhone 6, 6S, 7, 8, and X */
    @media only screen and (min-device-width: 375px) and (max-device-width: 413px) {
      u~div .email-container {
        min-width: 375px !important;
      }
    }

    /* iPhone 6+, 7+, and 8+ */
    @media only screen and (min-device-width: 414px) {
      u~div .email-container {
        min-width: 414px !important;
      }
    }
  </style>
  <!-- CSS Reset : END -->

  <!-- Progressive Enhancements : BEGIN -->
  <style>
    /* What it does: Hover styles for buttons */
    .button-td,
    .button-a {
      transition: all 100ms ease-in;
    }

    .button-td-primary:hover,
    .button-a-primary:hover {
      background: #555555 !important;
      border-color: #555555 !important;
    }

    /* Media Queries */
    @media screen and (max-width: 600px) {

      .email-container {
        width: 100% !important;
        margin: auto !important;
      }

      /* What it does: Forces table cells into full-width rows. */
      .stack-column,
      .stack-column-center {
        /* display: block !important; */
        display: inline;
        width: 50% !important;
        max-width: 100% !important;
        direction: ltr !important;
      }

      /* And center justify these ones. */
      .stack-column-center {
        text-align: center !important;
      }

      /* What it does: Generic utility class for centering. Useful for images, buttons, and nested tables. */
      .center-on-narrow {
        text-align: center !important;
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
        float: none !important;
      }

      table.center-on-narrow {
        display: inline !important;
      }

      /* What it does: Adjust typography on small screens to improve readability */
      .email-container p {
        font-size: 17px !important;
      }
    }
  </style>
  <!-- Progressive Enhancements : END -->

</head>
<!--
	The email background color (#222222) is defined in three places:
	1. body tag: for most email clients
	2. center tag: for Gmail and Inbox mobile apps and web versions of Gmail, GSuite, Inbox, Yahoo, AOL, Libero, Comcast, freenet, Mail.ru, Orange.fr
	3. mso conditional: For Windows 10 Mail
-->

<body width="100%" style="margin: 0; padding: 0 !important; mso-line-height-rule: exactly; ">
  <center role="article" aria-roledescription="email" lang="en" style="width: 100%;">

    <!-- Preview Text Spacing Hack : END -->

    <!-- Email Body : BEGIN -->
    <table align="center" role="presentation" cellspacing="0" cellpadding="0" border="0" width="600"
      style="margin: auto;" class="email-container">

      <!-- Email Header : END -->

      <!-- Hero Image, Flush : BEGIN -->
               <!--[if gte mso 9]>    
            <tr><table width="100%"><tr style="background: #FFFFFF;" height="50"></tr></table></tr>
            <tr>
              <td width="30%" style="text-align:center;background: #FFFFFF;">
              <a href="{{config('app.url')}}">
                <img src="{{config('app.url')}}/images/site-images/logo_color.png" width="130" height="33"/>
              </a>
              </td>
            </tr>
            <tr><table width="100%"><tr style="background: #FFFFFF;" height="50"></tr></table></tr>
          <![endif]-->
      <tr>
        <td
          style="background:#ffffff;text-align: center; color: #27518F;width: 100%; max-width: 600px; font-family: sans-serif; font-size: 15px; line-height: 15px; margin: auto; display: block;">
          <!--[if !gte mso 9]> -->
          <img src="{{config('app.url')}}/images/site-images/logo_color.png" width="130"
            style="margin-top: 30px" />
          <!--<![endif]--> 
          <div
            style="padding: 0px 20px; line-height: 40px; padding-top: 60px; text-align: center; margin: 0 0 10px; font-family: 'Montserrat', 'Verdana', sans-serif; font-size: 25px; font-weight: normal;">
            Add Funds & Tap Into Psychic Advice
          </div>
          <div
            style="line-height: 24px; text-align: center; padding:30px 20px; margin: auto;font-family: 'Montserrat', 'Verdana', sans-serif;font-size: 16px;max-width: 450px;">
            With over 1,200 Psychics to choose from, you will definitely find your Spiritual match. Add some funds to your digital wallet for peace of mind wherever you go.
          </div>
        </td>
      </tr>
      <tr>
        <td style="text-align: center; background-color: #F0F7FF; padding-bottom: 50px">
          <img src="{{config('app.url')}}/images/icons/email/982.png" style="max-width: 100%;"/>

          <div>
            <!--[if !gte mso 9]> -->
            <a style="padding: 11px 80px; background-color: #244E8D; border-radius: 20px; color:white; font-size: 25px;font-family: 'Montserrat', 'Verdana', sans-serif;"
              href="{{config('app.url')}}" target="blank">
              Add Now
            </a>
            <!--<![endif]-->  
                <!--[if gte mso 9]>
                 <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{config('app.url')}}" style="height:52px;v-text-anchor:middle;width:275px;" arcsize="40%" opacity="0" stroke="f" fillcolor="#244E8D">
                  <w:anchorlock/>
                   <center style="color:#ffffff;font-family:sans-serif;font-size:25px;">
                  Add Now               
               </center>
               </v:roundrect>
            <![endif]--> 
          </div>
        </td>
      </tr>
      <tr>
        <td style="height: 8px; background-color: #A163C1">
        </td>
      </tr>
      <!-- 3 Even Columns : END -->

      <!-- Thumbnail Left, Text Right : BEGIN -->
      <tr>
        <td dir="ltr" width="100%" style="padding: 10px; background-color: #45519B;">
          <table role="presentation" cellspacing="0" cellpadding="0" border="0" width="100%">
            <tr>
              <td>
                <table style="margin-top: 50px !important;" role="presentation" border="0" cellpadding="0"
                  cellspacing="0" width="100%">
                  <tr>
                    <td
                        style="font-family: 'Montserrat',  'Verdana', sans-serif; font-size: 15px; color:#ffffff; text-align: center; "
                        class="center-on-narrow">                        
                        <a href="https://www.instagram.com/psychics1on1/" target="blank">
                          <img src="{{config('app.url')}}/images/icons/email/instagram_2.png">
                        </a>
                        <a href="https://www.facebook.com/Psychics1on1/" target="blank" style="margin-left:14px;">
                          <img src="{{config('app.url')}}/images/icons/email/facebook_2.png">
                        </a>
                        <a href="https://twitter.com/psychics1on1/" target="blank" style="margin-left:14px;">
                          <img class="padding_social" src="{{config('app.url')}}/images/icons/email/twitter_2.png">
                        </a>
                        <a href="https://www.linkedin.com/company/psychics1on1/about/" target="blank"
                          style="margin-left:14px;">
                          <img src="{{config('app.url')}}/images/icons/email/linkedin_2.png">
                        </a>
                        <hr style="width:180px;margin-bottom: 19px;">
                      </td>
                  </tr>
                </table>
              </td>
            </tr>
            <tr>
              <td
                style="font-family: 'Montserrat', 'Verdana', sans-serif;padding: 20px; font-size: 12px; line-height: 15px; text-align: center; color: #ffffff!important;">
                <span style="color:#FFFFFF;">This email was sent to {{$user->email}} because you joined our platform.
                <br><br>
                © 2020 Psychics1on1™. Psychics1on1™ is a federally registered trademark.</span>
              </td>
            </tr>
          </table>
        </td>
      </tr>
      <!-- Thumbnail Left, Text Right : END -->

    </table>
  </center>
</body>

</html>