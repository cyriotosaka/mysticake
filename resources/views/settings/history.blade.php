<!---Created by Lailatul Fitaliqoh_229--->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login History - MystiCake</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Instrument+Sans:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            background-color: #FFFDF5; 
            font-family: 'Instrument Sans', sans-serif;
            color: #4E342E;
        }

        .container {
            max-width: 480px;
        }

        .header-nav {
            display: flex;
            align-items: center;
            padding: 20px 0;
            margin-bottom: 20px;
        }
        .back-btn {
            font-size: 24px;
            color: #4E342E;
            text-decoration: none;
            margin-right: 15px;
        }
        .header-title {
            font-weight: 700;
            font-size: 1.1rem;
            flex-grow: 1;
            text-align: center;
            margin-right: 24px;
        }

        .info-box {
            background-color: #3E2723;
            color: white;
            padding: 15px;
            border-radius: 12px;
            display: flex;
            align-items: flex-start;
            gap: 12px;
            font-size: 12px;
            line-height: 1.4;
            margin-bottom: 25px;
        }
        .info-box i {
            font-size: 18px;
            margin-top: -2px;
        }

        .session-card {
            background-color: #F06A7D;
            color: white;
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 15px;
            position: relative;
            box-shadow: 0 4px 10px rgba(240, 106, 125, 0.3);
        }

        .badge-current {
            background-color: #C8E6C9; /* Hijau muda */
            color: #2E7D32; /* Hijau tua */
            font-size: 11px;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
            margin-bottom: 10px;
        }

        .device-name {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .session-details {
            font-size: 13px;
            opacity: 0.9;
        }

        .session-time {
            font-size: 13px;
            opacity: 0.9;
            margin-top: 2px;
        }

        /* Icon Device Besar */
        .device-icon-bg {
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 40px;
            opacity: 0.2;
        }
    </style>
</head>
<body>

    <div class="container px-4">
        <div class="header-nav">
            <a href="{{ route('settings.more') }}" class="back-btn">
                <i class="bi bi-arrow-left"></i>
            </a>
            <div class="header-title">Login History</div>
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <div>
                If you notice login activity from device that's not yours, please click 'Log out' immediately.
            </div>
        </div>

        <div class="session-card">
            <div class="badge-current">Current session</div>
            
            <div class="device-name">
                {{ $agentInfo['device'] }} ({{ $agentInfo['browser'] }})
            </div>
            
            <div class="session-details">
                {{ $agentInfo['ip'] }} </div>
            
            <div class="session-time">
                {{ now()->format('h:i A d F, Y') }}
            </div>

            <i class="bi bi-phone device-icon-bg"></i>
        </div>

        </div>

</body>
</html>