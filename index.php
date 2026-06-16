<?php
$page_title = 'Vittasetu | Smart Financial Solutions';
$form_status = null;
$form_message = '';

if (isset($_GET['success']) && $_GET['success'] === '1') {
    $form_status = 'success';
    $form_message = 'Thank you for applying. Our team will contact you shortly.';
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['form_source'] ?? '') === 'home_apply') {
    $full_name = trim($_POST['full_name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $service = trim($_POST['service'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($full_name === '' || $mobile === '' || $email === '' || $service === '' || $message === '') {
        $form_status = 'error';
        $form_message = 'Please fill in all required fields before submitting.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $form_status = 'error';
        $form_message = 'Please enter a valid email address.';
    } else {
        try {
            require __DIR__ . '/db.php';

            $stmt = $pdo->prepare(
                'INSERT INTO leads (full_name, mobile, email, service, message) VALUES (?, ?, ?, ?, ?)'
            );
            $stmt->execute([$full_name, $mobile, $email, $service, $message]);

            header('Location: index.php?success=1#apply');
            exit;
        } catch (Throwable $e) {
            $form_status = 'error';
            $form_message = 'Unable to submit your request right now. Please try again later.';
        }
    }
}

include __DIR__ . '/header.php';
?>

<main id="top" class="landing-page">
    <section class="section hero-section hero-section-home" id="apply">
        <div class="container">
            <div class="grid-2 hero-layout hero-layout-centered">
                <div class="hero-copy">
                    <span class="eyebrow">RBI Registered Partners | Fast Loan Support</span>
                    <h1>Your Trusted Partner for <span class="hero-gradient-text">Smart Financial Solutions</span></h1>
                    <p class="hero-copy-lead">At Vittasetu Services Private Limited, we understand your financial needs and deliver customized funding and advisory solutions at the lowest possible cost.</p>
                    <div class="hero-actions hero-actions-primary">
                        <a href="#apply" class="btn btn-primary">Apply Now</a>
                        <a href="#contact" class="btn btn-secondary">Contact Us</a>
                    </div>
                    <div class="hero-ticker">
                        <div class="hero-ticker-item"><i class="fa-solid fa-circle-check"></i> RBI Registered Partners</div>
                        <div class="hero-ticker-item"><i class="fa-solid fa-circle-check"></i> 12+ Years Expertise</div>
                        <div class="hero-ticker-item"><i class="fa-solid fa-circle-check"></i> Zero Hidden Charges</div>
                        <div class="hero-ticker-item"><i class="fa-solid fa-circle-check"></i> 48-Hour Response</div>
                    </div>
                </div>
                <div class="hero-form-wrap">
                    <div class="card hero-form-card hero-form-card-spacious">
                        <div class="section-title hero-form-title">
                            <span class="eyebrow">Quick Apply Form</span>
                            <h2>Get Expert Financial Assistance Today</h2>
                            <p>Fill in your details and our experts will connect with you shortly.</p>
                        </div>
                        <?php if ($form_status): ?>
                            <div class="form-alert <?php echo $form_status === 'success' ? 'form-alert-success' : 'form-alert-error'; ?>">
                                <?php echo htmlspecialchars($form_message, ENT_QUOTES, 'UTF-8'); ?>
                            </div>
                        <?php endif; ?>
                        <form method="post" class="apply-form hero-apply-form">
                            <input type="hidden" name="form_source" value="home_apply">
                            <input type="text" name="full_name" placeholder="Full Name" class="form-control" value="<?php echo htmlspecialchars($_POST['full_name'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="tel" name="mobile" placeholder="Phone Number" class="form-control" value="<?php echo htmlspecialchars($_POST['mobile'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <input type="email" name="email" placeholder="Email Address" class="form-control form-control-full" value="<?php echo htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                            <select name="service" class="form-control form-control-full">
                                <option value="">Requirement</option>
                                <?php
                                $services = [
                                    'Personal Loan',
                                    'Business Loan',
                                    'Home Loan',
                                    'Loan Against Property',
                                    'Balance Transfer',
                                    'Working Capital Support',
                                    'Financial Advisory',
                                ];
                                $selected_service = $_POST['service'] ?? '';
                                foreach ($services as $service_option) {
                                    $selected = $selected_service === $service_option ? 'selected' : '';
                                    echo '<option value="' . htmlspecialchars($service_option, ENT_QUOTES, 'UTF-8') . '" ' . $selected . '>' . htmlspecialchars($service_option, ENT_QUOTES, 'UTF-8') . '</option>';
                                }
                                ?>
                            </select>
                            <textarea name="message" placeholder="Message" class="form-control form-control-full form-textarea"><?php echo htmlspecialchars($_POST['message'] ?? '', ENT_QUOTES, 'UTF-8'); ?></textarea>
                            <button type="submit" class="btn btn-primary hero-form-submit">Submit</button>
                        </form>
                        <div class="hero-form-bottom">
                            <p class="hero-form-note">Your data is 100% safe and secure.</p>
                            <span class="info-chip">Low EMI Options</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section" style="padding-top:0; padding-bottom:60px;">
        <div class="container">
            <div class="stat-bar">
                <div class="stat-bar-item">
                    <span class="stat-bar-number" data-target="12" data-suffix="+">12+</span>
                    <span class="stat-bar-label">Years Experience</span>
                </div>
                <div class="stat-bar-item">
                    <span class="stat-bar-number" data-target="500" data-suffix="+">500+</span>
                    <span class="stat-bar-label">Clients Served</span>
                </div>
                <div class="stat-bar-item">
                    <span class="stat-bar-number" data-target="7" data-suffix="+">7+</span>
                    <span class="stat-bar-label">Financial Services</span>
                </div>
                <div class="stat-bar-item">
                    <span class="stat-bar-number" data-target="98" data-suffix="%">98%</span>
                    <span class="stat-bar-label">Client Satisfaction</span>
                </div>
            </div>
        </div>
    </section>

    <section class="section about-section about-section-home" id="about">
        <div class="container">
            <div class="about-grid">
                <div>
                    <span class="eyebrow">About Company</span>
                    <h2>About Company</h2>
                    <p>At Vittasetu Services Private Limited, we specialize in providing tailored financial consulting and funding solutions for individuals and businesses. Founded by experienced Chartered Accountants and Company Secretaries, we aim to simplify financial decision-making with transparency, efficiency, and expert guidance.</p>
                    <p>With a strong foundation in SME and corporate banking, we help you secure the right funding while optimizing your financial health.</p>
                    <div class="feature-grid about-feature-grid">
                        <div class="card feature-card">
                            <h3>Who We Are</h3>
                            <p class="mb-0">A modern finance advisory brand focused on speed, trust, and transparent service.</p>
                        </div>
                        <div class="card feature-card">
                            <h3>What We Do</h3>
                            <p class="mb-0">We connect you with the most suitable lenders and competitive loan solutions.</p>
                        </div>
                        <div class="card feature-card">
                            <h3>Our Vision</h3>
                            <p class="mb-0">To make financial services accessible, transparent, and hassle-free for every Indian.</p>
                        </div>
                        <div class="card feature-card">
                            <h3>Our Promise</h3>
                            <p class="mb-0">Zero hidden charges, honest guidance, and support that stays with you till disbursal.</p>
                        </div>
                    </div>
                </div>
                <div class="grid-2 about-media-grid">
                    <div class="media-frame media-frame-sm">
                        <img src="img/4.jpg" alt="Finance expert assisting client">
                    </div>
                    <div class="media-frame media-frame-sm">
                        <img src="img/5.jpg" alt="Business funding consultation">
                    </div>
                    <div class="media-frame media-frame-wide">
                        <img src="img/6.jpg" alt="Modern financial support team">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="section products-section" id="products">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Our Financial Services</span>
                <h2>Our Financial Services</h2>
                <p>Expert-led advisory and funding solutions designed to strengthen your business decisions and long-term financial health.</p>
            </div>
            <div class="feature-grid services-grid">
                <article class="card service-card">
                    <div class="media-frame service-media">
                    <img src="img/7.jpg" alt="Financial consulting service">
                    </div>
                    <h3>Financial Consulting</h3>
                    <p class="mb-0">Strategic financial planning tailored to your business goals.</p>
                    <a href="financial-consulting.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card">
                    <div class="media-frame service-media">
                        <img src="img/8.jpg" alt="Funding solutions service">
                    </div>
                    <h3>Funding Solutions</h3>
                    <p class="mb-0">Access working capital, term loans, and business financing at competitive rates.</p>
                    <a href="funding-solutions.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card">
                    <div class="media-frame service-media">
                        <img src="img/9.jpg" alt="Investment and wealth management service">
                    </div>
                    <h3>Investment &amp; Wealth Management</h3>
                    <p class="mb-0">Smart investment strategies to grow and protect your wealth.</p>
                    <a href="investment-wealth-management.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card">
                    <div class="media-frame service-media">
                        <img src="img/10.jpg" alt="Internal audits and compliance service">
                    </div>
                    <h3>Internal Audits &amp; Compliance</h3>
                    <p class="mb-0">Ensure financial accuracy and regulatory compliance.</p>
                    <a href="internal-audits-compliance.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card">
                    <div class="media-frame service-media">
                        <img src="img/11.jpg" alt="Bookkeeping and financial modelling service">
                    </div>
                    <h3>Bookkeeping &amp; Financial Modelling</h3>
                    <p class="mb-0">Accurate records and data-driven financial insights.</p>
                    <a href="bookkeeping-financial-modelling.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card">
                    <div class="media-frame service-media">
                        <img src="img/12.jpg" alt="Virtual CFO service">
                    </div>
                    <h3>Virtual CFO Services</h3>
                    <p class="mb-0">Professional CFO-level financial guidance to improve profitability and financial planning.</p>
                    <a href="virtual-services.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
                <article class="card service-card service-card-hidden" data-extra-service hidden>
                    <div class="media-frame service-media">
                        <img src="img/13.jpg" alt="Financial health report service">
                    </div>
                    <h3>Financial Health Report</h3>
                    <p class="mb-0">Detailed financial analysis with actionable business insights.</p>
                    <a href="financial-health-report.php" class="btn btn-secondary product-read-more">Read More</a>
                </article>
            </div>
            <div class="services-cta">
                <button type="button" class="btn btn-primary" data-show-services>Explore More</button>
                <a href="products.php" class="btn btn-primary">Explore All Services</a>
            </div>
        </div>
    </section>

    <section class="section why-section">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Why Choose Us</span>
                <h2>Why Choose Us</h2>
            </div>
            <div class="feature-grid why-grid">
                <div class="card feature-card">
                    <h3>Customized Financial Solutions</h3>
                    <p class="mb-0">Solutions designed around your specific personal or business financial goals.</p>
                </div>
                <div class="card feature-card">
                    <h3>Low-Cost Funding Options</h3>
                    <p class="mb-0">Competitive funding structures focused on reducing your overall borrowing cost.</p>
                </div>
                <div class="card feature-card">
                    <h3>12+ Years of Industry Expertise</h3>
                    <p class="mb-0">Experienced professionals with deep knowledge of banking, advisory, and finance.</p>
                </div>
                <div class="card feature-card">
                    <h3>Transparent &amp; Ethical Practices</h3>
                    <p class="mb-0">Honest advice, clear communication, and a process built on trust.</p>
                </div>
                <div class="card feature-card">
                    <h3>Fast &amp; Time-Bound Execution</h3>
                    <p class="mb-0">Efficient coordination and timely action to keep your financial plans moving.</p>
                </div>
                <div class="card feature-card">
                    <h3>End-to-End Financial Advisory</h3>
                    <p class="mb-0">From planning to execution, we guide you across the full financial journey.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section process-section process-section-home" id="process">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">How It Works</span>
                <h2>How It Works</h2>
                <p>A simple 4-step process designed to move from requirement to execution with clarity and speed.</p>
            </div>
            <div class="steps-grid">
                <div class="card process-card">
                    <div class="process-step-number">01</div>
                    <h3>Share Your Requirement</h3>
                    <p class="mb-0">Tell us your financial or funding needs.</p>
                </div>
                <div class="card process-card">
                    <div class="process-step-number">02</div>
                    <h3>Expert Analysis</h3>
                    <p class="mb-0">Our experts evaluate and design the best solution.</p>
                </div>
                <div class="card process-card">
                    <div class="process-step-number">03</div>
                    <h3>Documentation &amp; Processing</h3>
                    <p class="mb-0">Smooth handling of all formalities.</p>
                </div>
                <div class="card process-card">
                    <div class="process-step-number">04</div>
                    <h3>Approval &amp; Execution</h3>
                    <p class="mb-0">Quick disbursal and implementation.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section testimonial-section" id="testimonials">
        <div class="container">
            <div class="section-title section-title-center">
                <span class="eyebrow">Testimonials</span>
                <h2>Testimonials</h2>
                <p>Client experiences that reflect our professionalism, transparency, and expert financial support.</p>
            </div>
            <div class="testimonial-slider" data-testimonial-slider>
                <div class="testimonial-track" data-testimonial-track>
                    <article class="card testimonial-card" data-testimonial-slide>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="testimonial-user-meta">
                                <h3>Amit Sharma</h3>
                                <p class="testimonial-role">Client Testimonial</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <span class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <p class="testimonial-quote">"Vittasetu helped us secure funding quickly at a very competitive rate. Highly professional team!"</p>
                        </div>
                    </article>

                    <article class="card testimonial-card" data-testimonial-slide>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="testimonial-user-meta">
                                <h3>Priya Mehta</h3>
                                <p class="testimonial-role">Client Testimonial</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <span class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <p class="testimonial-quote">"Excellent financial guidance and transparency throughout the process."</p>
                        </div>
                    </article>

                    <article class="card testimonial-card" data-testimonial-slide>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="testimonial-user-meta">
                                <h3>Rahul Agarwal</h3>
                                <p class="testimonial-role">Client Testimonial</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <span class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <p class="testimonial-quote">"Their team made complex financial planning simple and easy to understand. Great experience working with them."</p>
                        </div>
                    </article>

                    <article class="card testimonial-card" data-testimonial-slide>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="testimonial-user-meta">
                                <h3>Sneha Kapoor</h3>
                                <p class="testimonial-role">Client Testimonial</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <span class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <p class="testimonial-quote">"Fast processing, professional communication, and genuine financial advice. Highly recommended."</p>
                        </div>
                    </article>

                    <article class="card testimonial-card" data-testimonial-slide>
                        <div class="testimonial-user">
                            <div class="testimonial-avatar">
                                <i class="fa-solid fa-user"></i>
                            </div>
                            <div class="testimonial-user-meta">
                                <h3>Arvind Jain</h3>
                                <p class="testimonial-role">Client Testimonial</p>
                            </div>
                        </div>
                        <div class="testimonial-content">
                            <span class="testimonial-stars"><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i></span>
                            <p class="testimonial-quote">"Very supportive team with deep financial expertise. They guided us throughout the funding journey smoothly."</p>
                        </div>
                    </article>
                </div>
            </div>
        </div>
    </section>

    <section class="section cta-section">
        <div class="container">
            <div class="card cta-panel cta-panel-home">
                <div class="grid-2 cta-layout cta-layout-centered">
                    <div class="cta-copy">
                        <span class="eyebrow">Final Call To Action</span>
                        <h2>Need Financial Guidance? Let&apos;s Get Started Today!</h2>
                        <div class="hero-actions cta-actions">
                            <a href="#apply" class="btn btn-primary">Apply Now</a>
                        </div>
                    </div>
                    <div class="cta-visuals">
                        <div class="media-frame cta-main-media">
                            <img src="img/16.jpg" alt="Loan consultation and quick approval support">
                            <div class="floating-badge cta-badge">
                                <strong class="cta-badge-title">Quick Loan Assistance</strong>
                                <p class="cta-badge-copy">Guided support from application to final disbursal with transparent expert help.</p>
                                <div class="btn-row">
                                    <span class="info-chip">48 Hours Response</span>
                                    <span class="info-chip">Zero Confusion</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

<?php include __DIR__ . '/footer.php'; ?>
