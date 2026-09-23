<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Legals Forum Admin Verification Code</title>
</head>
<body style="margin: 0; padding: 0; background-color: #0b0f19; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #f3f4f6;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="table-layout: fixed; background-color: #0b0f19; padding: 40px 16px;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 540px; background-color: #111827; border: 1px solid rgba(255, 255, 255, 0.08); border-radius: 16px; overflow: hidden; box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);">
                    
                    <!-- Header Bar -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #1d4ed8 0%, #3b82f6 100%); padding: 24px 32px; text-align: center;">
                            <div style="font-size: 20px; font-weight: 800; letter-spacing: 0.5px; color: #ffffff; text-transform: uppercase;">
                                &#9878; Legals Forum
                            </div>
                            <div style="font-size: 12px; color: rgba(255, 255, 255, 0.85); letter-spacing: 1.5px; text-transform: uppercase; margin-top: 4px; font-weight: 600;">
                                Administration Security Service
                            </div>
                        </td>
                    </tr>

                    <!-- Body Content -->
                    <tr>
                        <td style="padding: 36px 32px 28px 32px;">
                            <h2 style="margin: 0 0 12px 0; font-size: 20px; font-weight: 700; color: #ffffff; text-align: center;">
                                Two-Factor Authentication Code
                            </h2>
                            <p style="margin: 0 0 24px 0; font-size: 14px; line-height: 1.6; color: #9ca3af; text-align: center;">
                                An administrator login request was initiated for your account. Enter the 6-digit one-time security code below to complete your authentication:
                            </p>

                            <!-- OTP Box -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin: 28px 0;">
                                <tr>
                                    <td align="center">
                                        <div style="display: inline-block; background-color: rgba(59, 130, 246, 0.08); border: 2px dashed #3b82f6; border-radius: 12px; padding: 18px 36px; text-align: center;">
                                            <span style="font-family: 'Courier New', Courier, monospace; font-size: 34px; font-weight: 800; letter-spacing: 10px; color: #60a5fa;">
                                                {{ $code }}
                                            </span>
                                        </div>
                                    </td>
                                </tr>
                            </table>

                            <p style="margin: 0 0 24px 0; font-size: 13px; color: #e5e7eb; text-align: center; font-weight: 500;">
                                &#9201; This code is strictly valid for <strong style="color: #fbbf24;">10 minutes</strong>.
                            </p>

                            <!-- Security Request Meta -->
                            <div style="background-color: rgba(255, 255, 255, 0.02); border: 1px solid rgba(255, 255, 255, 0.06); border-radius: 10px; padding: 16px; margin-top: 24px;">
                                <div style="font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: #9ca3af; margin-bottom: 8px;">
                                    Request Metadata
                                </div>
                                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="font-size: 12px; color: #cbd5e1;">
                                    <tr>
                                        <td style="padding: 3px 0; color: #64748b; width: 100px;">Recipient:</td>
                                        <td style="padding: 3px 0; font-weight: 600;">{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #64748b;">IP Address:</td>
                                        <td style="padding: 3px 0;">{{ $ipAddress ?? 'N/A' }}</td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 3px 0; color: #64748b;">Timestamp:</td>
                                        <td style="padding: 3px 0;">{{ now()->toFormattedDateString() }} at {{ now()->format('H:i:s T') }}</td>
                                    </tr>
                                </table>
                            </div>

                            <!-- Warning -->
                            <div style="margin-top: 24px; padding-top: 20px; border-top: 1px solid rgba(255, 255, 255, 0.08); font-size: 12px; color: #ef4444; line-height: 1.5; text-align: center;">
                                &#9888; <strong>Security Alert:</strong> If you did not initiate this administrator login, someone may be attempting to access your portal. Please contact the security team immediately.
                            </div>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background-color: rgba(0, 0, 0, 0.3); padding: 18px 32px; text-align: center; font-size: 11px; color: #64748b; border-top: 1px solid rgba(255, 255, 255, 0.05);">
                            Legals Forum Administration Portal &bull; Ghana's Premier Legal Community
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
