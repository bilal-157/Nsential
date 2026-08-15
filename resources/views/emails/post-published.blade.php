<!DOCTYPE html>
<html lang="en" xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ $title }}</title>
<!--[if mso]>
<noscript>
<xml>
<o:OfficeDocumentSettings>
<o:PixelsPerInch>96</o:PixelsPerInch>
</o:OfficeDocumentSettings>
</xml>
</noscript>
<![endif]-->
<style>
    body, table, td, a { -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; }
    table, td { mso-table-lspace: 0pt; mso-table-rspace: 0pt; }
    img { -ms-interpolation-mode: bicubic; border: 0; height: auto; line-height: 100%; outline: none; text-decoration: none; }
    body { margin: 0; padding: 0; width: 100% !important; height: 100% !important; }

    @media only screen and (max-width: 600px) {
        .email-container { width: 100% !important; }
        .fluid-padding { padding-left: 20px !important; padding-right: 20px !important; }
        .stack-btn { width: 100% !important; text-align: center !important; }
    }
</style>
</head>
<body style="margin:0; padding:0; background-color:#050611; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">

    <!-- Preheader (hidden preview text shown in inbox list) -->
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">
        {{ $excerpt }}
    </div>
    <div style="display:none; max-height:0; overflow:hidden; mso-hide:all;">
        &#847; &zwnj; &nbsp; &#8199; &shy; &#847; &zwnj; &nbsp; &#8199; &shy;
    </div>

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background-color:#050611;">
        <tr>
            <td align="center" style="padding:40px 16px;">

                <table role="presentation" class="email-container" width="600" cellpadding="0" cellspacing="0" border="0" style="width:600px; max-width:600px;">

                    <!-- Logo / Wordmark -->
                    <tr>
                        <td align="center" style="padding-bottom:28px;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font-size:18px; font-weight:700; letter-spacing:-0.01em; color:#F4F2FA; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                        NSential
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- Main card -->
                    <tr>
                        <td style="background-color:#120F26; border:1px solid #2A2650; border-radius:12px;">

                            <!-- Accent top bar -->
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="height:4px; line-height:4px; font-size:0; background-color:#3FD8E0; border-radius:12px 12px 0 0;">&nbsp;</td>
                                </tr>
                            </table>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" class="fluid-padding">
                                <tr>
                                    <td style="padding:40px 40px 8px;">

                                        <!-- Eyebrow label -->
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="background-color:rgba(63,216,224,0.12); border:1px solid rgba(63,216,224,0.3); border-radius:999px; padding:6px 14px;">
                                                    <span style="font-size:11px; font-weight:600; letter-spacing:0.1em; text-transform:uppercase; color:#3FD8E0; font-family:'Courier New',monospace;">
                                                        New Post Published
                                                    </span>
                                                </td>
                                            </tr>
                                        </table>

                                        <!-- Title -->
                                        <h1 style="margin:20px 0 14px; font-size:24px; line-height:1.35; font-weight:700; letter-spacing:-0.01em; color:#F4F2FA; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                            {{ $title }}
                                        </h1>

                                        <!-- Excerpt -->
                                        <p style="margin:0 0 28px; font-size:15px; line-height:1.65; color:#9993B8; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                            {{ $excerpt }}
                                        </p>

                                        <!-- CTA button (VML fallback for Outlook, gradient for modern clients) -->
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td class="stack-btn" style="border-radius:999px; background-color:#3FD8E0; background-image:linear-gradient(90deg,#3FD8E0,#9C8CFF);">
                                                    <!--[if mso]>
                                                    <v:roundrect xmlns:v="urn:schemas-microsoft-com:vml" xmlns:w="urn:schemas-microsoft-com:office:word" href="{{ $url }}" style="height:44px;v-text-anchor:middle;width:180px;" arcsize="50%" fillcolor="#3FD8E0" stroke="f">
                                                    <w:anchorlock/>
                                                    <center style="color:#0B0A18;font-family:Arial,sans-serif;font-size:14px;font-weight:bold;">Read the Post &rarr;</center>
                                                    </v:roundrect>
                                                    <![endif]-->
                                                    <!--[if !mso]><!-->
                                                    <a href="{{ $url }}" target="_blank" style="display:inline-block; padding:13px 28px; font-size:14px; font-weight:600; color:#0B0A18; text-decoration:none; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                                        Read the Post &rarr;
                                                    </a>
                                                    <!--<![endif]-->
                                                </td>
                                            </tr>
                                        </table>

                                    </td>
                                </tr>

                                <!-- Divider -->
                                <tr>
                                    <td style="padding:36px 40px 0;">
                                        <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="height:1px; line-height:1px; font-size:0; background-color:#2A2650;">&nbsp;</td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>

                                <!-- Author / meta line (optional, remove block if unused) -->
                                @isset($authorName)
                                <tr>
                                    <td style="padding:24px 40px 0;">
                                        <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="width:32px; height:32px; border-radius:999px; background-color:rgba(156,140,255,0.15); text-align:center; vertical-align:middle; font-size:13px; font-weight:700; color:#9C8CFF; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                                    {{ strtoupper(substr($authorName, 0, 1)) }}
                                                </td>
                                                <td style="padding-left:10px; font-size:13px; color:#9993B8; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                                    Written by <span style="color:#F4F2FA; font-weight:600;">{{ $authorName }}</span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                @endisset

                                <tr>
                                    <td style="padding:24px 40px 40px; font-size:12px; line-height:1.6; color:#6b6690; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif;">
                                        You're receiving this email because you're a registered subscriber on NSential.
                                    </td>
                                </tr>
                            </table>

                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td align="center" style="padding:28px 20px 0;">
                            <table role="presentation" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="font-size:12px; color:#544f74; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; text-align:center; padding-bottom:8px;">
                                        &copy; {{ date('Y') }} NSential. All rights reserved.
                                    </td>
                                </tr>
                                <tr>
                                    <td style="font-size:12px; font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,Helvetica,Arial,sans-serif; text-align:center;">
                                        <a href="{{ $unsubscribeUrl ?? '#' }}" style="color:#544f74; text-decoration:underline;">Unsubscribe</a>
                                        &nbsp;&middot;&nbsp;
                                        <a href="{{ url('/') }}" style="color:#544f74; text-decoration:underline;">Visit site</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>