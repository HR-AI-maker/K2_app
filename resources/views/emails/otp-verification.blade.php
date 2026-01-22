<div style="font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9;">
    <div style="background-color: #ffffff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
        <div style="text-align: center; margin-bottom: 30px;">
            <h1 style="color: #2c3e50; margin: 0; font-size: 28px;">🏔️ Alpine</h1>
            <p style="color: #7f8c8d; margin: 5px 0 0 0;">Mountain Adventure Platform</p>
        </div>

        <h2 style="color: #2c3e50; font-size: 20px; margin: 20px 0;">Welcome to Alpine! 🎉</h2>

        <p style="color: #34495e; font-size: 16px; line-height: 1.6; margin: 15px 0;">
            Thank you for registering with Alpine! We're excited to have you join our climbing community.
        </p>

        <p style="color: #34495e; font-size: 16px; line-height: 1.6; margin: 15px 0;">
            To complete your registration, please verify your email address using the OTP code below:
        </p>

        <div style="background-color: #ecf0f1; border-left: 4px solid #3498db; padding: 20px; margin: 25px 0; border-radius: 4px;">
            <p style="margin: 0; color: #7f8c8d; font-size: 14px;">Your verification code:</p>
            <p style="margin: 10px 0 0 0; color: #2c3e50; font-size: 32px; font-weight: bold; letter-spacing: 5px; text-align: center;">
                {{ $otp }}
            </p>
        </div>

        <p style="color: #34495e; font-size: 14px; line-height: 1.6; margin: 15px 0;">
            This code will expire at <strong>{{ $expiresAt }}</strong>. Please use it within 10 minutes.
        </p>

        <div style="background-color: #fff3cd; border-left: 4px solid #ffc107; padding: 15px; margin: 20px 0; border-radius: 4px;">
            <p style="margin: 0; color: #856404; font-size: 13px;">
                ⚠️ <strong>Never share this code</strong> with anyone. Alpine staff will never ask for your OTP code.
            </p>
        </div>

        <div style="margin: 30px 0; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="color: #34495e; font-size: 14px; line-height: 1.6; margin: 0;">
                If you didn't create this account, you can safely ignore this email.
            </p>
        </div>

        <div style="text-align: center; margin-top: 30px; padding-top: 20px; border-top: 1px solid #ecf0f1;">
            <p style="color: #95a5a6; font-size: 12px; margin: 10px 0;">
                © {{ date('Y') }} Alpine. All rights reserved.
            </p>
            <p style="color: #95a5a6; font-size: 12px; margin: 5px 0;">
                <a href="#" style="color: #3498db; text-decoration: none;">Privacy Policy</a> |
                <a href="#" style="color: #3498db; text-decoration: none;">Terms of Service</a>
            </p>
        </div>
    </div>
</div>
