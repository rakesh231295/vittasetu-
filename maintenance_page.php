<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($maintenance_title, ENT_QUOTES, 'UTF-8'); ?> | Vittasetu</title>
    <link rel="icon" type="image/png" href="img/v-logo-removebg-preview.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700;800&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg: #06080f;
            --panel: #0b0f1c;
            --primary: #c9a227;
            --primary-dark: #a07e18;
            --text: #f0f2f8;
            --muted: #9aa0b8;
            --gold: #c9a227;
            --radius: 24px;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            width: 100%;
            min-height: 100vh;
            font-family: 'Manrope', sans-serif;
            color: var(--text);
            background:
                radial-gradient(circle at top left, rgba(35, 75, 150, 0.35), transparent 45%),
                radial-gradient(circle at bottom right, rgba(201, 162, 39, 0.15), transparent 40%),
                linear-gradient(180deg, #0b1528 0%, #101c36 50%, #0d162d 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .maintenance-container {
            width: min(100%, 640px);
            text-align: center;
            position: relative;
            z-index: 10;
        }

        .logo-section {
            margin-bottom: 30px;
            display: flex;
            justify-content: center;
        }

        .maint-logo {
            width: 90px;
            height: 90px;
            border-radius: 24px;
            background: #ffffff;
            display: grid;
            place-items: center;
            box-shadow: 0 16px 40px rgba(0, 0, 0, 0.4), inset 0 0 0 1px rgba(255, 255, 255, 0.2);
            padding: 12px;
            border: 2px solid rgba(201, 162, 39, 0.4);
            animation: float 4s ease-in-out infinite;
        }

        .maint-logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .card {
            background: rgba(11, 15, 30, 0.75);
            border: 1px solid rgba(201, 162, 39, 0.2);
            border-radius: var(--radius);
            padding: 50px 40px;
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            box-shadow: 0 30px 70px rgba(0, 0, 0, 0.5);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--primary), transparent);
        }

        .maint-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 16px;
            border-radius: 999px;
            background: rgba(201, 162, 39, 0.1);
            border: 1px solid rgba(201, 162, 39, 0.3);
            color: #e8d898;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .maint-badge-dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--primary);
            box-shadow: 0 0 10px var(--primary);
            animation: pulse-dot 2s infinite;
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: clamp(2rem, 4.2vw, 2.8rem);
            color: #f0f2f8;
            line-height: 1.15;
            letter-spacing: -0.02em;
            margin-bottom: 16px;
        }

        p.message {
            color: var(--muted);
            font-size: 1.05rem;
            line-height: 1.75;
            margin-bottom: 30px;
        }

        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(201, 162, 39, 0.18), transparent);
            margin: 28px 0;
        }

        .contact-info {
            display: flex;
            justify-content: center;
            gap: 30px;
            flex-wrap: wrap;
        }

        .contact-item {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            color: var(--muted);
        }

        .contact-item a {
            transition: color 0.3s ease;
            text-decoration: none;
            color: inherit;
        }

        .contact-item i {
            color: var(--primary);
            font-size: 1.1rem;
        }

        .contact-item a:hover {
            color: var(--primary);
        }

        .footer-note {
            margin-top: 30px;
            font-size: 0.85rem;
            color: rgba(154, 160, 184, 0.5);
            letter-spacing: 0.05em;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-8px); }
        }

        @keyframes pulse-dot {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(201, 162, 39, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 8px rgba(201, 162, 39, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(201, 162, 39, 0); }
        }

        @media (max-width: 500px) {
            .card {
                padding: 35px 20px;
            }
            .contact-info {
                flex-direction: column;
                gap: 15px;
                align-items: center;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="logo-section">
            <div class="maint-logo">
                <img src="img/v-logo-removebg-preview.png" alt="Vittasetu Logo">
            </div>
        </div>

        <div class="card">
            <div class="maint-badge">
                <span class="maint-badge-dot"></span>
                Scheduled System Maintenance
            </div>
            
            <h1><?php echo htmlspecialchars($maintenance_title, ENT_QUOTES, 'UTF-8'); ?></h1>
            <p class="message"><?php echo nl2br(htmlspecialchars($maintenance_message, ENT_QUOTES, 'UTF-8')); ?></p>
            
            <div class="divider"></div>
            
            <p style="font-size: 0.9rem; font-weight: 700; color: #e8d898; margin-bottom: 15px; text-transform: uppercase; letter-spacing: 0.05em;">Need urgent assistance?</p>
            
            <div class="contact-info">
                <span class="contact-item">
                    <i class="fa-solid fa-phone"></i>
                    <a href="tel:+919831040460">+91 9831040460</a>
                </span>
                <span class="contact-item">
                    <i class="fa-solid fa-envelope"></i>
                    <a href="mailto:contact@vittasetu.co.in">contact@vittasetu.co.in</a>
                </span>
            </div>
        </div>
        
        <div class="footer-note">
            &copy; <?php echo date('Y'); ?> Vittasetu Services Private Limited. All rights reserved.
        </div>
    </div>
</body>
</html>
