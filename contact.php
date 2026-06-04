<?php
$page_title = 'Vittasetu | Contact Us';

$form_status = null;
$form_message = '';

if (isset($_GET['success']) && $_GET['success'] === '1') {
    $form_status = 'success';
    $form_message = 'Thank you for contacting Vittasetu. Our team will get back to you shortly.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($full_name === '' || $mobile === '' || $email === '' || $service === '' || $message === '') {
        $form_status = 'error';
        $form_message = 'Please fill in all required fields before submitting the enquiry.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_status = 'error';
        $form_message = 'Please enter a valid email address.';
    } else {
        try {
            require __DIR__ . '/db.php';

            $stmt = $pdo->prepare(
                'INSERT INTO enquiries (full_name, mobile, email, service, message) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$full_name, $mobile, $email, $service, $message]);

            header('Location: contact.php?success=1');
            exit;
        } catch (Throwable $e) {
            $form_status = 'error';
            $form_message = 'Unable to submit enquiry right now. Please try again later.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page inner-page">
    <section class="section page-hero">
        <div class="page-hero-banner">
            <img src="img/18.jpg" alt="Contact Vittasetu support team">
            <div class="page-hero-overlay">
                <div class="container">
                    <div class="page-hero-center">
                        <h1>Contact Us</h1>
                        <div class="page-crumbs">
                            <a href="index.php">Home</a>
                            <span>&gt;</span>
                            <span>Contact</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section contact-page-section">
        <div class="container">
            <div class="contact-page-grid">
                <div class="contact-page-main">
                    <div class="section-title">
                        <span class="eyebrow">Contact Information</span>
                        <h2>Contact Info</h2>
                        <p>Reach out to Vittasetu for financial guidance, funding support, documentation help, or business enquiries.</p>
                    </div>

                    <div class="contact-info-grid">
                        <div class="card contact-info-card">
                            <h3><i class="fa-solid fa-location-dot"></i> Address</h3>
                            <p style="margin:0;">8 Beck Bagan Row, Success Centre Building, 3rd Floor, Park Circus, Kolkata - 700017</p>
                        </div>
                        <div class="card contact-info-card">
                            <h3><i class="fa-solid fa-phone"></i> Phone</h3>
                            <p style="margin:0;">+91 9831040460</p>
                        </div>
                        <div class="card contact-info-card">
                            <h3><i class="fa-solid fa-envelope"></i> Email</h3>
                            <p style="margin:0;">contact@vittasetu.co.in</p>
                        </div>
                    </div>

                    <div class="card map-card">
                        <div class="section-title" style="margin-bottom:22px;">
                            <span class="eyebrow">Google Map</span>
                            <h2>Visit our office location</h2>
                        </div>
                        <div class="map-frame">
                            <iframe
                                src="https://www.google.com/maps?q=8%20Beck%20Bagan%20Row%20Success%20Centre%20Building%203rd%20Floor%20Park%20Circus%20Kolkata%20700017&output=embed"
                                width="100%"
                                height="100%"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"
                                title="Vittasetu office location"></iframe>
                        </div>
                    </div>
                </div>

                <aside class="contact-page-side">
                    

                    <div class="card enquiry-form-card">
                        <span class="eyebrow">Enquiry Form</span>
                        <h2>Get in Touch with Our Financial Experts</h2>
                        <p>Fill out the form and we&apos;ll get back to you shortly.</p>

                        <?php if ($form_status): ?>
                            <div class="form-alert <?php echo $form_status === 'success' ? 'form-alert-success' : 'form-alert-error'; ?>">
                                <?php echo htmlspecialchars($form_message, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; ?>

                        <form method="post" class="contact-enquiry-form">
                            <input type="text" name="full_name" placeholder="Full Name" value="<?php echo htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="tel" name="mobile" placeholder="Phone Number" value="<?php echo htmlspecialchars($_POST['mobile'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="email" name="email" placeholder="Email Address" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <select name="service">
                                <option value="">Requirement</option>
                                <?php
                                $services = [
                                    'Financial Consulting',
                                    'Funding Solutions',
                                    'Investment & Wealth Management',
                                    'Internal Audits & Compliance',
                                    'Bookkeeping & Financial Modelling',
                                    'Virtual CFO Services',
                                    'Financial Health Report',
                                ];
                                $selected_service = $_POST['service'] ?? '';
                                foreach ($services as $service_option) {
                                    $selected = $selected_service === $service_option ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($service_option, ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($service_option, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                                ?>
                            </select>
                            <textarea name="message" placeholder="Message"><?php echo htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <button type="submit" class="btn btn-primary enquiry-submit">Submit Enquiry</button>
                        </form>
                    </div>
                    <div class="card business-hours-card">
                        <span class="eyebrow">Business Hours</span>
                        <h2>We are available to assist you</h2>
                        <div class="hours-list">
                            <div class="hours-row"><strong>Monday - Saturday</strong><span>10 AM - 7 PM</span></div>
                            <div class="hours-row"><strong>Sunday</strong><span>Closed</span></div>
                        </div>
                    </div>
                </aside>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
