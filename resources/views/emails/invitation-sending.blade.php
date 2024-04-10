<!-- invitation-sending.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invite to Team</title>
</head>
<body>
    <p>Hello,</p>

    <p>This is API Documentation & Design Tools: ADDT System From Clicknext</p>

    <p>You are receiving this email because we received an invite request for your account.</p>
    <p>If you did not request a team, no further action is required.</p>

    <p>Click the following link to accept the invitation:</p>
    <p><a href="{{ route('view.invitationteam', $token) }}">accept</a></p>

    <p>Thank you,</p>
    <p>Cluster 3</p>
</body>
</html>
