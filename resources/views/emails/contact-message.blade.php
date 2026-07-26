<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>New Contact Message</title>
</head>
<body style="margin:0;padding:0;background:#f3f4f6;font-family:'Segoe UI',Arial,sans-serif;color:#1f2937">
<table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background:#f3f4f6;padding:32px 0">
    <tr>
        <td align="center">
            <table role="presentation" width="580" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:14px;overflow:hidden;box-shadow:0 4px 24px rgba(0,0,0,.06)">

                <tr>
                    <td style="background:linear-gradient(135deg,#c26af5,#54f0ff);padding:32px 40px;text-align:center">
                        <h1 style="margin:0;color:#fff;font-size:20px;font-weight:700">New Contact Message</h1>
                        <p style="margin:8px 0 0;color:rgba(255,255,255,.9);font-size:13px">Submitted via the {{ config('site.name') }} website</p>
                    </td>
                </tr>

                <tr>
                    <td style="padding:32px 40px">
                        <p style="font-size:14px;line-height:1.7;color:#374151;margin:0 0 6px"><strong>Name:</strong> {{ $contactMessage->name }}</p>
                        <p style="font-size:14px;line-height:1.7;color:#374151;margin:0 0 6px"><strong>Email:</strong> {{ $contactMessage->email }}</p>
                        @if($contactMessage->phone)
                        <p style="font-size:14px;line-height:1.7;color:#374151;margin:0 0 6px"><strong>Phone:</strong> {{ $contactMessage->phone }}</p>
                        @endif
                        <p style="font-size:14px;line-height:1.7;color:#374151;margin:20px 0 6px"><strong>Message:</strong></p>
                        <p style="font-size:14px;line-height:1.7;color:#374151;margin:0;white-space:pre-wrap">{{ $contactMessage->message }}</p>
                    </td>
                </tr>

            </table>
        </td>
    </tr>
</table>
</body>
</html>
