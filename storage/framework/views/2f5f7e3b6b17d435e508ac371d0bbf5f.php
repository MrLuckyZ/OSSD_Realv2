<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
</head>
<body>
    <p>Hello,</p>
    
    <p>This is API Documentation & Design Tools : ADDT System </p>
    
    <p>You are receiving this email because we received a password reset request for your account.</p>
    <p>If you did not request a password reset, no further action is required.</p>
    
    <p>Click the following link to reset your password:</p>
    <p><a href="<?php echo e(route('reset.password', $token)); ?>">Reset Password</a></p>
    
    
    <p>If you’re having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:</p>
    <p><?php echo e(route('reset.password', $token)); ?></p>
    
    <p>Thank you,</p>
    <p>Your Website Team</p>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\OSSD_Realv2\resources\views/emails/email-forget-password.blade.php ENDPATH**/ ?>